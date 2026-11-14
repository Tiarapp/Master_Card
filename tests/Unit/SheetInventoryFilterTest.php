<?php

namespace Tests\Unit;

use App\Services\SheetInventoryFilter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class SheetInventoryFilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.connections.sheet_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'database.default' => 'sheet_test',
        ]);
        DB::setDefaultConnection('sheet_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        Schema::create('TBarang', function (Blueprint $table) {
            $table->string('KodeBrg');
            $table->string('NamaBrg')->nullable();
        });
        Schema::create('TPersediaanConv', function (Blueprint $table) {
            $table->string('KodeBrg');
            $table->decimal('SaldoAkhirP', 12, 3)->nullable();
            $table->decimal('SaldoAkhirS', 12, 3)->nullable();
        });
        DB::table('TBarang')->insert([
            ['KodeBrg' => 'A', 'NamaBrg' => 'Kertas A'],
            ['KodeBrg' => 'B', 'NamaBrg' => 'Kertas B'],
            ['KodeBrg' => 'C', 'NamaBrg' => null],
            ['KodeBrg' => 'D', 'NamaBrg' => '100%_!'],
        ]);
        DB::table('TPersediaanConv')->insert([
            ['KodeBrg' => 'A', 'SaldoAkhirP' => 10.4, 'SaldoAkhirS' => 1.234],
            ['KodeBrg' => 'B', 'SaldoAkhirP' => 1000, 'SaldoAkhirS' => 2.2],
            ['KodeBrg' => 'C', 'SaldoAkhirP' => null, 'SaldoAkhirS' => null],
            ['KodeBrg' => 'D', 'SaldoAkhirP' => -10.6, 'SaldoAkhirS' => 0],
        ]);
    }

    protected function tearDown(): void
    {
        DB::disconnect('sheet_test');
        parent::tearDown();
    }

    private function query()
    {
        return DB::table('TPersediaanConv')
            ->leftJoin('TBarang', 'TPersediaanConv.KodeBrg', '=', 'TBarang.KodeBrg');
    }

    private function result(array $searches): array
    {
        $service = new SheetInventoryFilter();
        return $service->applySearch($this->query(), $service->parseSearch($searches))
            ->orderBy('TPersediaanConv.KodeBrg')->pluck('TPersediaanConv.KodeBrg')->all();
    }

    public function test_combines_searches_for_name_and_displayed_balances(): void
    {
        $this->assertSame(['A'], $this->result(['nama' => 'kertas', 'saldo_primer' => '10', 'saldo_sekunder' => '1.23']));
        $this->assertSame(['B'], $this->result(['saldo_primer' => '1,000', 'saldo_sekunder' => '2.20']));
        $this->assertSame(['D'], $this->result(['saldo_primer' => '-11', 'saldo_sekunder' => '0.00']));
        $this->assertSame(['C'], $this->result(['nama' => '(kosong)', 'saldo_primer' => '(kosong)']));
        $this->assertSame([], $this->result(['nama' => 'tidak ada']));
    }

    public function test_wildcard_characters_are_searched_as_literals(): void
    {
        $this->assertSame(['D'], $this->result(['nama' => '%_!']));
        $this->assertSame([], $this->result(['nama' => '__']));
    }

    public function test_search_filters_all_rows_before_pagination_with_bounded_sql(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $code = 'E' . str_pad($i, 2, '0', STR_PAD_LEFT);
            DB::table('TBarang')->insert(['KodeBrg' => $code, 'NamaBrg' => 'Target ' . $i]);
            DB::table('TPersediaanConv')->insert(['KodeBrg' => $code, 'SaldoAkhirP' => 1000, 'SaldoAkhirS' => 1.23]);
        }
        $service = new SheetInventoryFilter();
        $searches = $service->parseSearch(['nama' => 'target', 'saldo_primer' => '1,000']);
        $query = $service->applySearch($this->query(), $searches);
        $this->assertCount(2, $query->getBindings());
        $this->assertLessThan(1000, strlen($query->toSql()));
        $page = $query->orderBy('TPersediaanConv.KodeBrg')
            ->paginate(20, ['TPersediaanConv.KodeBrg'], 'page', 2)->appends(['search' => $searches]);
        $this->assertSame(25, $page->total());
        $this->assertCount(5, $page->items());
        $this->assertStringContainsString('search%5Bnama%5D=target', $page->url(1));
    }

    public function test_firebird_sql_uses_bounded_bindings_without_distinct_values(): void
    {
        $connection = new \Illuminate\Database\Connection(null, '', '', ['driver' => 'firebird']);
        $connection->setQueryGrammar(new \HarryGulliford\Firebird\Query\Grammars\FirebirdGrammar());
        $query = $connection->table('TPersediaanConv');
        $service = new SheetInventoryFilter();
        $service->applySearch($query, ['nama' => 'Kertas', 'saldo_sekunder' => '2.20']);
        $this->assertCount(2, $query->getBindings());
        $this->assertStringContainsString('CAST(CAST(ROUND(', $query->toSql());
        $this->assertStringNotContainsString(' IN (', $query->toSql());
    }

    public function test_search_rejects_invalid_input(): void
    {
        $this->expectException(ValidationException::class);
        (new SheetInventoryFilter())->parseSearch(['nama' => ['invalid']]);
    }

    public function test_filter_view_compiles_and_keeps_mutation_modal(): void
    {
        $compiled = Blade::compileString(file_get_contents(resource_path('views/admin/barangpembantu/sheet.blade.php')));
        $this->assertStringContainsString('sheet-filter-form', $compiled);
        $this->assertStringContainsString('mutasiModalBpSheet', $compiled);
        $this->assertStringContainsString("route('fb.bp.mutasi')", $compiled);
    }
}

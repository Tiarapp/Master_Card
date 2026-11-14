<?php

namespace Tests\Unit;

use App\Services\SheetInventoryFilter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
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
        ]);
        DB::table('TPersediaanConv')->insert([
            ['KodeBrg' => 'A', 'SaldoAkhirP' => 10.4, 'SaldoAkhirS' => 1.234],
            ['KodeBrg' => 'B', 'SaldoAkhirP' => 10.1, 'SaldoAkhirS' => 2.2],
            ['KodeBrg' => 'C', 'SaldoAkhirP' => null, 'SaldoAkhirS' => null],
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

    private function result(array $input): array
    {
        $filter = new SheetInventoryFilter();
        return $filter->apply($this->query(), $filter->parse($input))
            ->orderBy('TPersediaanConv.KodeBrg')->pluck('TPersediaanConv.KodeBrg')->all();
    }

    public function test_combines_selected_name_and_displayed_rounded_balances(): void
    {
        $input = [
            'nama' => ['mode' => 'include', 'values' => ['"Kertas A"', '"Kertas B"']],
            'saldo_primer' => ['mode' => 'include', 'values' => ['"10"']],
            'saldo_sekunder' => ['mode' => 'include', 'values' => ['"1.23"']],
        ];
        $this->assertSame(['A'], $this->result($input));
        unset($input['saldo_sekunder']);
        $this->assertSame(['A', 'B'], $this->result($input));
    }

    public function test_exclusions_include_null_unless_explicitly_excluded(): void
    {
        $this->assertSame(['B', 'C'], $this->result(['nama' => ['mode' => 'exclude', 'values' => ['"Kertas A"']]]));
        $this->assertSame(['B'], $this->result(['nama' => ['mode' => 'exclude', 'values' => ['"Kertas A"', 'null']]]));
        $this->assertSame(['C'], $this->result(['saldo_primer' => ['mode' => 'include', 'values' => ['null']]]));
        $this->assertSame([], $this->result(['nama' => ['mode' => 'include', 'values' => []]]));
    }

    public function test_filter_options_respect_other_filters_but_not_own(): void
    {
        $filter = new SheetInventoryFilter();
        $filters = $filter->parse([
            'nama' => ['mode' => 'include', 'values' => ['"Kertas A"']],
            'saldo_primer' => ['mode' => 'include', 'values' => ['"10"']],
        ]);
        $names = $filter->apply($this->query(), $filters, 'nama')->pluck('TBarang.NamaBrg')->all();
        $this->assertSame(['Kertas A', 'Kertas B'], $names);
    }

    public function test_invalid_numeric_filter_is_rejected(): void
    {
        $this->expectException(ValidationException::class);
        (new SheetInventoryFilter())->parse(['saldo_primer' => ['mode' => 'include', 'values' => ['"invalid"']]]);
    }

    public function test_filters_are_applied_before_pagination_and_query_parameters_are_retained(): void
    {
        for ($i = 0; $i < 25; $i++) {
            $code = 'D' . str_pad($i, 2, '0', STR_PAD_LEFT);
            DB::table('TBarang')->insert(['KodeBrg' => $code, 'NamaBrg' => 'Kertas A']);
            DB::table('TPersediaanConv')->insert(['KodeBrg' => $code, 'SaldoAkhirP' => 10, 'SaldoAkhirS' => 1.23]);
        }
        $input = ['nama' => ['mode' => 'include', 'values' => ['"Kertas A"']]];
        $filter = new SheetInventoryFilter();
        $page = $filter->apply($this->query(), $filter->parse($input))
            ->orderBy('TPersediaanConv.KodeBrg')->paginate(20, ['TPersediaanConv.KodeBrg'], 'page', 2)
            ->appends(['filters' => $input]);

        $this->assertSame(26, $page->total());
        $this->assertCount(6, $page->items());
        $this->assertStringContainsString('filters%5Bnama%5D%5Bmode%5D=include', $page->url(1));
    }

    public function test_large_inclusions_and_exclusions_are_grouped_correctly(): void
    {
        $values = array_map('json_encode', array_map('strval', range(1000, 1500)));
        $values[] = '"10"';
        $this->assertSame(['A', 'B'], $this->result(['saldo_primer' => ['mode' => 'include', 'values' => $values]]));
        $this->assertSame(['C'], $this->result(['saldo_primer' => ['mode' => 'exclude', 'values' => $values]]));
    }

    public function test_filter_option_query_uses_the_selected_alias(): void
    {
        $filter = new SheetInventoryFilter();
        $values = $filter->apply($this->query(), [])
            ->selectRaw('ROUND("TPersediaanConv"."SaldoAkhirS", 2) as "filter_value"')
            ->distinct()->orderBy('filter_value')->pluck('filter_value')->all();
        $this->assertEquals([null, 1.23, 2.2], $values);
    }

    public function test_filter_view_compiles_and_keeps_mutation_modal(): void
    {
        $compiled = Blade::compileString(file_get_contents(resource_path('views/admin/barangpembantu/sheet.blade.php')));
        $this->assertStringContainsString('sheet-filter-form', $compiled);
        $this->assertStringContainsString('mutasiModalBpSheet', $compiled);
        $this->assertStringContainsString("route('fb.bp.mutasi')", $compiled);
    }
}

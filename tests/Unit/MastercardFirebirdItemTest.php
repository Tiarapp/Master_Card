<?php

namespace Tests\Unit;

use App\Models\Mastercard;
use App\Models\User;
use App\Services\MastercardFirebirdItemService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class MastercardFirebirdItemTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.connections.item_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'database.connections.firebird2' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'database.default' => 'item_test',
        ]);
        DB::setDefaultConnection('item_test');
        $this->assertSame(':memory:', DB::connection('item_test')->getDatabaseName());
        DB::purge('firebird2');
        DB::connection('firebird2')->setPdo(DB::connection('item_test')->getPdo());
        require_once database_path('migrations/2026_11_18_100000_create_mastercard_firebird_generations_table.php');
        (new \CreateMastercardFirebirdGenerationsTable())->up();
        $schema = Schema::connection('item_test');
        $schema->create('TBarangConv', function (Blueprint $table) {
            $table->string('KodeBrg')->unique();
            foreach (['Tujuan', 'JenisProd', 'Eceran', 'Merk', 'Design', 'WeightSheet', 'Packing', 'WeightValue', 'Warna', 'CustNick', 'NamaBrg', 'Satuan'] as $name) {
                $table->string($name);
            }
            foreach (['IsiPerKarton', 'BeratStandart', 'BeratCRT', 'HargaJualRp', 'HargaJualUSD'] as $name) {
                $table->decimal($name, 12, 2);
            }
        });
        $schema->create('TPersediaan', function (Blueprint $table) {
            $table->string('KodeBrg');
            $table->string('Periode');
            foreach (['SaldoAwalCrt', 'SaldoAwalKg', 'SaldoAkhirCrt', 'SaldoAkhirKg'] as $name) {
                $table->integer($name);
            }
        });
        foreach (['TProdConv' => 'B', 'TMerkConv' => '01', 'TWarnaConv' => '0'] as $table => $code) {
            $schema->create($table, function (Blueprint $table) {
                $table->string('Kode');
            });
            DB::connection('item_test')->table($table)->insert(['Kode' => $code]);
        }
        $schema->create('mc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodeBarang')->nullable();
            $table->string('namaBarang');
        });
        $schema->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
        });
        $schema->create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
        });
        $schema->create('user_roles', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('role_id');
        });
        $schema->create('role_permissions', function (Blueprint $table) {
            $table->integer('role_id');
            $table->integer('permission_id');
        });
        $schema->create('tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user');
            $table->string('tipe');
            $table->string('event');
            $table->text('before');
            $table->text('after');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        DB::disconnect('item_test');
        DB::disconnect('firebird2');
        parent::tearDown();
    }

    private function mastercard(): Mastercard
    {
        return new Mastercard(['kodeBarang' => 'LBE.01.01.S05.12340.001', 'namaBarang' => 'Contoh Barang']);
    }

    private function input(): array
    {
        return ['satuan' => 'PCS', 'isi' => '5', 'berat' => '1.2', 'beratcrt' => '6', 'hargajual' => '10', 'hargausd' => '1'];
    }

    public function test_generate_creates_item_and_zero_balance_using_code_components(): void
    {
        $connection = DB::connection('item_test');
        (new MastercardFirebirdItemService())->generate($connection, $this->mastercard(), $this->input());
        $item = $connection->table('TBarangConv')->first();
        $this->assertSame('CONTOH BARANG', $item->NamaBrg);
        $this->assertSame('B', $item->JenisProd);
        $this->assertSame('01', $item->Merk);
        $this->assertSame('05', $item->Packing);
        $this->assertSame('1234', $item->WeightValue);
        $this->assertSame('0', $item->Warna);
        $balance = $connection->table('TPersediaan')->first();
        $this->assertSame(date('m/Y'), $balance->Periode);
        $this->assertSame(0, $balance->SaldoAkhirCrt);
    }

    public function test_fsc_code_is_created_with_matching_eceran(): void
    {
        $connection = DB::connection('item_test');
        $mastercard = $this->mastercard();
        $mastercard->kodeBarang = 'LBF.01.01.S05.12340.001';
        (new MastercardFirebirdItemService())->generate($connection, $mastercard, $this->input());
        $item = $connection->table('TBarangConv')->first();
        $this->assertSame('LBF.01.01.S05.12340.001', $item->KodeBrg);
        $this->assertSame('F', $item->Eceran);
    }

    public function test_other_eceran_code_is_rejected(): void
    {
        $this->expectException(ValidationException::class);
        (new MastercardFirebirdItemService())->parseCode('LBX.01.01.S05.12340.001');
    }

    public function test_duplicate_does_not_change_item_or_balance(): void
    {
        $connection = DB::connection('item_test');
        $service = new MastercardFirebirdItemService();
        $service->generate($connection, $this->mastercard(), $this->input());
        try {
            $service->generate($connection, $this->mastercard(), $this->input());
            $this->fail('Duplikat tidak ditolak.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('sudah ada', $exception->errors()['generate'][0]);
        }
        $this->assertSame(1, $connection->table('TBarangConv')->count());
        $this->assertSame(1, $connection->table('TPersediaan')->count());
    }

    public function test_invalid_code_and_missing_reference_do_not_create_item(): void
    {
        $connection = DB::connection('item_test');
        $service = new MastercardFirebirdItemService();
        foreach (['tidak-valid', 'LDE.01.01.S05.12340.001'] as $code) {
            $mc = $this->mastercard();
            $mc->kodeBarang = $code;
            try {
                $service->generate($connection, $mc, $this->input());
                $this->fail('Kode tidak valid tidak ditolak.');
            } catch (ValidationException $exception) {
                $this->assertNotEmpty($exception->errors());
            }
        }
        $this->assertSame(0, $connection->table('TBarangConv')->count());
    }

    public function test_failed_balance_insert_rolls_back_item(): void
    {
        $connection = DB::connection('item_test');
        Schema::connection('item_test')->drop('TPersediaan');
        Schema::connection('item_test')->create('TPersediaan', function (Blueprint $table) {
            $table->string('KodeBrg');
        });
        try {
            (new MastercardFirebirdItemService())->generate($connection, $this->mastercard(), $this->input());
            $this->fail('Kesalahan insert tidak terjadi.');
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->assertSame(0, $connection->table('TBarangConv')->count());
        }
    }

    public function test_existing_inventory_prevents_creation(): void
    {
        $connection = DB::connection('item_test');
        $connection->table('TPersediaan')->insert([
            'KodeBrg' => 'LBE.01.01.S05.12340.001', 'Periode' => '01/2020',
            'SaldoAwalCrt' => 3, 'SaldoAwalKg' => 4, 'SaldoAkhirCrt' => 3, 'SaldoAkhirKg' => 4,
        ]);
        try {
            (new MastercardFirebirdItemService())->generate($connection, $this->mastercard(), $this->input());
            $this->fail('Persediaan yang sudah ada tidak ditolak.');
        } catch (ValidationException $exception) {
            $this->assertStringContainsString('Persediaan', $exception->errors()['generate'][0]);
        }
        $this->assertSame(0, $connection->table('TBarangConv')->count());
        $this->assertSame(3, $connection->table('TPersediaan')->value('SaldoAkhirCrt'));
    }

    public function test_firebird_without_unique_item_code_index_is_rejected(): void
    {
        $connection = \Mockery::mock(\Illuminate\Database\ConnectionInterface::class);
        $connection->shouldReceive('transaction')->once()->andReturnUsing(function ($callback) {
            return $callback();
        });
        $connection->shouldReceive('getDriverName')->once()->andReturn('firebird');
        $connection->shouldReceive('selectOne')->once()->andReturn(null);
        $this->expectException(ValidationException::class);
        (new MastercardFirebirdItemService())->generate($connection, $this->mastercard(), $this->input());
    }

    public function test_view_compiles_and_route_exists(): void
    {
        $compiled = Blade::compileString(file_get_contents(resource_path('views/admin/mastercard/index_new.blade.php')));
        $this->assertStringContainsString('generateFirebirdModal', $compiled);
        $this->assertStringContainsString("hasMenuAccess('mastercard')", $compiled);
        $this->assertStringContainsString('Sudah digenerate', $compiled);
        $this->assertStringContainsString('Belum tercatat', $compiled);
        $this->assertNotNull(app('router')->getRoutes()->getByName('mastercard.generate_firebird'));
    }

    public function test_list_shows_flag_for_all_mastercards_with_the_generated_code(): void
    {
        DB::table('roles')->insert(['id' => 1, 'slug' => 'mc-user']);
        DB::table('permissions')->insert(['id' => 1, 'slug' => 'mastercard']);
        DB::table('user_roles')->insert(['user_id' => 88006, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        $user = new User(['name' => 'Operator']);
        $user->id = 88006;
        $this->actingAs($user);

        $first = $this->mastercard();
        $first->id = 1;
        $second = $this->mastercard();
        $second->id = 2;
        $other = new Mastercard(['kodeBarang' => 'LBE.01.01.S05.45670.001', 'namaBarang' => 'Lain']);
        $other->id = 3;
        $html = view('admin.mastercard.index_new', [
            'mastercards' => new LengthAwarePaginator([$first, $second, $other], 3, 20),
            'search' => null,
            'generatedCodes' => ['LBE.01.01.S05.12340.001' => 0],
            'errors' => new \Illuminate\Support\ViewErrorBag(),
        ])->render();

        $this->assertSame(2, substr_count($html, '>Sudah digenerate</span>'));
        $this->assertSame(1, substr_count($html, '>Belum tercatat</span>'));
    }

    public function test_authorized_post_generates_once_and_records_tracking(): void
    {
        DB::table('mc')->insert(['id' => 1, 'kodeBarang' => 'LBE.01.01.S05.12340.001', 'namaBarang' => 'Contoh Barang']);
        DB::table('roles')->insert(['id' => 1, 'slug' => 'mc-user']);
        DB::table('permissions')->insert(['id' => 1, 'slug' => 'mastercard']);
        DB::table('user_roles')->insert(['user_id' => 88001, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        $user = new User(['name' => 'Operator']);
        $user->id = 88001;
        $input = $this->input() + ['confirmed_kode' => 'LBE.01.01.S05.12340.001', 'confirmed_nama' => 'Contoh Barang'];
        $this->actingAs($user)->from('/mastercard')->post(route('mastercard.generate_firebird', 1), $input)
            ->assertRedirect('/mastercard')->assertSessionHas('generate_success');
        $this->assertSame(1, DB::table('tracking')->count());
        $this->assertSame(1, DB::table('TBarangConv')->count());
        $record = DB::table('mastercard_firebird_generations')->first();
        $this->assertSame('LBE.01.01.S05.12340.001', $record->kode_barang);
        $this->assertSame(1, $record->mastercard_id);
        $this->assertSame(88001, $record->user_id);
        $this->assertNotNull($record->generated_at);
        $this->actingAs($user)->from('/mastercard')->post(route('mastercard.generate_firebird', 1), $input)
            ->assertSessionHasErrors('generate');
        $this->assertSame(1, DB::table('TPersediaan')->count());
        $this->assertSame(1, DB::table('mastercard_firebird_generations')->count());
    }

    public function test_user_without_mastercard_permission_cannot_generate(): void
    {
        DB::table('roles')->insert(['id' => 1, 'slug' => 'other']);
        DB::table('user_roles')->insert(['user_id' => 88002, 'role_id' => 1]);
        $user = new User(['name' => 'Operator']);
        $user->id = 88002;
        $this->actingAs($user)->post(route('mastercard.generate_firebird', 1), $this->input())->assertForbidden();
        $this->assertSame(0, DB::table('TBarangConv')->count());
        $this->assertSame(0, DB::table('mastercard_firebird_generations')->count());
    }

    public function test_stale_confirmation_does_not_create_item(): void
    {
        DB::table('mc')->insert(['id' => 1, 'kodeBarang' => 'LBE.01.01.S05.12340.001', 'namaBarang' => 'Contoh Barang']);
        DB::table('roles')->insert(['id' => 1, 'slug' => 'mc-user']);
        DB::table('permissions')->insert(['id' => 1, 'slug' => 'mastercard']);
        DB::table('user_roles')->insert(['user_id' => 88003, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        $user = new User(['name' => 'Operator']);
        $user->id = 88003;
        $this->actingAs($user)->from('/mastercard')->post(route('mastercard.generate_firebird', 1),
            $this->input() + ['confirmed_kode' => 'kode-lama', 'confirmed_nama' => 'Contoh Barang'])
            ->assertSessionHasErrors('generate');
        $this->assertSame(0, DB::table('TBarangConv')->count());
        $this->assertSame(0, DB::table('mastercard_firebird_generations')->count());
    }

    public function test_existing_code_in_another_mastercard_cannot_be_generated_again(): void
    {
        DB::table('mc')->insert(['id' => 2, 'kodeBarang' => 'LBE.01.01.S05.12340.001', 'namaBarang' => 'Contoh Barang']);
        DB::table('roles')->insert(['id' => 1, 'slug' => 'mc-user']);
        DB::table('permissions')->insert(['id' => 1, 'slug' => 'mastercard']);
        DB::table('user_roles')->insert(['user_id' => 88004, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        DB::table('mastercard_firebird_generations')->insert([
            'kode_barang' => 'LBE.01.01.S05.12340.001', 'mastercard_id' => 1, 'user_id' => 88001, 'generated_at' => now(),
        ]);
        $user = new User(['name' => 'Operator']);
        $user->id = 88004;
        $this->actingAs($user)->from('/mastercard')->post(route('mastercard.generate_firebird', 2),
            $this->input() + ['confirmed_kode' => 'LBE.01.01.S05.12340.001', 'confirmed_nama' => 'Contoh Barang'])
            ->assertSessionHasErrors('generate');
        $this->assertSame(0, DB::table('TBarangConv')->count());
        $this->assertSame(1, DB::table('mastercard_firebird_generations')->count());
    }

    public function test_failure_to_store_flag_warns_that_firebird_item_was_created(): void
    {
        DB::table('mc')->insert(['id' => 1, 'kodeBarang' => 'LBE.01.01.S05.12340.001', 'namaBarang' => 'Contoh Barang']);
        DB::table('roles')->insert(['id' => 1, 'slug' => 'mc-user']);
        DB::table('permissions')->insert(['id' => 1, 'slug' => 'mastercard']);
        DB::table('user_roles')->insert(['user_id' => 88005, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);
        DB::statement("CREATE TRIGGER reject_generation BEFORE INSERT ON mastercard_firebird_generations BEGIN SELECT RAISE(FAIL, 'test failure'); END");
        $user = new User(['name' => 'Operator']);
        $user->id = 88005;
        $this->actingAs($user)->from('/mastercard')->post(route('mastercard.generate_firebird', 1),
            $this->input() + ['confirmed_kode' => 'LBE.01.01.S05.12340.001', 'confirmed_nama' => 'Contoh Barang'])
            ->assertSessionHas('generate_warning');
        $this->assertSame(1, DB::table('TBarangConv')->count());
        $this->assertSame(0, DB::table('mastercard_firebird_generations')->count());
    }
}

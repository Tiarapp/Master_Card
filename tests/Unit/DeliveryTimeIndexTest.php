<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DeliveryTimeIndexTest extends TestCase
{
    private $viewRoot;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.connections.dt_test' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
            'database.default' => 'dt_test',
        ]);
        DB::setDefaultConnection('dt_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());

        Schema::create('dt', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kontrak_m_id')->nullable();
            $table->string('kodeKontrak')->nullable();
            $table->string('opi')->nullable();
            $table->string('tglKirimDt')->nullable();
            $table->integer('pcsDt')->nullable();
            $table->string('dt_perubahan')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('alasan_reject')->nullable();
            $table->integer('approve_mkt')->default(0);
            $table->integer('approve_ppic')->default(0);
            $table->timestamps();
        });
        Schema::create('kontrak_m', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->string('customer_name')->nullable();
        });
        Schema::create('mc', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namaBarang')->nullable();
        });
        Schema::create('opi_m', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('dt_id')->nullable();
            $table->unsignedInteger('kontrak_m_id')->nullable();
            $table->unsignedInteger('mc_id')->nullable();
            $table->string('NoOPI')->nullable();
            $table->string('nama')->nullable();
            $table->string('status_opi')->nullable();
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('parent_slug')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
        });
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
        });
        DB::table('roles')->insert(['id' => 1, 'name' => 'PPIC', 'slug' => 'test-ppic']);
        DB::table('permissions')->insert([
            'id' => 1, 'name' => 'Approval Perubahan DT', 'slug' => 'ppic.dt_approval', 'parent_slug' => 'ppic',
        ]);
        DB::table('user_roles')->insert(['user_id' => 2, 'role_id' => 1]);
        DB::table('role_permissions')->insert(['role_id' => 1, 'permission_id' => 1]);

        $this->viewRoot = sys_get_temp_dir() . '/dt-view-test-' . bin2hex(random_bytes(8));
        mkdir($this->viewRoot . '/admin/templates/partials', 0777, true);
        file_put_contents($this->viewRoot . '/admin/templates/partials/default.blade.php', "@yield('content')\n@yield('javascripts')");
        app('view')->getFinder()->prependLocation($this->viewRoot);
        app('view')->getFinder()->flush();

        $user = new User(['name' => 'Test']);
        $user->id = 1;
        $this->actingAs($user);
    }

    protected function tearDown(): void
    {
        unlink($this->viewRoot . '/admin/templates/partials/default.blade.php');
        rmdir($this->viewRoot . '/admin/templates/partials');
        rmdir($this->viewRoot . '/admin/templates');
        rmdir($this->viewRoot . '/admin');
        rmdir($this->viewRoot);
        DB::disconnect('dt_test');
        parent::tearDown();
    }

    private function insertDeliveryTime(array $attributes = []): void
    {
        $attributes = array_merge([
            'kontrak_m_id' => 20454,
            'kodeKontrak' => 'SPA/263/01/2026',
            'opi' => '00001F',
            'tglKirimDt' => '2026-01-05',
            'pcsDt' => 100,
            'approve_mkt' => 0,
            'approve_ppic' => 1,
            'created_at' => '2026-01-01 10:00:00',
            'updated_at' => '2026-01-01 10:00:00',
        ], $attributes);
        $id = DB::table('dt')->insertGetId($attributes);
        DB::table('opi_m')->insert([
            'id' => $id + 1000,
            'dt_id' => $id,
            'kontrak_m_id' => $attributes['kontrak_m_id'],
            'NoOPI' => $attributes['opi'],
            'nama' => $attributes['opi'],
            'status_opi' => 'Proses',
            'created_at' => $attributes['created_at'],
            'updated_at' => $attributes['updated_at'],
        ]);
    }

    public function test_index_renders_data_actions_and_paginated_results(): void
    {
        for ($i = 1; $i <= 21; $i++) {
            $this->insertDeliveryTime([
                'kodeKontrak' => 'KONTRAK-' . $i,
                'created_at' => sprintf('2026-01-%02d 10:00:00', $i),
            ]);
        }

        $this->get(route('dt'))
            ->assertOk()
            ->assertSee('Data Delivery Time')
            ->assertSee('21 Total Records')
            ->assertSee('KONTRAK-21')
            ->assertDontSee('KONTRAK-1</td>', false)
            ->assertSee('00001F')
            ->assertDontSee('Need Approve PPIC')
            ->assertSee(route('dt.edit', 21))
            ->assertDontSee(route('dt.edit', 1021))
            ->assertSee('Menampilkan 1 - 10')
            ->assertSee('dari 21 hasil');

        $this->get(route('dt', ['page' => 2]))
            ->assertOk()
            ->assertSee('KONTRAK-11')
            ->assertSee('Menampilkan 11 - 20')
            ->assertSee('dari 21 hasil');
    }

    public function test_search_matches_contract_code_opi_and_contract_id(): void
    {
        $this->insertDeliveryTime();
        $this->insertDeliveryTime(['kontrak_m_id' => 99, 'kodeKontrak' => 'LAIN', 'opi' => '99999F']);

        foreach (['SPA/263', '00001F', '20454'] as $search) {
            $this->get(route('dt', ['search' => $search]))
                ->assertOk()
                ->assertSee('SPA/263/01/2026')
                ->assertDontSee('LAIN');
        }

        $this->get(route('dt', ['search' => 'tidak-ada']))
            ->assertOk()
            ->assertSee('Tidak ada OPI berstatus proses ditemukan')
            ->assertSee('Lihat Semua Data');
    }

    public function test_ppic_approval_is_only_shown_for_changed_dt_that_is_not_approved(): void
    {
        $this->insertDeliveryTime(['opi' => 'DT-NULL', 'dt_perubahan' => null, 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'DT-PENDING', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'DT-APPROVED', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 1]);

        $this->get(route('dt', ['search' => 'DT-NULL']))
            ->assertOk()->assertDontSee('Need Approve PPIC')->assertSee(route('dt.edit', 1));
        $this->get(route('dt', ['search' => 'DT-PENDING']))
            ->assertOk()->assertSee('Need Approve PPIC')->assertDontSee(route('dt.approve', 2))
            ->assertDontSee(route('dt.edit', 2));
        $this->get(route('dt', ['search' => 'DT-APPROVED']))
            ->assertOk()->assertDontSee('Need Approve PPIC')->assertSee(route('dt.edit', 3));
    }

    public function test_only_process_opis_are_listed_and_multiple_opis_for_one_dt_are_separate(): void
    {
        $this->insertDeliveryTime();
        foreach ([
            ['NoOPI' => 'OPI-PROSES-2', 'status_opi' => 'Proses'],
            ['NoOPI' => 'OPI-CLOSED', 'status_opi' => 'closed'],
            ['NoOPI' => 'OPI-PENDING', 'status_opi' => 'Pending'],
            ['NoOPI' => 'OPI-CANCEL', 'status_opi' => 'Cancel'],
        ] as $opi) {
            DB::table('opi_m')->insert(array_merge([
                'dt_id' => 1,
                'kontrak_m_id' => 20454,
                'created_at' => '2026-01-02 10:00:00',
                'updated_at' => '2026-01-02 10:00:00',
            ], $opi));
        }

        $this->get(route('dt'))->assertOk()
            ->assertSee('2 Total Records')
            ->assertSee('00001F')
            ->assertSee('OPI-PROSES-2')
            ->assertDontSee('OPI-CLOSED')
            ->assertDontSee('OPI-PENDING')
            ->assertDontSee('OPI-CANCEL');
        $this->get(route('dt', ['search' => 'OPI-CLOSED']))
            ->assertOk()->assertSee('Tidak ada OPI berstatus proses ditemukan');
    }

    public function test_process_opi_without_dt_is_visible_without_dt_actions(): void
    {
        DB::table('kontrak_m')->insert(['id' => 4, 'kode' => 'KONTRAK-ORPHAN']);
        DB::table('opi_m')->insert([
            'dt_id' => 999,
            'kontrak_m_id' => 4,
            'NoOPI' => 'OPI-ORPHAN',
            'status_opi' => 'Proses',
            'created_at' => '2026-01-01 10:00:00',
            'updated_at' => '2026-01-01 10:00:00',
        ]);
        $this->get(route('dt', ['search' => 'KONTRAK-ORPHAN']))
            ->assertOk()->assertSee('OPI-ORPHAN')->assertSee('DT tidak tersedia')
            ->assertDontSee(route('dt.edit', 999));
    }

    public function test_edit_modal_contains_selected_dt_values_and_update_route(): void
    {
        $this->insertDeliveryTime([
            'kodeKontrak' => 'KONTRAK-TEST',
            'pcsDt' => 234,
            'dt_perubahan' => '2026-02-10',
            'approve_ppic' => 1,
        ]);

        $this->get(route('dt'))
            ->assertOk()
            ->assertSee('data-target="#edit-dt-modal"', false)
            ->assertSee('data-update-url="' . route('dt.update', 1) . '"', false)
            ->assertSee('data-kontrak="KONTRAK-TEST"', false)
            ->assertSee('data-tanggal="2026-02-10"', false)
            ->assertSee('data-perubahan="2026-02-10"', false)
            ->assertSee('data-qty="234"', false)
            ->assertSee('name="dt_perubahan"', false)
            ->assertSee('name="pcsDt"', false);
    }

    public function test_modal_update_returns_to_filtered_list_and_saves_dt(): void
    {
        $this->insertDeliveryTime();
        $listUrl = route('dt', ['search' => '00001F', 'page' => 2]);

        $this->from($listUrl)->put(route('dt.update', 1), [
            'from_dt_list' => '1',
            'kontrak' => 'SPA/263/01/2026',
            'dt_perubahan' => '2026-02-12',
            'pcsDt' => '250',
        ])->assertRedirect($listUrl)->assertSessionHas('success');

        $deliveryTime = DB::table('dt')->where('id', 1)->first();
        $this->assertSame('2026-02-12', $deliveryTime->dt_perubahan);
        $this->assertSame(250, $deliveryTime->pcsDt);
        $this->assertSame('2026-01-05', $deliveryTime->tglKirimDt);
    }

    public function test_original_edit_page_update_still_redirects_to_dt_list(): void
    {
        $this->insertDeliveryTime();

        $this->from(route('dt.edit', 1))->put(route('dt.update', 1), [
            'kontrak' => 'SPA/263/01/2026',
            'dt_perubahan' => '2026-02-12',
            'pcsDt' => '250',
        ])->assertRedirect(url('admin/dt'));
    }

    private function actAsPpic(): void
    {
        $user = new User(['name' => 'Petugas PPIC', 'divisi_id' => 5]);
        $user->id = 2;
        $this->actingAs($user);
    }

    public function test_ppic_list_shows_only_process_opis_with_pending_dt_change(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['opi' => 'MENUNGGU', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'DISETUJUI', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 1]);
        $this->insertDeliveryTime(['opi' => 'TANPA-DT', 'dt_perubahan' => null, 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'TERTUTUP', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        DB::table('opi_m')->where('NoOPI', 'TERTUTUP')->update(['status_opi' => 'closed']);

        $this->get(route('ppic.dt.approval'))->assertOk()
            ->assertSee('1 Total Records')->assertSee('MENUNGGU')
            ->assertSee(route('ppic.dt.approve', 1001))
            ->assertDontSee('DISETUJUI')->assertDontSee('TANPA-DT')->assertDontSee('TERTUTUP');
        $this->get(route('ppic.dt.approval', ['search' => 'tidak-ada']))
            ->assertOk()->assertSee('Tidak ada OPI yang menunggu approval PPIC');
    }

    public function test_ppic_list_displays_customer_and_product_instead_of_contract_code(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        DB::table('kontrak_m')->insert(['id' => 20454, 'kode' => 'KONTRAK-123', 'customer_name' => 'Customer Contoh']);
        DB::table('mc')->insert(['id' => 30, 'namaBarang' => 'Barang Contoh']);
        DB::table('opi_m')->where('id', 1001)->update(['mc_id' => 30]);

        $this->get(route('ppic.dt.approval'))->assertOk()
            ->assertSee('<td>Customer Contoh</td>', false)
            ->assertSee('<td>Barang Contoh</td>', false)
            ->assertDontSee('<td>SPA/263/01/2026</td>', false);
    }

    public function test_ppic_list_handles_missing_customer_and_product(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $this->get(route('ppic.dt.approval'))->assertOk()
            ->assertSee('<td>-</td>', false);
    }

    public function test_ppic_can_approve_once_and_pending_list_is_updated(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $values = ['dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100'];
        $list = route('ppic.dt.approval');

        $this->from($list)->post(route('ppic.dt.approve', 1001), $values)
            ->assertRedirect($list)->assertSessionHas('success');
        $this->assertSame(1, DB::table('dt')->where('id', 1)->value('approve_ppic'));
        $this->get($list)->assertOk()->assertSee('Tidak ada OPI yang menunggu approval PPIC');
        $this->from($list)->post(route('ppic.dt.approve', 1001), $values)
            ->assertRedirect($list)->assertSessionHas('error');
    }

    public function test_ppic_approval_rejects_stale_or_non_process_data(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $values = ['dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100'];
        $list = route('ppic.dt.approval');
        DB::table('dt')->where('id', 1)->update(['pcsDt' => 200]);
        $this->from($list)->post(route('ppic.dt.approve', 1001), $values)->assertSessionHas('error');
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
        DB::table('opi_m')->where('id', 1001)->update(['status_opi' => 'closed']);
        $this->post(route('ppic.dt.approve', 1001), $values)->assertNotFound();
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
    }

    public function test_non_ppic_cannot_access_or_approve(): void
    {
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $this->get(route('ppic.dt.approval'))->assertForbidden();
        $this->post(route('ppic.dt.approve', 1001), [
            'dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100',
        ])->assertForbidden();
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
    }

    public function test_non_ppic_new_change_requires_ppic_approval_again(): void
    {
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 1]);
        $this->put(route('dt.update', 1), [
            'kontrak' => 'SPA/263/01/2026',
            'dt_perubahan' => '2026-02-02',
            'pcsDt' => '100',
        ])->assertRedirect(url('admin/dt'));
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
        $this->actAsPpic();
        $this->get(route('ppic.dt.approval'))->assertOk()->assertSee('00001F');
    }

    public function test_pending_list_paginates_and_preserves_search(): void
    {
        $this->actAsPpic();
        for ($i = 1; $i <= 11; $i++) {
            $this->insertDeliveryTime([
                'opi' => 'TEST-' . $i,
                'dt_perubahan' => '2026-02-01',
                'approve_ppic' => 0,
            ]);
        }

        $this->get(route('ppic.dt.approval', ['search' => 'TEST']))
            ->assertOk()->assertSee('11 Total Records')
            ->assertSee('search=TEST&amp;page=2', false);
        $this->get(route('ppic.dt.approval', ['search' => 'TEST', 'page' => 2]))
            ->assertOk()->assertSee('Menampilkan 11 - 11');
    }

    public function test_ppic_can_approve_dt_with_no_updated_timestamp(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        DB::table('dt')->where('id', 1)->update(['updated_at' => null]);

        $this->from(route('ppic.dt.approval'))->post(route('ppic.dt.approve', 1001), [
            'dt_perubahan' => '2026-02-01', 'updated_at' => null, 'pcsDt' => '100',
        ])->assertSessionHas('success');
        $this->assertSame(1, DB::table('dt')->where('id', 1)->value('approve_ppic'));
    }

    public function test_ppic_without_role_permission_cannot_access_or_approve(): void
    {
        $user = new User(['name' => 'PPIC Tanpa Izin', 'divisi_id' => 5]);
        $user->id = 50;
        $this->actingAs($user);
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);

        $this->get(route('ppic.dt.approval'))->assertForbidden();
        $this->post(route('ppic.dt.approve', 1001), [
            'dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100',
        ])->assertForbidden();
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
    }

    public function test_parent_ppic_permission_includes_dt_approval(): void
    {
        DB::table('permissions')->insert(['id' => 2, 'name' => 'PPIC', 'slug' => 'ppic']);
        DB::table('user_roles')->insert(['user_id' => 51, 'role_id' => 2]);
        DB::table('roles')->insert(['id' => 2, 'name' => 'PPIC Induk', 'slug' => 'test-ppic-parent']);
        DB::table('role_permissions')->insert(['role_id' => 2, 'permission_id' => 2]);
        $user = new User(['name' => 'PPIC Induk', 'divisi_id' => 5]);
        $user->id = 51;
        $this->actingAs($user);

        $this->get(route('ppic.dt.approval'))->assertOk();
    }

    public function test_approval_permission_seeder_preserves_existing_role_permissions(): void
    {
        DB::table('permissions')->delete();
        (new \Database\Seeders\PpicDtApprovalPermissionSeeder())->run();
        (new \Database\Seeders\PpicDtApprovalPermissionSeeder())->run();
        $this->assertSame(1, DB::table('permissions')->where('slug', 'ppic.dt_approval')->count());
        $this->assertSame('ppic', DB::table('permissions')->where('slug', 'ppic.dt_approval')->value('parent_slug'));
        $this->assertSame(1, DB::table('role_permissions')->count());
    }

    public function test_marketing_can_update_without_marketing_approval(): void
    {
        $user = new User(['name' => 'Marketing', 'divisi_id' => 3]);
        $user->id = 3;
        $this->actingAs($user);
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 1, 'approve_mkt' => 0]);

        $this->put(route('dt.update', 1), [
            'kontrak' => 'SPA/263/01/2026',
            'dt_perubahan' => '2026-02-02',
            'pcsDt' => '100',
        ])->assertRedirect(url('admin/dt'));
        $dt = DB::table('dt')->where('id', 1)->first();
        $this->assertSame(0, $dt->approve_mkt);
        $this->assertSame(0, $dt->approve_ppic);
        $this->get(route('dt.approve', 1))->assertForbidden();
    }

    public function test_old_ppic_approval_link_redirects_without_changing_data(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);

        $this->get(route('dt.approve', 1))->assertRedirect(route('ppic.dt.approval'));
        $this->assertSame(0, DB::table('dt')->where('id', 1)->value('approve_ppic'));
    }

    public function test_reject_popup_and_submission_preserve_original_note_and_show_reason(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime([
            'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0, 'keterangan' => 'Catatan pengajuan',
        ]);
        $this->get(route('ppic.dt.approval'))->assertOk()
            ->assertSee('data-target="#reject-dt-modal"', false)
            ->assertSee(route('ppic.dt.reject', 1001))
            ->assertSee('name="alasan_reject"', false);

        $this->from(route('ppic.dt.approval'))->post(route('ppic.dt.reject', 1001), [
            'dt_perubahan' => '2026-02-01',
            'updated_at' => '2026-01-01 10:00:00',
            'pcsDt' => '100',
            'alasan_reject' => 'Jadwal produksi penuh',
        ])->assertSessionHas('success');

        $dt = DB::table('dt')->where('id', 1)->first();
        $this->assertNull($dt->dt_perubahan);
        $this->assertSame('Catatan pengajuan', $dt->keterangan);
        $this->assertSame('Jadwal produksi penuh', $dt->alasan_reject);
        $this->assertSame(0, $dt->approve_ppic);
        $this->get(route('ppic.dt.approval'))->assertDontSee('00001F');
        $this->get(route('dt'))->assertSee('Jadwal produksi penuh')->assertSee(route('dt.edit', 1));
    }

    public function test_reject_requires_reason_and_rejects_stale_or_unauthorized_requests(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $data = ['dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100'];
        $this->from(route('ppic.dt.approval'))->post(route('ppic.dt.reject', 1001), $data)
            ->assertSessionHasErrors('alasan_reject');
        $this->assertSame('2026-02-01', DB::table('dt')->where('id', 1)->value('dt_perubahan'));
        DB::table('dt')->where('id', 1)->update(['pcsDt' => 200]);
        $data['alasan_reject'] = 'Tidak sesuai kapasitas';
        $this->from(route('ppic.dt.approval'))->post(route('ppic.dt.reject', 1001), $data)
            ->assertSessionHas('error');
        $this->assertSame('2026-02-01', DB::table('dt')->where('id', 1)->value('dt_perubahan'));
        $user = new User(['name' => 'Marketing', 'divisi_id' => 3]);
        $user->id = 3;
        $this->actingAs($user);
        $this->post(route('ppic.dt.reject', 1001), $data)->assertForbidden();
    }

    public function test_new_submission_clears_previous_rejection_reason(): void
    {
        $this->insertDeliveryTime([
            'dt_perubahan' => null, 'approve_ppic' => 0, 'alasan_reject' => 'Jadwal penuh',
        ]);
        $this->put(route('dt.update', 1), [
            'kontrak' => 'SPA/263/01/2026', 'dt_perubahan' => '2026-02-03',
            'pcsDt' => '100', 'keterangan' => 'Pengajuan ulang',
        ])->assertRedirect(url('admin/dt'));
        $dt = DB::table('dt')->where('id', 1)->first();
        $this->assertNull($dt->alasan_reject);
        $this->assertSame(0, $dt->approve_ppic);
    }

    public function test_dt_notification_matches_pending_opi_list_and_updates_after_approval(): void
    {
        $this->actAsPpic();
        $this->insertDeliveryTime(['opi' => 'PENDING-1', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'APPROVED', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 1]);
        $this->insertDeliveryTime(['opi' => 'NO-CHANGE', 'dt_perubahan' => null, 'approve_ppic' => 0]);
        $this->insertDeliveryTime(['opi' => 'CLOSED', 'dt_perubahan' => '2026-02-01', 'approve_ppic' => 0]);
        DB::table('opi_m')->where('NoOPI', 'CLOSED')->update(['status_opi' => 'closed']);
        DB::table('opi_m')->insert([
            'id' => 2000, 'dt_id' => 1, 'NoOPI' => 'PENDING-2', 'status_opi' => 'Proses',
        ]);

        $this->get(route('ppic.dt.approval'))->assertOk()->assertSee('2 Total Records');
        $this->getJson(route('notif.dt_approval'))->assertOk()->assertExactJson([
            'count' => 2, 'url' => route('ppic.dt.approval'),
        ]);

        $this->from(route('ppic.dt.approval'))->post(route('ppic.dt.approve', 1001), [
            'dt_perubahan' => '2026-02-01', 'updated_at' => '2026-01-01 10:00:00', 'pcsDt' => '100',
        ])->assertSessionHas('success');
        $this->getJson(route('notif.dt_approval'))->assertOk()->assertJsonPath('count', 0);
    }

    public function test_dt_notification_requires_approval_permission_and_division(): void
    {
        $this->getJson(route('notif.dt_approval'))->assertForbidden();
        $user = new User(['name' => 'PPIC Tanpa Izin', 'divisi_id' => 5]);
        $user->id = 50;
        $this->actingAs($user);
        $this->getJson(route('notif.dt_approval'))->assertForbidden();
    }
}

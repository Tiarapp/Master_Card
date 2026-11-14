<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LogistikSidebarPermissionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'database.connections.sidebar_test' => ['driver' => 'sqlite', 'database' => ':memory:', 'prefix' => ''],
            'database.default' => 'sidebar_test',
        ]);
        DB::setDefaultConnection('sidebar_test');
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
        });
        Schema::create('user_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');
        });
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');
        });
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'PPC', 'slug' => 'ppc'],
            ['id' => 2, 'name' => 'Inventory', 'slug' => 'inventory'],
            ['id' => 3, 'name' => 'Logistik', 'slug' => 'logistik'],
        ]);
        DB::table('permissions')->insert([
            ['id' => 1, 'slug' => 'logistik.bp_baru'],
            ['id' => 2, 'slug' => 'inventory.inventory'],
            ['id' => 3, 'slug' => 'logistik'],
        ]);
        DB::table('user_roles')->insert([
            ['user_id' => 81001, 'role_id' => 1],
            ['user_id' => 81002, 'role_id' => 2],
            ['user_id' => 81003, 'role_id' => 3],
        ]);
        DB::table('role_permissions')->insert([
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 2, 'permission_id' => 2],
            ['role_id' => 3, 'permission_id' => 3],
        ]);
    }

    protected function tearDown(): void
    {
        DB::disconnect('sidebar_test');
        parent::tearDown();
    }

    private function sidebarFor(int $userId): string
    {
        $user = new User(['name' => 'Test']);
        $user->id = $userId;
        $this->actingAs($user);

        return view('admin.templates.partials._sidebar')->render();
    }

    public function test_logistik_child_permission_displays_logistik_without_inventory(): void
    {
        $sidebar = $this->sidebarFor(81001);
        $this->assertStringContainsString('>Logistik ', $sidebar);
        $this->assertStringContainsString('>BP Baru<', $sidebar);
        $this->assertStringNotContainsString('>BP Lama<', $sidebar);
        $this->assertStringNotContainsString('>Inventory Management ', $sidebar);
    }

    public function test_inventory_permission_does_not_display_logistik(): void
    {
        $sidebar = $this->sidebarFor(81002);
        $this->assertStringContainsString('>Inventory Management ', $sidebar);
        $this->assertStringNotContainsString('>Logistik ', $sidebar);
    }

    public function test_logistik_parent_permission_displays_its_children(): void
    {
        $sidebar = $this->sidebarFor(81003);
        $this->assertStringContainsString('>Logistik ', $sidebar);
        $this->assertStringContainsString('>BP Baru<', $sidebar);
        $this->assertStringContainsString('>BP Lama<', $sidebar);
        $this->assertStringNotContainsString('>Inventory Management ', $sidebar);
    }
}

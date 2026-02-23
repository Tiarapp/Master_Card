# Dokumentasi Sistem Sidebar Multi-Company

## Overview
Sistem sidebar multi-company adalah implementasi untuk memisahkan menu navigasi berdasarkan company yang berbeda dalam aplikasi Master Card. Sistem ini memungkinkan setiap company memiliki menu dan fitur yang spesifik sesuai dengan kebutuhan bisnis mereka.

## Struktur Company

### Company 1: PT. SPA (Corrugated Box)
- **ID**: 1
- **Fokus**: Manufaktur kotak karton bergelombang
- **Menu Khusus**: Box Design, Cutting Patterns, Corrugated Production

### Company 2: PT. SPA (Tissue Manufacturing)
- **ID**: 2
- **Fokus**: Manufaktur tissue dan produk kertas
- **Menu Khusus**: Paper Roll Management, Converting Process, Tissue Inventory

## Struktur Database

### Tabel Companies
```sql
CREATE TABLE companies (
    id BIGINT UNSIGNED PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NULL,
    phone VARCHAR(255) NULL,
    email VARCHAR(255) NULL,
    logo VARCHAR(255) NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Tabel Menu Permissions
```sql
CREATE TABLE menu_permissions (
    id BIGINT UNSIGNED PRIMARY KEY,
    company_id BIGINT UNSIGNED NOT NULL,
    divisi_id BIGINT UNSIGNED NOT NULL,
    menu_key VARCHAR(255) NOT NULL,
    menu_name VARCHAR(255) NOT NULL,
    route_name VARCHAR(255) NULL,
    icon VARCHAR(255) NULL,
    parent_menu VARCHAR(255) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    order INTEGER DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY unique_company_divisi_menu (company_id, divisi_id, menu_key)
);
```

### Tabel Users (Modified)
- Menambahkan kolom `company_id` untuk menghubungkan user dengan company

## Komponen Sistem

### 1. Models

#### Company Model
```php
// File: app/Models/Company.php
class Company extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['name', 'address', 'phone', 'email', 'logo'];
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/companies/' . $this->logo) : null;
    }
}
```

#### MenuPermission Model
```php
// File: app/Models/MenuPermission.php
class MenuPermission extends Model
{
    protected $fillable = [
        'company_id', 'divisi_id', 'menu_key', 'menu_name',
        'route_name', 'icon', 'parent_menu', 'is_active', 'order'
    ];
    
    // Scopes untuk filter menu
    public function scopeActive($query)
    public function scopeForCompanyAndDivisi($query, $companyId, $divisiId)
    public function scopeMainMenus($query)
    public function scopeSubMenus($query, $parentMenu)
}
```

### 2. Services

#### MenuService
```php
// File: app/Services/MenuService.php
class MenuService
{
    public function getMenusForCurrentUser()      // Mendapatkan menu untuk user aktif
    public function getSubMenus($parentMenu)     // Mendapatkan submenu
    public function hasMenuAccess($menuKey)      // Cek akses menu
    public function hasAnyMenuAccess($menuKeys)  // Cek akses multiple menu
    public function getMenuStructure()           // Struktur menu lengkap
}
```

### 3. Helper Functions

#### MenuHelper.php
```php
// File: app/Helpers/MenuHelper.php
function hasMenuAccess($menuKey)                    // Cek akses menu spesifik
function hasAnyMenuAccess($menuKeys)               // Cek akses multiple menu
function getCurrentCompanyName()                   // Nama company user aktif
function getDivisiMenuAccess($divisiIds)          // Cek akses berdasarkan divisi
```

### 4. View Composer

#### MenuComposer
```php
// File: app/Http/View/Composers/MenuComposer.php
class MenuComposer
{
    public function compose(View $view)
    {
        $menuStructure = $this->menuService->getMenuStructure();
        $view->with('menuStructure', $menuStructure);
    }
}
```

## Struktur Sidebar

### Header Section
- **Brand Logo**: Menampilkan nama company secara dinamis
- **User Panel**: Informasi user dan company yang sedang aktif

### Menu Categories

#### 1. Shared Menus (Tersedia untuk Multiple Company)
- **Data Barang**: Manajemen data barang
- **OPI**: Order Production Information
- **Master Card**: Master card management
- **Accounting**: Modul keuangan
- **Logistik**: Manajemen logistik
- **Inventory Management**: Manajemen inventori

#### 2. Company-Specific Menus

##### Company 1 (Corrugated Box)
```blade
@if(Auth::user()->company_id == 1)
    @if (hasMenuAccess('corrugated_production'))
        {{-- Corrugated Production Menu --}}
        - Box Design
        - Cutting Patterns
        - Quality Control
    @endif
@elseif(Auth::user()->company_id == 2)
```

##### Company 2 (Tissue Manufacturing)
```blade
@if (hasMenuAccess('tissue_production'))
    {{-- Tissue Production Menu --}}
    - Paper Roll Management
    - Converting Process
    - Packaging
@endif

@if (hasMenuAccess('tissue_inventory'))
    {{-- Tissue Inventory Menu --}}
    - Raw Materials
    - Finished Goods
@endif

@if (hasMenuAccess('tissue_quality'))
    {{-- Quality Control Menu --}}
@endif

@if (hasMenuAccess('tissue_marketing'))
    {{-- Tissue Marketing Menu --}}
    - Product Catalog
    - Customer Orders
@endif
```

#### 3. Division-Specific Menus
- **PPIC**: Production Planning and Inventory Control
- **Produksi**: Production management
- **QC**: Quality Control
- **Teknik**: Technical division
- **HRD/GA**: Human Resources/General Affairs
- **Reports**: Reporting system

#### 4. Universal Menus
- **Feedback**: System feedback (accessible by all users)
- **Hardware Management**: IT equipment management (IT only)
- **Company Management**: Company switching (IT only)

## Logika Akses Menu

### 1. Hybrid Access Control
```blade
@if ((hasMenuAccess('menu_key') && getDivisiMenuAccess([divisi_ids])) || (!Auth::user()->company_id && getDivisiMenuAccess([divisi_ids])))
    {{-- Menu content --}}
@endif
```

### 2. Company-Specific Access
```blade
@if(Auth::user()->company_id == 1)
    {{-- Company 1 specific menus --}}
@elseif(Auth::user()->company_id == 2)
    {{-- Company 2 specific menus --}}
@endif
```

### 3. Division-Based Access (Legacy Support)
```blade
@if (Auth::user()->divisi_id == 2 || Auth::user()->divisi_id == 3)
    {{-- Division-based menu access --}}
@endif
```

## Konfigurasi Menu Permissions

### Company 1 (Corrugated Box) - Sample Configuration
```php
[
    // Shared menus
    ['company_id' => 1, 'divisi_id' => 2, 'menu_key' => 'barang', 'menu_name' => 'Data Barang'],
    ['company_id' => 1, 'divisi_id' => 3, 'menu_key' => 'opi', 'menu_name' => 'OPI'],
    
    // Company-specific menus
    ['company_id' => 1, 'divisi_id' => 2, 'menu_key' => 'corrugated_production', 'menu_name' => 'Corrugated Production'],
    ['company_id' => 1, 'divisi_id' => 9, 'menu_key' => 'corrugated_production', 'menu_name' => 'Corrugated Production'],
]
```

### Company 2 (Tissue) - Sample Configuration
```php
[
    // Company-specific menus
    ['company_id' => 2, 'divisi_id' => 2, 'menu_key' => 'tissue_production', 'menu_name' => 'Tissue Production'],
    ['company_id' => 2, 'divisi_id' => 6, 'menu_key' => 'tissue_inventory', 'menu_name' => 'Tissue Inventory'],
    ['company_id' => 2, 'divisi_id' => 5, 'menu_key' => 'tissue_quality', 'menu_name' => 'Quality Control'],
    ['company_id' => 2, 'divisi_id' => 3, 'menu_key' => 'tissue_marketing', 'menu_name' => 'Tissue Marketing'],
]
```

## Implementasi Frontend

### Dynamic Brand Name
```blade
<span class="brand-text font-weight-light">{{ getCurrentCompanyName() }}</span>
```

### Company Info in User Panel
```blade
@if(Auth::user()->company)
    <small class="text-info d-block">{{ Auth::user()->company->name }}</small>
@endif
```

### Menu Access Checking
```blade
@if ((hasMenuAccess('barang') && getDivisiMenuAccess([2, 3, 5, 6, 13])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3, 5, 6, 13])))
    <li class="nav-item">
        <a href="{{ route('barang.indexnew') }}" class="nav-link">
            <i class="fa-solid fa-boxes-stacked nav-icon"></i>
            <p>Data Barang</p>
        </a>
    </li>
@endif
```

## Company Management Interface

### Routes
```php
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company/switch/{companyId}', [CompanyController::class, 'switchCompany'])->name('company.switch');
    Route::get('/company/info', [CompanyController::class, 'getCompanyInfo'])->name('company.info');
});
```

### Controller
```php
// app/Http/Controllers/CompanyController.php
public function switchCompany(Request $request, $companyId)
{
    $company = Company::findOrFail($companyId);
    $user = Auth::user();
    $user->update(['company_id' => $companyId]);
    return redirect()->back()->with('success', 'Company switched to ' . $company->name);
}
```

### View (Company Management)
- Interface untuk switch company (demo purposes)
- Preview menu structure berdasarkan company
- Informasi company yang sedang aktif

## Seeders

### CompanySeeder
```php
// database/seeders/CompanySeeder.php
$companies = [
    ['id' => 1, 'name' => 'PT. SPA (Corrugated Box)', 'address' => '...'],
    ['id' => 2, 'name' => 'PT. SPA (Tissue Manufacturing)', 'address' => '...'],
];
```

### MenuPermissionSeeder
```php
// database/seeders/MenuPermissionSeeder.php
private function createCorrugatedBoxMenus()    // Menu untuk Company 1
private function createTissueMenus()           // Menu untuk Company 2
```

## Testing & Debugging

### Test User Assignment
```php
// User ID 1-3: Company 1 (Corrugated Box)
// User ID 4-6: Company 2 (Tissue Manufacturing)
```

### Helper Function Testing
```php
// Test pada tinker:
$companyName = getCurrentCompanyName();
$hasAccess = hasMenuAccess('barang');
$divisiAccess = getDivisiMenuAccess([2, 3]);
```

## Fallback Mechanism

### Backward Compatibility
- Jika user tidak memiliki `company_id`, sistem akan menggunakan logika divisi lama
- Hybrid approach memastikan aplikasi tetap berfungsi untuk user existing

### Error Handling
- Helper functions memiliki null checking untuk user dan company
- Default values untuk mencegah errors

## Workflow Penggunaan

1. **Login User**: User login dengan credential normal
2. **Company Detection**: Sistem detect company_id dari user
3. **Menu Loading**: MenuService load menu berdasarkan company + divisi
4. **Sidebar Rendering**: Sidebar render dengan menu yang sesuai
5. **Company Switching**: IT admin dapat switch company untuk testing

## Maintenance & Updates

### Menambah Company Baru
1. Tambah record di tabel `companies`
2. Buat menu permissions di `MenuPermissionSeeder`
3. Tambah logic di sidebar untuk company baru
4. Assign users ke company baru

### Menambah Menu Baru
1. Tambah record di `menu_permissions` 
2. Implementasi menu di sidebar dengan `hasMenuAccess()`
3. Test access control

### Troubleshooting
- Check helper functions dengan `function_exists()`
- Verify autoload dengan `composer dump-autoload`
- Clear cache: `php artisan config:clear` & `php artisan view:clear`

## Security Considerations

- Menu access divalidasi di level backend dan frontend
- Company switching hanya untuk testing (production should be restricted)
- Helper functions memiliki null checking untuk security
- Database constraints untuk data integrity

---

**Catatan**: Sistem ini menggunakan hybrid approach yang mempertahankan kompatibilitas dengan sistem divisi yang sudah ada sambil menambahkan layer company-specific access control.
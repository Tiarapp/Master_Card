# Quick Reference Guide - Sidebar Multi-Company

## Helper Functions

### Menu Access Check
```php
// Cek akses menu spesifik
hasMenuAccess('barang')                 // return: boolean

// Cek akses multiple menu (OR condition)
hasAnyMenuAccess(['barang', 'opi'])     // return: boolean

// Cek akses berdasarkan divisi (legacy support)
getDivisiMenuAccess([2, 3, 5])         // return: boolean

// Get company name
getCurrentCompanyName()                 // return: string
```

## Sidebar Blade Patterns

### Basic Menu Item
```blade
@if ((hasMenuAccess('menu_key') && getDivisiMenuAccess([2, 3])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3])))
    <li class="nav-item">
        <a href="{{ route('route.name') }}" class="nav-link">
            <i class="fas fa-icon nav-icon"></i>
            <p>Menu Name</p>
        </a>
    </li>
@endif
```

### Dropdown Menu
```blade
@if (hasMenuAccess('parent_menu'))
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="fas fa-icon nav-icon"></i>
            <p>
                Parent Menu
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('submenu.route') }}" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>Submenu Item</p>
                </a>
            </li>
        </ul>
    </li>
@endif
```

### Company Specific Menu
```blade
@if(Auth::user()->company_id == 1)
    {{-- Company 1 (Corrugated Box) menus --}}
    @if (hasMenuAccess('corrugated_production'))
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa-solid fa-industry nav-icon"></i>
                <p>Corrugated Production</p>
            </a>
        </li>
    @endif
@elseif(Auth::user()->company_id == 2)
    {{-- Company 2 (Tissue) menus --}}
    @if (hasMenuAccess('tissue_production'))
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa-solid fa-toilet-paper nav-icon"></i>
                <p>Tissue Production</p>
            </a>
        </li>
    @endif
@endif
```

## Database Quick Queries

### Add New Company
```sql
INSERT INTO companies (id, name, address, phone, email) 
VALUES (3, 'New Company Name', 'Address', '021-xxx', 'email@company.com');
```

### Add Menu Permission
```sql
INSERT INTO menu_permissions (company_id, divisi_id, menu_key, menu_name, route_name, icon, is_active, `order`) 
VALUES (1, 2, 'new_menu', 'New Menu', 'route.name', 'fas fa-icon', 1, 10);
```

### Assign User to Company
```sql
UPDATE users SET company_id = 1 WHERE id = 1;
```

### Get User's Available Menus
```sql
SELECT mp.* FROM menu_permissions mp 
JOIN users u ON u.company_id = mp.company_id AND u.divisi_id = mp.divisi_id 
WHERE u.id = 1 AND mp.is_active = 1 
ORDER BY mp.order;
```

## Artisan Commands

### Run Seeders
```bash
# Seed all companies and permissions
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=CompanySeeder
php artisan db:seed --class=MenuPermissionSeeder
php artisan db:seed --class=UpdateUserCompanySeeder
```

### Cache Management
```bash
# Clear all cache
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# Regenerate autoload (for helper functions)
composer dump-autoload
```

### Migration
```bash
# Run migrations
php artisan migrate

# Create new migration
php artisan make:migration add_column_to_table
```

## Company Configuration

### Company 1: PT. SPA (Corrugated Box)
- **ID**: 1
- **Divisi Access**: 2, 3, 5, 6, 9, 13
- **Unique Menus**: 
  - corrugated_production
  - box_design
  - cutting_patterns

### Company 2: PT. SPA (Tissue Manufacturing)  
- **ID**: 2
- **Divisi Access**: 2, 3, 5, 6, 13
- **Unique Menus**:
  - tissue_production
  - tissue_inventory  
  - tissue_quality
  - tissue_marketing

## Testing

### Switch Company (Development Only)
```php
// Via route
POST /company/switch/{companyId}

// Via controller
app(CompanyController::class)->switchCompany($request, $companyId);
```

### Test Helper Functions
```bash
# Via tinker
php artisan tinker

# In tinker console:
Auth::login(App\Models\User::find(1));
hasMenuAccess('barang');
getCurrentCompanyName();
```

### Verify Menu Structure
```php
// Get menu structure for current user
$menuService = app(\App\Services\MenuService::class);
$structure = $menuService->getMenuStructure();
dd($structure);
```

## Troubleshooting

### Common Issues
1. **Helper functions not found**: Run `composer dump-autoload`
2. **Sidebar syntax error**: Check `@if`/`@endif` pairs
3. **Menu not showing**: Check company_id and menu_permissions table
4. **Company name not showing**: Verify getCurrentCompanyName() function

### Debug Commands
```bash
# Check current user company
php artisan tinker --execute="dd(Auth::user()->company_id)"

# Check available menu permissions
php artisan tinker --execute="dd(App\Models\MenuPermission::where('company_id', 1)->get())"

# Test helper function
php artisan tinker --execute="if(function_exists('hasMenuAccess')) echo 'Loaded'; else echo 'Not loaded';"
```

## File Locations

### Core Files
- **Sidebar**: `resources/views/admin/templates/partials/_sidebar.blade.php`
- **Helper**: `app/Helpers/MenuHelper.php`
- **Service**: `app/Services/MenuService.php`
- **Models**: `app/Models/Company.php`, `app/Models/MenuPermission.php`

### Configuration
- **Composer**: `composer.json` (autoload files)
- **AppServiceProvider**: `app/Providers/AppServiceProvider.php`
- **Routes**: `routes/web.php` (company management routes)

### Database
- **Migrations**: `database/migrations/`
  - `create_companies_table.php`
  - `add_company_to_users_table.php`
  - `create_menu_permissions_table.php`
- **Seeders**: `database/seeders/`
  - `CompanySeeder.php`
  - `MenuPermissionSeeder.php`

## Code Templates

### New Helper Function
```php
if (!function_exists('newHelperFunction')) {
    function newHelperFunction($param)
    {
        $user = Auth::user();
        
        if (!$user || !$user->company_id) {
            return false;
        }
        
        // Your logic here
        return true;
    }
}
```

### New Menu Permission
```php
// In MenuPermissionSeeder
['company_id' => 1, 'divisi_id' => 2, 'menu_key' => 'new_menu', 'menu_name' => 'New Menu', 'route_name' => 'route.name', 'icon' => 'fas fa-icon', 'order' => 10]
```

### New Sidebar Section
```blade
{{-- New Menu Section --}}
@if ((hasMenuAccess('new_menu') && getDivisiMenuAccess([2, 3])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3])))
    <li class="nav-item">
        <a href="{{ route('new.route') }}" class="nav-link">
            <i class="fas fa-new-icon nav-icon"></i>
            <p>New Menu</p>
        </a>
    </li>
@endif
```
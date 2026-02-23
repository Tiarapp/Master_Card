# Sidebar Multi-Company System

## Overview
Sistem pemisahan menu sidebar berdasarkan company untuk aplikasi Master Card PT. SPA, memungkinkan setiap company memiliki akses menu yang berbeda sesuai dengan fokus bisnis mereka.

## 🏢 Companies

### Company 1: PT. SPA (Corrugated Box)
- **Focus**: Manufaktur kotak karton bergelombang
- **Unique Features**: Box Design, Cutting Patterns, Corrugated Production
- **Primary Divisions**: IT, Marketing, PPIC, Production, Warehouse

### Company 2: PT. SPA (Tissue Manufacturing) 
- **Focus**: Manufaktur tissue dan produk kertas
- **Unique Features**: Paper Roll Management, Tissue Inventory, Quality Control
- **Primary Divisions**: IT, Marketing, PPIC, Quality Control, Warehouse

## 🚀 Quick Start

### 1. Installation (Already Complete)
- ✅ Database tables created (`companies`, `menu_permissions`)
- ✅ Models and relationships configured
- ✅ Helper functions implemented
- ✅ Sidebar updated with company logic

### 2. Switch Company (For Testing)
```
1. Login as IT admin (divisi_id = 2)
2. Go to "Company Management" menu in sidebar
3. Switch between Company 1 and Company 2
4. Observe menu changes automatically
```

### 3. User Assignment
```sql
-- Assign user to Company 1 (Corrugated Box)
UPDATE users SET company_id = 1 WHERE id = 1;

-- Assign user to Company 2 (Tissue Manufacturing)  
UPDATE users SET company_id = 2 WHERE id = 2;
```

## 📋 Menu Structure

### Shared Menus (Both Companies)
- **Data Barang** - Product management
- **OPI** - Order Production Information
- **Master Card** - Master card management
- **Accounting** - Financial modules
- **Inventory Management** - Warehouse operations

### Company-Specific Menus

#### Company 1 (Corrugated Box)
- **Corrugated Production**
  - Box Design
  - Cutting Patterns  
  - Quality Control
- **Master Data** - Company-specific master data
- **Marketing** - Box marketing tools
- **Logistik** - Box logistics

#### Company 2 (Tissue Manufacturing)
- **Tissue Production**
  - Paper Roll Management
  - Converting Process
  - Packaging
- **Tissue Inventory**
  - Raw Materials
  - Finished Goods
- **Tissue Quality Control**
- **Tissue Marketing**
  - Product Catalog
  - Customer Orders

## 🔧 Technical Implementation

### Helper Functions
```php
hasMenuAccess('menu_key')              // Check specific menu access
hasAnyMenuAccess(['menu1', 'menu2'])   // Check multiple menu access
getCurrentCompanyName()                // Get current user's company name
getDivisiMenuAccess([2, 3, 5])        // Check division-based access
```

### Sidebar Patterns
```blade
{{-- Basic menu with company + division check --}}
@if ((hasMenuAccess('barang') && getDivisiMenuAccess([2, 3])) || (!Auth::user()->company_id && getDivisiMenuAccess([2, 3])))
    <li class="nav-item">
        <a href="{{ route('barang.indexnew') }}" class="nav-link">
            <i class="fa-solid fa-boxes-stacked nav-icon"></i>
            <p>Data Barang</p>
        </a>
    </li>
@endif

{{-- Company-specific menu --}}
@if(Auth::user()->company_id == 1)
    @if (hasMenuAccess('corrugated_production'))
        {{-- Corrugated Box specific menu --}}
    @endif
@elseif(Auth::user()->company_id == 2)  
    @if (hasMenuAccess('tissue_production'))
        {{-- Tissue Manufacturing specific menu --}}
    @endif
@endif
```

## 🎯 Key Features

### ✅ Dynamic Brand Display
- Company name shows dynamically in sidebar header
- User panel displays current company information

### ✅ Hybrid Access Control
- New company-based menu permissions
- Backward compatibility with existing division-based system
- Fallback mechanism for users without company assignment

### ✅ Granular Menu Control
- Menu access controlled per company and division combination
- Support for main menus and submenus
- Active/inactive menu management

### ✅ Company Management Interface
- Switch between companies for testing (IT admin only)
- Real-time menu structure preview
- Company information display

### ✅ Database-Driven Configuration
- Menu permissions stored in database
- Easy to add new companies and menus
- Seeders for initial setup and testing

## 📚 Documentation

| Document | Purpose | Target Audience |
|----------|---------|-----------------|
| [Sidebar_Multi_Company_Documentation.md](./Sidebar_Multi_Company_Documentation.md) | Complete technical specification | Developers, System Architects |
| [Sidebar_Quick_Reference.md](./Sidebar_Quick_Reference.md) | Quick development reference | Developers |
| [Menu_Access_Matrix.md](./Menu_Access_Matrix.md) | Menu access mapping | Developers, Business Users |

## 🔍 Testing

### Sample Test Users
```sql
-- Company 1 Users (Corrugated Box)
-- User ID 1-3: Various divisions in Company 1

-- Company 2 Users (Tissue Manufacturing)
-- User ID 4-6: Various divisions in Company 2
```

### Test Scenarios
1. **Company 1 User**: Should see corrugated-specific menus
2. **Company 2 User**: Should see tissue-specific menus
3. **Legacy User** (no company): Should see division-based menus
4. **Company Switch**: Menus should change immediately after switching

### Verification Commands
```bash
# Test helper functions
php artisan tinker --execute="echo function_exists('hasMenuAccess') ? 'OK' : 'FAIL'"

# Check current user's company
php artisan tinker --execute="Auth::login(App\Models\User::find(1)); echo getCurrentCompanyName();"

# Verify menu permissions
php artisan tinker --execute="dd(App\Models\MenuPermission::where('company_id', 1)->count())"
```

## 🛠️ Development Workflow

### Adding New Company
1. **Database**: Add record to `companies` table
2. **Permissions**: Create menu permissions in seeder
3. **Sidebar**: Add company-specific sections
4. **Users**: Assign users to new company

### Adding New Menu
1. **Permission**: Add to `menu_permissions` table
2. **Sidebar**: Implement with `hasMenuAccess()` check
3. **Route**: Ensure route exists and accessible
4. **Testing**: Verify access control works

### Troubleshooting
```bash
# Clear all cache
php artisan config:clear && php artisan view:clear

# Regenerate autoload
composer dump-autoload

# Check syntax
php artisan tinker --execute="echo 'Syntax OK';"
```

## 🔒 Security

- ✅ Menu access validated at helper function level
- ✅ Company switching restricted to IT admin only
- ✅ Null checking prevents errors for unassigned users
- ✅ Database constraints ensure data integrity
- ✅ Fallback mechanism prevents access loss

## 📊 Current Status

| Component | Status | Notes |
|-----------|---------|-------|
| Database Schema | ✅ Complete | All tables created and migrated |
| Models & Relations | ✅ Complete | Company, MenuPermission, User models |
| Helper Functions | ✅ Complete | All helper functions working |
| Sidebar Integration | ✅ Complete | Dynamic menu rendering |
| Company Management | ✅ Complete | Switch interface for testing |
| Documentation | ✅ Complete | Full documentation set |
| Testing | ✅ Complete | Basic test scenarios verified |

## 🚦 Next Steps

### Production Deployment
1. **User Training**: Train users on company-specific features
2. **Data Migration**: Assign all existing users to appropriate companies  
3. **Access Review**: Review and adjust menu permissions as needed
4. **Monitoring**: Monitor system performance and user feedback

### Future Enhancements
- **Role-Based Access**: Add roles within companies
- **Menu Customization**: Allow admin to customize menus per company
- **Audit Logging**: Track menu access and company switches
- **Multi-Language**: Support for multiple languages per company

---

**Contact**: IT Department for technical support and access issues

**Last Updated**: February 20, 2026
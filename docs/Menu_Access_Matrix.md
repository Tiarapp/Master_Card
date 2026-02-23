# Menu Access Matrix - Multi Company System

## Company Overview

| Company ID | Company Name | Focus Business | Primary Divisions |
|------------|--------------|----------------|-------------------|
| 1 | PT. SPA (Corrugated Box) | Box Manufacturing | 2, 3, 5, 6, 9, 13 |
| 2 | PT. SPA (Tissue Manufacturing) | Tissue Production | 2, 3, 5, 6, 13 |

## Division Mapping

| Division ID | Division Name | Description |
|-------------|---------------|-------------|
| 1 | Accounting | Finance & Accounting |
| 2 | IT/Admin | Information Technology |
| 3 | Marketing | Sales & Marketing |
| 5 | PPIC | Production Planning & Inventory Control |
| 6 | Gudang | Warehouse Management |
| 8 | Teknik | Technical Department |
| 9 | HRD/GA | Human Resources & General Affairs |
| 10 | Palet | Pallet Management |
| 12 | QC | Quality Control |
| 13 | Sales | Sales Department |
| 14 | Reports | Reporting Department |

## Shared Menus (Available for Multiple Companies)

| Menu Key | Menu Name | Company 1 (Corrugated) | Company 2 (Tissue) | Divisions |
|----------|-----------|------------------------|---------------------|-----------|
| barang | Data Barang | ✅ | ✅ | 2, 3, 5, 6, 13 |
| opi | OPI | ✅ | ✅ | 2, 3, 5, 9, 13 |
| mastercard | Master Card | ✅ | ✅ | 2, 3, 5, 13 |
| accounting | Accounting | ✅ | ✅ | 1, 2 |
| logistik | Logistik | ✅ | ❌ | 2, 6 |
| inventory | Inventory Management | ✅ | ✅ | 2, 6 |
| master | Master Data | ✅ | ❌ | 2, 3, 13 |
| marketing | Marketing | ✅ | ❌ | 2, 3, 13 |

## Company-Specific Menus

### Company 1: PT. SPA (Corrugated Box)

| Menu Key | Menu Name | Divisions | Description |
|----------|-----------|-----------|-------------|
| corrugated_production | Corrugated Production | 2, 9 | Box manufacturing processes |
| box_design | Box Design | 2, 9 | Box design and specifications |
| cutting_patterns | Cutting Patterns | 2, 9 | Cutting pattern management |
| corrugated_quality | Quality Control | 2, 9 | QC specific for corrugated boxes |

#### Submenu Details - Corrugated Production
- Box Design
- Cutting Patterns  
- Quality Control

### Company 2: PT. SPA (Tissue Manufacturing)

| Menu Key | Menu Name | Divisions | Description |
|----------|-----------|-----------|-------------|
| tissue_production | Tissue Production | 2, 9 | Tissue manufacturing processes |
| tissue_inventory | Tissue Inventory | 2, 6 | Raw materials & finished goods |
| tissue_quality | Quality Control | 2, 5 | QC specific for tissue products |
| tissue_marketing | Tissue Marketing | 3, 13 | Marketing specific for tissue |

#### Submenu Details - Tissue Production
- Paper Roll Management
- Converting Process
- Packaging

#### Submenu Details - Tissue Inventory
- Raw Materials
- Finished Goods

#### Submenu Details - Tissue Marketing
- Product Catalog
- Customer Orders

## Universal Menus (All Users)

| Menu Name | Access Level | Description |
|-----------|--------------|-------------|
| Feedback | All Users | System feedback and suggestions |
| Hardware Management | IT Only (Div 2) | IT equipment management |
| Company Management | IT Only (Div 2) | Company switching (demo) |

## Division-Specific Menus (Legacy System)

| Menu Name | Divisions | Companies | Description |
|-----------|-----------|-----------|-------------|
| PPIC | 5, 2 | Both | Production planning |
| PRODUKSI | 5, 2 | Both | Production management |
| Palet | 10, 2 | Both | Pallet management |
| QC | 12, 2 | Both | Quality control |
| Teknik | 8, 2 | Both | Technical operations |
| HRD/GA | 9, 2 | Both | Human resources |
| Reports | 2, 14 | Both | System reports |

## Menu Access Logic Flow

```
User Login
    ↓
Check user.company_id
    ↓
┌─────────────────┬─────────────────┐
│  company_id = 1 │  company_id = 2 │
│  (Corrugated)   │     (Tissue)    │
└─────────────────┴─────────────────┘
    ↓                       ↓
Load Company 1 Menus    Load Company 2 Menus
    ↓                       ↓
Check Division Access   Check Division Access
    ↓                       ↓
Render Sidebar          Render Sidebar
```

## Implementation Pattern

### Standard Menu Check
```blade
@if ((hasMenuAccess('menu_key') && getDivisiMenuAccess([div_ids])) || (!Auth::user()->company_id && getDivisiMenuAccess([div_ids])))
    {{-- Menu rendering --}}
@endif
```

### Company-Specific Check
```blade
@if(Auth::user()->company_id == 1)
    @if (hasMenuAccess('corrugated_production'))
        {{-- Corrugated specific menu --}}
    @endif
@elseif(Auth::user()->company_id == 2)
    @if (hasMenuAccess('tissue_production'))
        {{-- Tissue specific menu --}}
    @endif
@endif
```

### Legacy Division Check
```blade
@if (Auth::user()->divisi_id == 5 || Auth::user()->divisi_id == 2)
    {{-- Legacy division-based menu --}}
@endif
```

## User Assignment Examples

### Company 1 Users (Corrugated Box)
```sql
-- Admin/IT
UPDATE users SET company_id = 1 WHERE divisi_id = 2 AND id IN (1, 2);

-- Marketing
UPDATE users SET company_id = 1 WHERE divisi_id = 3 AND id IN (3, 4); 

-- PPIC
UPDATE users SET company_id = 1 WHERE divisi_id = 5 AND id IN (5, 6);

-- Production
UPDATE users SET company_id = 1 WHERE divisi_id = 9 AND id IN (7, 8);
```

### Company 2 Users (Tissue Manufacturing)
```sql
-- Admin/IT
UPDATE users SET company_id = 2 WHERE divisi_id = 2 AND id IN (9, 10);

-- Marketing  
UPDATE users SET company_id = 2 WHERE divisi_id = 3 AND id IN (11, 12);

-- Warehouse
UPDATE users SET company_id = 2 WHERE divisi_id = 6 AND id IN (13, 14);

-- Quality Control
UPDATE users SET company_id = 2 WHERE divisi_id = 5 AND id IN (15, 16);
```

## Menu Permission Seeds Data

### Company 1 (Corrugated) Permissions
```php
$corrugatedMenus = [
    // Shared menus
    ['company_id' => 1, 'divisi_id' => 2, 'menu_key' => 'barang'],
    ['company_id' => 1, 'divisi_id' => 3, 'menu_key' => 'barang'],
    ['company_id' => 1, 'divisi_id' => 5, 'menu_key' => 'barang'],
    
    // Company-specific menus
    ['company_id' => 1, 'divisi_id' => 2, 'menu_key' => 'corrugated_production'],
    ['company_id' => 1, 'divisi_id' => 9, 'menu_key' => 'corrugated_production'],
];
```

### Company 2 (Tissue) Permissions
```php
$tissueMenus = [
    // Company-specific menus
    ['company_id' => 2, 'divisi_id' => 2, 'menu_key' => 'tissue_production'],
    ['company_id' => 2, 'divisi_id' => 9, 'menu_key' => 'tissue_production'],
    ['company_id' => 2, 'divisi_id' => 6, 'menu_key' => 'tissue_inventory'],
    ['company_id' => 2, 'divisi_id' => 5, 'menu_key' => 'tissue_quality'],
    ['company_id' => 2, 'divisi_id' => 3, 'menu_key' => 'tissue_marketing'],
];
```

## Testing Scenarios

### Test Case 1: Corrugated Box User
- **User**: company_id = 1, divisi_id = 2 (IT)
- **Expected Menus**: 
  - ✅ Data Barang, OPI, Master Card
  - ✅ Accounting, Logistik, Inventory
  - ✅ Corrugated Production
  - ❌ Tissue Production, Tissue Inventory

### Test Case 2: Tissue Manufacturing User  
- **User**: company_id = 2, divisi_id = 3 (Marketing)
- **Expected Menus**:
  - ✅ Tissue Marketing 
  - ✅ Basic accounting access
  - ❌ Corrugated Production
  - ❌ Logistik (corrugated-specific)

### Test Case 3: Legacy User (No Company)
- **User**: company_id = null, divisi_id = 2 (IT)
- **Expected Behavior**: 
  - ✅ Access via division-based rules (fallback)
  - ✅ All universal menus
  - ❌ Company-specific menus

## Migration Path

### From Single Company to Multi-Company
1. **Phase 1**: Install system (database, models, helpers)
2. **Phase 2**: Assign existing users to Company 1
3. **Phase 3**: Create Company 2 and specific menus
4. **Phase 4**: Migrate selected users to Company 2
5. **Phase 5**: Full deployment with company-specific features

### Data Migration Script
```sql
-- Step 1: Assign all existing users to Company 1
UPDATE users SET company_id = 1 WHERE company_id IS NULL;

-- Step 2: Create basic menu permissions for Company 1
INSERT INTO menu_permissions (company_id, divisi_id, menu_key, menu_name, is_active)
SELECT 1, id, 'barang', 'Data Barang', 1 FROM divisi WHERE id IN (2,3,5,6,13);
```

---

**Note**: This matrix serves as the authoritative reference for menu access control in the multi-company system. All access decisions should follow this mapping.
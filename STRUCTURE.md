# Plugin Structure

Complete file structure of the Custom WooCommerce Currency Switcher plugin.

```
custom-woocommerce-currency/
│
├── 📄 custom-woocommerce-currency.php  (29.7 KB) - Main plugin file
│   ├── Plugin header with metadata
│   ├── Security checks
│   ├── Class: Custom_WC_Currency_Switcher
│   ├── Database table creation
│   ├── Admin interface
│   ├── Frontend currency switcher
│   ├── AJAX handlers
│   ├── WooCommerce hooks & filters
│   └── Price conversion logic
│
├── 📁 assets/
│   ├── 📄 admin.js (2.8 KB)
│   │   ├── Delete currency functionality
│   │   ├── Form validation
│   │   ├── Auto-formatting
│   │   └── AJAX handling
│   │
│   ├── 📄 admin.css (3.3 KB)
│   │   ├── Dashboard styling
│   │   ├── Table layouts
│   │   ├── Form styling
│   │   └── Button styles
│   │
│   ├── 📄 frontend.js (2.0 KB)
│   │   ├── Currency switcher toggle
│   │   ├── Currency selection
│   │   ├── AJAX currency switch
│   │   └── Page reload
│   │
│   ├── 📄 frontend.css (2.6 KB)
│   │   ├── Switcher widget styling
│   │   ├── Dropdown styling
│   │   ├── Responsive design
│   │   └── Animations
│   │
│   └── 📄 index.php (30 B) - Security file
│
├── 📄 README.md (5.6 KB)
│   ├── Features overview
│   ├── Installation instructions
│   ├── Usage guide
│   ├── File structure
│   ├── Customization tips
│   ├── Troubleshooting
│   └── Security notes
│
├── 📄 QUICK-START.md (4.8 KB)
│   ├── 5-minute setup guide
│   ├── Common examples
│   ├── Testing checklist
│   ├── Quick fixes
│   └── Pro tips
│
├── 📄 INSTALLATION.md (7.0 KB)
│   ├── Step-by-step installation
│   ├── Configuration guide
│   ├── Multiplier calculations
│   ├── Real-world scenarios
│   ├── Troubleshooting
│   └── Maintenance tips
│
├── 📄 CURRENCY-REFERENCE.md (7.3 KB)
│   ├── 100+ currency codes
│   ├── Symbols reference
│   ├── Regional groupings
│   ├── Setup examples
│   └── Exchange rate resources
│
├── 📄 CHANGELOG.md (5.3 KB)
│   ├── Version history
│   ├── Current version details
│   ├── Future planned features
│   └── Contributing guidelines
│
├── 📄 LICENSE (1.1 KB)
│   └── MIT License
│
├── 📄 .gitignore (328 B)
│   ├── IDE files
│   ├── Node modules
│   ├── Build files
│   └── OS files
│
└── 📄 index.php (30 B) - Root security file

```

---

## File Purposes

### Core Files

**custom-woocommerce-currency.php**
- Main plugin entry point
- All PHP logic and functionality
- WooCommerce integration
- Database operations

**assets/admin.js**
- Admin panel interactivity
- Currency deletion
- Form validation
- AJAX requests

**assets/admin.css**
- Admin panel styling
- Professional dashboard look
- Responsive admin layout

**assets/frontend.js**
- Currency switcher functionality
- User interaction handling
- Dynamic currency switching

**assets/frontend.css**
- Frontend widget styling
- Responsive design
- Custom animations

---

## Documentation Files

**README.md** - Main documentation
- Complete plugin overview
- For developers and users
- Technical details included

**QUICK-START.md** - Fast setup guide
- For users who want quick setup
- 5-minute guide
- Common examples

**INSTALLATION.md** - Detailed setup
- Step-by-step installation
- Configuration examples
- Troubleshooting guide

**CURRENCY-REFERENCE.md** - Currency database
- 100+ currency codes and symbols
- Exchange rate resources
- Regional groupings

**CHANGELOG.md** - Version tracking
- Current version details
- Future roadmap
- Version history

---

## Security Files

**index.php** (2 files)
- Prevents directory browsing
- Returns blank page if accessed
- WordPress security best practice

**.gitignore**
- Excludes unnecessary files from git
- IDE configurations
- Build artifacts

---

## Total Plugin Size

**Main Code**: ~30 KB (PHP)
**Assets**: ~12 KB (JS + CSS)
**Documentation**: ~35 KB (All .md files)
**Total**: ~77 KB

---

## Database Structure

**Table Name**: `wp_custom_currencies`

```sql
CREATE TABLE wp_custom_currencies (
    id              INT(9) PRIMARY KEY AUTO_INCREMENT,
    currency_name   VARCHAR(100) NOT NULL,
    currency_symbol VARCHAR(10) NOT NULL,
    currency_code   VARCHAR(10) NOT NULL,
    multiplier      DECIMAL(10,6) NOT NULL DEFAULT 1.000000,
    is_default      TINYINT(1) NOT NULL DEFAULT 0,
    status          TINYINT(1) NOT NULL DEFAULT 1,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

---

## Key Features by File

### Main Plugin File
✅ Database table creation
✅ Admin menu and pages
✅ Currency CRUD operations
✅ Frontend currency switcher
✅ AJAX handlers
✅ WooCommerce price filters
✅ Email integration
✅ Session management

### Frontend JavaScript
✅ Currency switcher toggle
✅ Dropdown interaction
✅ AJAX currency switching
✅ Page reload on change
✅ Loading states

### Frontend CSS
✅ Fixed position widget
✅ Dropdown styling
✅ Hover effects
✅ Responsive breakpoints
✅ Smooth animations

### Admin JavaScript
✅ Delete confirmation
✅ AJAX deletion
✅ Form validation
✅ Auto-formatting
✅ Input sanitization

### Admin CSS
✅ Professional dashboard
✅ Table styling
✅ Form layouts
✅ Button states
✅ Responsive admin

---

## WordPress Hooks Used

### Actions
- `plugins_loaded`
- `admin_menu`
- `admin_enqueue_scripts`
- `wp_enqueue_scripts`
- `wp_footer`
- `wp_ajax_*`
- `woocommerce_email_before_order_table`

### Filters
- `woocommerce_currency`
- `woocommerce_currency_symbol`
- `raw_woocommerce_price`
- `woocommerce_product_get_price`
- `woocommerce_product_get_regular_price`
- `woocommerce_product_get_sale_price`
- `woocommerce_product_variation_get_*`
- `woocommerce_cart_item_*`
- `woocommerce_email_order_items_args`

---

## Technology Stack

- **PHP**: 7.4+ (Core logic)
- **JavaScript**: jQuery (Interactivity)
- **CSS3**: Modern styling
- **MySQL**: Data storage
- **WordPress API**: Plugin framework
- **WooCommerce API**: E-commerce integration

---

**Last Updated**: 2025-01-01
**Version**: 1.0.0
**Total Files**: 14

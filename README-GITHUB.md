# Custom WooCommerce Currency Switcher

[![Version](https://img.shields.io/badge/version-1.0.1-blue.svg)](https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases)
[![WordPress](https://img.shields.io/badge/WordPress-5.8%2B-blue.svg)](https://wordpress.org/)
[![WooCommerce](https://img.shields.io/badge/WooCommerce-5.0%2B-purple.svg)](https://woocommerce.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

A comprehensive WordPress plugin that allows users to switch between multiple currencies on a WooCommerce store with automatic updates from GitHub.

## ✨ Features

- 🌍 **Multi-Currency Support** - Unlimited currencies with custom names, symbols, and exchange rates
- 👨‍💼 **Admin Dashboard** - Easy-to-use interface for managing currencies
- 🔄 **Live Currency Switching** - Users can switch currencies on the fly
- 💰 **Automatic Price Conversion** - Works on products, cart, checkout, and emails
- 📧 **Email Integration** - Converted prices appear in WooCommerce order emails
- 🔐 **Secure** - SQL injection prevention, XSS protection, CSRF protection
- 🎨 **Customizable** - Easy to style and position the currency switcher
- 📱 **Responsive** - Works perfectly on desktop, tablet, and mobile
- ⚡ **Auto-Updates** - Updates directly from GitHub repository

## 📥 Installation

### From GitHub Release (Recommended)

1. Download the latest release ZIP from [Releases](https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases)
2. Go to **WordPress Admin → Plugins → Add New**
3. Click **Upload Plugin**
4. Choose the downloaded ZIP file
5. Click **Install Now** and then **Activate**

### From Source

```bash
cd wp-content/plugins/
git clone https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher.git custom-woocommerce-currency
```

Then activate from WordPress admin.

## 🚀 Quick Start

1. **Activate the plugin** in WordPress
2. Go to **Currency Switcher** in the admin menu
3. Click **Add New** to add a currency
4. Fill in:
   - Currency Name (e.g., "US Dollar")
   - Symbol (e.g., "$")
   - Code (e.g., "USD")
   - Multiplier (exchange rate from default currency)
5. Visit your store - the currency switcher appears in the top right
6. Click to switch currencies!

## 📖 Documentation

- [Installation Guide](INSTALLATION.md) - Detailed setup instructions
- [Quick Start Guide](QUICK-START.md) - Get running in 5 minutes
- [Currency Reference](CURRENCY-REFERENCE.md) - 100+ currency codes and symbols
- [Auto-Update Guide](AUTO-UPDATE-GUIDE.md) - How to create releases
- [Changelog](CHANGELOG.md) - Version history

## 🔧 Configuration

### Adding a Currency

Example: Adding Euro with 0.85 exchange rate (1 USD = 0.85 EUR)

```
Currency Name: Euro
Symbol: €
Code: EUR
Multiplier: 0.85
Status: Active
```

### Multiplier Calculation

The multiplier converts from your **default currency** to the target currency:

```
Target Price = Default Price × Multiplier
```

**Examples:**
- 1 USD = 0.85 EUR → Multiplier: `0.85`
- 1 USD = 110 JPY → Multiplier: `110`
- 1 EUR = 1.18 USD → Multiplier: `1.18`

## 🔄 Automatic Updates

This plugin supports automatic updates from GitHub!

### For Users

Once installed, you'll receive update notifications in WordPress admin:
1. Go to **Dashboard → Updates**
2. Click **Update Now** when available
3. Done! Your plugin is up to date

### For Developers

See [AUTO-UPDATE-GUIDE.md](AUTO-UPDATE-GUIDE.md) for release instructions.

**Quick Release:**
```bash
# Windows
.\deploy.ps1 -Version "1.0.2" -Message "Bug fixes"

# Linux/Mac
./deploy.sh 1.0.2 "Bug fixes"
```

## 💻 Requirements

- WordPress 5.8 or higher
- WooCommerce 5.0 or higher
- PHP 7.4 or higher

## 🎨 Customization

### Change Switcher Position

Edit `assets/frontend.css`:

```css
.cwc-currency-switcher {
    top: 100px;    /* Vertical position */
    right: 20px;   /* Horizontal position */
}
```

### Change Colors

```css
.cwc-switcher-toggle {
    background: #your-color;
    color: #text-color;
}
```

## 🔍 Troubleshooting

**Currency switcher not showing?**
- Ensure you have at least one active currency besides default
- Clear browser and WordPress cache

**Prices not converting?**
- Check that multiplier is correct
- Verify currency is marked as "Active"

**Database table missing?**
- Go to Currency Switcher page
- Click "Recreate Database Table"

**Updates not showing?**
- Wait 12 hours (WordPress caches update checks)
- Force check: Dashboard → Updates → "Check Again"

## 📊 Technical Details

### Database

Creates custom table: `wp_custom_currencies`

Fields:
- `id` - Unique identifier
- `currency_name` - Full currency name
- `currency_symbol` - Display symbol
- `currency_code` - ISO code
- `multiplier` - Exchange rate
- `is_default` - Default flag
- `status` - Active/inactive
- `created_at` - Creation timestamp

### Hooks & Filters

Price conversion hooks:
- `woocommerce_product_get_price`
- `woocommerce_product_get_regular_price`
- `woocommerce_product_get_sale_price`
- `woocommerce_currency_symbol`
- And more...

## 🤝 Contributing

Contributions are welcome!

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 Changelog

See [CHANGELOG.md](CHANGELOG.md) for version history.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👤 Author

**Chusie Kokoro**
- Portfolio: [https://portfolio-react-tailwind-gilt.vercel.app/](https://portfolio-react-tailwind-gilt.vercel.app/)
- GitHub: [@roy-dela-torre](https://github.com/roy-dela-torre)

## 🌟 Support

If you find this plugin helpful, please:
- ⭐ Star this repository
- 🐛 Report bugs via [Issues](https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/issues)
- 💡 Suggest features via [Issues](https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/issues)

## 📸 Screenshots

![Currency Switcher Widget](docs/screenshot-1.png)
*Currency switcher widget on the frontend*

![Admin Dashboard](docs/screenshot-2.png)
*Easy-to-use admin dashboard*

![Add Currency](docs/screenshot-3.png)
*Simple currency addition form*

---

**Made with ❤️ for WooCommerce store owners worldwide**

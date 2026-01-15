=== Custom WooCommerce Currency Switcher ===
Contributors: chusiekokoro
Tags: woocommerce, currency, currency switcher, multi-currency, exchange rate
Requires at least: 5.8
Tested up to: 6.4
Stable tag: 1.0.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Allow customers to switch between multiple currencies with automatic price conversion throughout your WooCommerce store.

== Description ==

Custom WooCommerce Currency Switcher enables your customers to view and purchase products in their preferred currency. Perfect for international stores wanting to provide a localized shopping experience.

= Features =

* **Custom Currency Management** - Add unlimited currencies with custom symbols and exchange rates
* **Automatic Price Conversion** - Converts all product prices, cart totals, and checkout amounts
* **Frontend Currency Switcher** - Beautiful dropdown widget for customers to switch currencies
* **Admin Dashboard** - Easy-to-use interface for managing currencies and exchange rates
* **Session & Cookie Support** - Remembers customer's currency preference
* **Email Integration** - Order emails display prices in the selected currency
* **Cart & Checkout Support** - Full integration with WooCommerce cart and checkout
* **Auto-Updates** - Built-in GitHub updater for seamless plugin updates
* **Lightweight & Fast** - Minimal impact on site performance

= Requirements =

* WordPress 5.8 or higher
* WooCommerce 5.0 or higher
* PHP 7.4 or higher

= How It Works =

1. Install and activate the plugin
2. Go to Currency Switcher in WordPress admin
3. Add your currencies with exchange rates
4. Set one currency as default
5. Currency switcher automatically appears on your site's frontend
6. Customers can switch currencies and see converted prices

= Use Cases =

* International e-commerce stores
* Multi-region online shops
* Dropshipping businesses
* Global marketplaces
* Any WooCommerce store serving international customers

= Support =

For support, feature requests, or bug reports, please visit the [GitHub repository](https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher).

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins > Add New
3. Search for "Custom WooCommerce Currency Switcher"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Go to Plugins > Add New > Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Activate the plugin

= After Activation =

1. Go to Currency Switcher in the WordPress admin menu
2. Click "Add New" to create your first currency
3. Enter currency name, symbol, code, and exchange rate
4. Set one currency as default
5. Activate currencies by clicking the toggle
6. The currency switcher will automatically appear on your site

== Frequently Asked Questions ==

= Does this work with all WooCommerce themes? =

Yes, the plugin is designed to work with any WooCommerce-compatible theme.

= How do I update exchange rates? =

Go to Currency Switcher in admin, click Edit on any currency, and update the exchange rate. Currently, rates are manual, but automatic updates may be added in future versions.

= Can I customize the switcher appearance? =

Yes, you can customize the appearance using CSS. The switcher uses the `.cwc-currency-switcher` class.

= Does this affect my actual store currency? =

No, your base currency remains unchanged. This plugin only converts display prices for customers.

= Will orders be placed in the selected currency? =

Orders are processed in your base WooCommerce currency, but customers see prices in their selected currency throughout the shopping process.

= Is this compatible with payment gateways? =

Yes, the plugin works with all WooCommerce payment gateways as it doesn't change your base currency.

= Can I set different exchange rates for different products? =

Currently, exchange rates apply to all products. Per-product rates may be added in future versions.

= Does it work with variable products? =

Yes, the plugin fully supports WooCommerce variable products and their variations.

= What happens if I deactivate a currency? =

The currency won't appear in the frontend switcher, but existing data remains in the database.

= Can I delete currencies? =

Yes, you can delete non-default currencies from the admin panel.

== Screenshots ==

1. Admin dashboard showing currency list with exchange rates
2. Add/Edit currency interface with all settings
3. Frontend currency switcher dropdown on the website
4. Product page showing converted prices
5. Cart and checkout with selected currency

== Changelog ==

= 1.0.3 =
* Added GPL v2 license compatibility for WordPress.org
* Created readme.txt for plugin repository submission
* Improved code documentation

= 1.0.2 =
* Added auto-update functionality via GitHub
* Improved database error handling
* Enhanced admin UI/UX

= 1.0.1 =
* Fixed cart price conversion issues
* Added email integration for order notifications
* Improved session management

= 1.0.0 =
* Initial release
* Multi-currency support
* Admin dashboard for currency management
* Frontend currency switcher
* WooCommerce integration

== Upgrade Notice ==

= 1.0.3 =
This version adds GPL v2 license compatibility and is ready for WordPress.org submission.

= 1.0.2 =
Adds automatic updates from GitHub. Recommended for all users.

= 1.0.1 =
Important fixes for cart and email functionality. Update recommended.

= 1.0.0 =
First public release.

== Additional Information ==

= Developer Info =

This plugin is actively maintained. For developers who want to contribute or report issues:

* GitHub Repository: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher
* Report Issues: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/issues

= Privacy Policy =

This plugin stores currency preferences in browser cookies and PHP sessions. No personal data is sent to external servers.

= Translation Ready =

The plugin is translation ready with the text domain: `custom-wc-currency`

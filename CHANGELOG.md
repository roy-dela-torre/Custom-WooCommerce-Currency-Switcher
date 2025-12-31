# Changelog

All notable changes to the Custom WooCommerce Currency Switcher plugin will be documented in this file.

## [1.0.1] - 2025-01-01

### Added
- **Automatic Updates from GitHub** - Plugin now checks for and installs updates directly from GitHub repository
- GitHub updater class for seamless updates
- Cookie fallback for currency selection (30-day persistence)
- Better session handling with WordPress init hook
- Console logging for debugging currency switches
- Database table existence check with manual creation option
- Better error messages for database operations

### Fixed
- Currency switcher now properly persists selection across page loads
- Session starting at correct time in WordPress lifecycle
- Form submission error messages now display immediately
- Currency selection storage improved with dual session + cookie approach

### Changed
- Improved AJAX response handling with detailed console logs
- Enhanced currency retrieval with cookie fallback
- Better admin page error handling and user feedback

## [1.0.0] - 2025-01-01

### Added
- Initial release of Custom WooCommerce Currency Switcher
- Admin dashboard for managing currencies
  - Add new currencies with name, symbol, code, and multiplier
  - Edit existing currencies
  - Delete non-default currencies
  - Set default currency
  - Enable/disable currencies
- Frontend currency switcher widget
  - Fixed position currency selector
  - Dropdown with all active currencies
  - Session-based currency storage
  - Automatic page reload on currency change
- Price conversion functionality
  - Single product pages
  - Product archives/categories
  - Cart page
  - Checkout page
  - Order emails
- Database management
  - Custom table for storing currency data
  - Automatic table creation on activation
  - Default currency auto-setup from WooCommerce
- Security features
  - Nonce verification for AJAX requests
  - SQL injection prevention
  - XSS protection
  - CSRF protection on forms
  - Capability checks for admin actions
- Documentation
  - Comprehensive README.md
  - Step-by-step INSTALLATION.md
  - Currency reference guide with 100+ currencies
  - Code comments throughout
- Assets
  - Frontend JavaScript for currency switcher
  - Frontend CSS for styling
  - Admin JavaScript for management interface
  - Admin CSS for dashboard styling
- Multilingual support ready
  - Text domain: 'custom-wc-currency'
  - Translation-ready strings

### Features
- ✅ Unlimited currencies support
- ✅ Real-time currency switching
- ✅ Automatic price conversion
- ✅ WooCommerce integration
- ✅ Email integration
- ✅ Session management
- ✅ Responsive design
- ✅ Easy to customize

### Compatibility
- WordPress 5.8+
- WooCommerce 5.0+
- PHP 7.4+
- Tested with major themes

---

## [Unreleased]

### Planned Features for Future Versions

#### Version 1.1.0 (Planned)
- [ ] Shortcode support for placing currency switcher anywhere
- [ ] Widget support for sidebars
- [ ] Admin settings page for customization
- [ ] Position settings for currency switcher
- [ ] Color customization options
- [ ] Currency switcher styles (dropdown, buttons, flags)

#### Version 1.2.0 (Planned)
- [ ] Automatic exchange rate updates via API
- [ ] Support for multiple exchange rate providers
- [ ] Rate caching system
- [ ] Manual rate override option
- [ ] Historical rate tracking

#### Version 1.3.0 (Planned)
- [ ] Currency flags/icons support
- [ ] Country flag display option
- [ ] Custom icon upload
- [ ] Geolocation-based currency auto-selection
- [ ] User preference saving (cookies/account)

#### Version 1.4.0 (Planned)
- [ ] Bulk currency import/export
- [ ] CSV import functionality
- [ ] Currency groups/regions
- [ ] Multi-language support
- [ ] RTL language support

#### Version 1.5.0 (Planned)
- [ ] Analytics and reporting
- [ ] Most used currencies dashboard
- [ ] Conversion rate analytics
- [ ] Revenue by currency
- [ ] Customer location tracking

#### Version 2.0.0 (Planned)
- [ ] REST API endpoints
- [ ] Headless commerce support
- [ ] React/Vue.js currency switcher component
- [ ] Advanced caching mechanisms
- [ ] Performance optimizations
- [ ] Cryptocurrency support

### Potential Features Under Consideration
- WooCommerce Subscriptions compatibility
- WooCommerce Memberships integration
- Multi-vendor marketplace support
- B2B wholesale pricing integration
- Dynamic pricing rules per currency
- Payment gateway currency restrictions
- Rounding rules customization
- Currency-specific shipping rates
- Tax calculation per currency
- Refund handling in different currencies

---

## Version History

### Version Numbering
This project follows [Semantic Versioning](https://semver.org/):
- MAJOR version for incompatible API changes
- MINOR version for new functionality in a backward compatible manner
- PATCH version for backward compatible bug fixes

### Support Policy
- Latest version receives active development
- Previous minor version receives security updates for 6 months
- Users encouraged to update to latest version

---

## How to Report Issues

If you encounter bugs or have feature requests:
1. Check existing issues first
2. Provide WordPress version
3. Provide WooCommerce version
4. Provide PHP version
5. Describe steps to reproduce
6. Include screenshots if applicable
7. Share error logs if available

---

## Contributing

Contributions are welcome! To contribute:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request
6. Describe your changes clearly

---

## Credits & Acknowledgments

### Built With
- WordPress Plugin API
- WooCommerce Hooks & Filters
- jQuery
- PHP Sessions

### Inspired By
- Real-world multi-currency e-commerce needs
- WooCommerce community feedback
- International payment processing requirements

### Special Thanks
- WooCommerce community
- WordPress developers
- Beta testers (if applicable)
- Feature contributors

---

**Stay Updated**: Check this file regularly for new features and updates!

---

*Last Updated: 2025-01-01*

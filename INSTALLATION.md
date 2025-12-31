# Installation & Setup Guide

## Quick Start

Follow these steps to install and configure the Custom WooCommerce Currency Switcher plugin.

---

## Step 1: Installation

### Method 1: Manual Upload
1. Download/copy the `custom-woocommerce-currency` folder
2. Upload it to `/wp-content/plugins/` directory on your server
3. Go to WordPress Admin → Plugins
4. Find "Custom WooCommerce Currency Switcher"
5. Click **Activate**

### Method 2: ZIP Upload (if zipped)
1. Go to WordPress Admin → Plugins → Add New
2. Click **Upload Plugin**
3. Choose the ZIP file
4. Click **Install Now**
5. Click **Activate Plugin**

---

## Step 2: Verify Installation

After activation, you should see:
- ✅ "Currency Switcher" menu in WordPress admin sidebar
- ✅ A success message (if any)
- ✅ Default currency automatically created

---

## Step 3: Configure Your First Currency

1. Go to **Currency Switcher** in admin menu
2. You'll see your default currency (from WooCommerce settings)
3. Click **Add New** to add additional currencies

### Example 1: Adding US Dollar (if not default)
- **Currency Name**: US Dollar
- **Currency Symbol**: $
- **Currency Code**: USD
- **Multiplier**: 1.00 (if this is your base) or calculate from your default
- **Set as Default**: ☐ (leave unchecked if already have default)
- **Status**: Active

### Example 2: Adding Euro
- **Currency Name**: Euro
- **Currency Symbol**: €
- **Currency Code**: EUR
- **Multiplier**: 0.85 (if 1 USD = 0.85 EUR)
- **Set as Default**: ☐
- **Status**: Active

### Example 3: Adding British Pound
- **Currency Name**: British Pound
- **Currency Symbol**: £
- **Currency Code**: GBP
- **Multiplier**: 0.73 (if 1 USD = 0.73 GBP)
- **Set as Default**: ☐
- **Status**: Active

---

## Step 4: Understanding Multipliers

The multiplier converts from your **default currency** to the target currency.

### Formula:
```
Target Currency Price = Default Currency Price × Multiplier
```

### Real Examples:

**Scenario 1: Default is USD**
- Product costs: $100 USD
- EUR multiplier: 0.85
- Result: €85 EUR

**Scenario 2: Default is EUR**
- Product costs: €100 EUR
- USD multiplier: 1.18
- Result: $118 USD

**Scenario 3: Default is USD**
- Product costs: $100 USD
- JPY multiplier: 110
- Result: ¥11,000 JPY

### Getting Current Exchange Rates:
- Visit [xe.com](https://www.xe.com) for live rates
- Use Google: "1 USD to EUR"
- Update multipliers regularly for accuracy

---

## Step 5: Test the Frontend

1. Visit your WooCommerce store
2. Look for the currency switcher widget (top-right by default)
3. Click on it to see available currencies
4. Select a different currency
5. Verify prices update across:
   - Product pages
   - Category pages
   - Cart
   - Checkout

---

## Step 6: Customize Appearance (Optional)

### Change Switcher Position

Edit `assets/frontend.css`:

```css
.cwc-currency-switcher {
    position: fixed;
    top: 100px;    /* Change vertical position */
    right: 20px;   /* Change horizontal position */
    /* Or use left: 20px; for left side */
}
```

### Change Switcher Colors

```css
.cwc-switcher-toggle {
    background: #ff6b6b;  /* Change background color */
    color: #ffffff;       /* Change text color */
}

.cwc-switcher-toggle:hover {
    background: #ee5a52;  /* Hover color */
}
```

---

## Step 7: Email Configuration

The plugin automatically:
- ✅ Shows converted prices in order emails
- ✅ Displays currency information
- ✅ Shows exchange rate used

**No additional configuration needed!**

Test it:
1. Place a test order with a non-default currency selected
2. Check the order confirmation email
3. Verify prices are in the selected currency

---

## Common Setup Scenarios

### Scenario 1: US Store Selling to Europe
**Default Currency**: USD

| Currency | Symbol | Code | Multiplier | Example Conversion |
|----------|--------|------|------------|-------------------|
| US Dollar | $ | USD | 1.00 | $100 → $100 |
| Euro | € | EUR | 0.85 | $100 → €85 |
| British Pound | £ | GBP | 0.73 | $100 → £73 |

### Scenario 2: European Store Selling Globally
**Default Currency**: EUR

| Currency | Symbol | Code | Multiplier | Example Conversion |
|----------|--------|------|------------|-------------------|
| Euro | € | EUR | 1.00 | €100 → €100 |
| US Dollar | $ | USD | 1.18 | €100 → $118 |
| British Pound | £ | GBP | 0.86 | €100 → £86 |
| Canadian Dollar | C$ | CAD | 1.57 | €100 → C$157 |

### Scenario 3: Multi-Region Store
**Default Currency**: USD

| Currency | Symbol | Code | Multiplier |
|----------|--------|------|------------|
| US Dollar | $ | USD | 1.00 |
| Euro | € | EUR | 0.85 |
| British Pound | £ | GBP | 0.73 |
| Australian Dollar | A$ | AUD | 1.35 |
| Canadian Dollar | C$ | CAD | 1.33 |
| Japanese Yen | ¥ | JPY | 110.00 |
| Swiss Franc | CHF | CHF | 0.92 |

---

## Troubleshooting Setup

### Issue: Plugin won't activate
**Solution**: 
- Ensure WooCommerce is installed and active
- Check PHP version (requires 7.4+)
- Check WordPress version (requires 5.8+)

### Issue: Currency switcher not showing
**Solution**:
- Clear browser cache
- Check that you have at least one active currency
- Verify the theme doesn't hide fixed position elements
- Check `wp_footer()` is called in your theme

### Issue: Prices not converting
**Solution**:
- Verify multiplier is not 1.00 (unless it's the default)
- Check currency is marked as "Active"
- Clear PHP session: logout and login again
- Check browser console for JavaScript errors

### Issue: Database table not created
**Solution**:
- Deactivate and reactivate the plugin
- Check database permissions
- Manually run activation: Go to Plugins → Deactivate → Activate

---

## Maintenance Tips

### 1. Update Exchange Rates Regularly
- Visit **Currency Switcher** admin page
- Click **Edit** on each currency
- Update the multiplier with current rates
- Recommended: Update weekly or monthly

### 2. Monitor Currency Usage
- Check which currencies customers use most
- Consider disabling rarely used currencies
- Keep 3-5 main currencies active for best performance

### 3. Backup Before Updates
- Backup your database before plugin updates
- Export currency settings (manually note them down)
- Test on staging site first if possible

---

## Next Steps

✅ Add multiple currencies
✅ Test on live site
✅ Monitor customer usage
✅ Adjust exchange rates periodically
✅ Customize appearance to match your theme

---

## Need Help?

If you encounter issues:
1. Check the main README.md file
2. Review this installation guide
3. Check WordPress debug log
4. Verify WooCommerce is properly configured

---

**Congratulations! Your multi-currency store is ready! 🎉**

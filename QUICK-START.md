# Quick Start Guide

Get your multi-currency WooCommerce store running in 5 minutes! ⚡

---

## 🚀 5-Minute Setup

### Step 1: Install (1 minute)
1. Upload `custom-woocommerce-currency` folder to `/wp-content/plugins/`
2. Go to **Plugins** → Find the plugin → Click **Activate**

### Step 2: Add Your First Currency (2 minutes)
1. Go to **Currency Switcher** in WordPress admin
2. Click **Add New**
3. Fill in:
   - **Name**: Euro
   - **Symbol**: €
   - **Code**: EUR
   - **Multiplier**: 0.85 (example rate)
4. Click **Add Currency**

### Step 3: Test It! (2 minutes)
1. Visit your store
2. Look for currency switcher (top-right corner)
3. Switch to your new currency
4. Check product prices update ✅

**Done! You're now multi-currency! 🎉**

---

## 💡 Common Setup Examples

### Setup #1: US Store Adding Euro
```
Default: USD ($)
Add: EUR (€) with multiplier 0.85

Result: $100 product becomes €85
```

### Setup #2: UK Store Adding US Dollar
```
Default: GBP (£)
Add: USD ($) with multiplier 1.37

Result: £100 product becomes $137
```

### Setup #3: Global Store (3 currencies)
```
Default: USD ($) - multiplier 1.00
Add: EUR (€) - multiplier 0.85
Add: GBP (£) - multiplier 0.73

Test all three currencies on your products!
```

---

## 📊 Finding Exchange Rates

**Quick Method**: Google it!
- Search: "1 USD to EUR"
- Use the number Google shows as your multiplier

**Professional Method**: 
- Visit [xe.com](https://www.xe.com)
- Enter: 1 [Your Default Currency]
- To: [Target Currency]
- Use the result as your multiplier

---

## 🎨 Customizing Position

Want to move the currency switcher?

Edit `assets/frontend.css`:

```css
/* Move to top-left */
.cwc-currency-switcher {
    top: 100px;
    left: 20px;  /* Changed from 'right' */
}

/* Move to bottom-right */
.cwc-currency-switcher {
    top: auto;
    bottom: 20px;
    right: 20px;
}
```

---

## ✅ Testing Checklist

After setup, verify:
- [ ] Currency switcher appears on site
- [ ] Can switch between currencies
- [ ] Product prices update correctly
- [ ] Cart totals update correctly
- [ ] Checkout shows correct currency
- [ ] Test order email shows correct prices

---

## 🔧 Troubleshooting Quick Fixes

**Switcher not showing?**
→ Add at least one active currency besides default

**Prices not changing?**
→ Check multiplier is not 1.00 (unless it's default)

**"WooCommerce Required" error?**
→ Install and activate WooCommerce first

**Currency deleted but still shows?**
→ Clear browser cache

---

## 📱 Mobile Friendly

The currency switcher is automatically responsive!
- Adjusts size on mobile devices
- Touch-friendly dropdown
- Works on all screen sizes

---

## 🌍 Popular Currency Setups

### North American Store
- USD ($) - Default
- CAD (C$) - 1.33
- MXN ($) - 20.00

### European Store
- EUR (€) - Default
- USD ($) - 1.18
- GBP (£) - 0.86
- CHF (CHF) - 1.08

### Asian Pacific Store
- USD ($) - Default
- JPY (¥) - 110
- AUD (A$) - 1.35
- SGD (S$) - 1.35
- HKD (HK$) - 7.80

### Global E-commerce
- USD ($) - Default
- EUR (€) - 0.85
- GBP (£) - 0.73
- AUD (A$) - 1.35
- CAD (C$) - 1.33
- JPY (¥) - 110

---

## 🎯 Pro Tips

1. **Update Rates Weekly**: Exchange rates change daily
2. **Start Simple**: Add 2-3 currencies first, expand later
3. **Test Orders**: Place test orders in each currency
4. **Monitor Usage**: See which currencies customers use most
5. **Add Buffer**: Consider adding 2-3% to rates to cover fluctuations

---

## 📚 Need More Info?

- **Full Guide**: See `README.md`
- **Detailed Install**: See `INSTALLATION.md`
- **Currency Codes**: See `CURRENCY-REFERENCE.md`
- **Updates**: See `CHANGELOG.md`

---

## 🆘 Quick Support

**Before asking for help**:
1. Check you're running latest WooCommerce
2. Try deactivating other plugins
3. Clear browser cache
4. Check browser console for errors
5. Review the documentation

---

## 🎓 Video Tutorial (Concept)

If this plugin had a video tutorial, it would show:
1. ⏱️ 0:00 - Installation
2. ⏱️ 1:00 - Adding first currency
3. ⏱️ 2:30 - Testing on frontend
4. ⏱️ 3:30 - Customizing appearance
5. ⏱️ 4:30 - Best practices

---

## 💪 You're Ready!

That's it! Your store now supports multiple currencies.

**What's Next?**
- Add more currencies
- Customize the switcher appearance  
- Set up automatic rate updates (future feature)
- Monitor which currencies are most popular

---

**Questions?** Check the full documentation files for detailed information.

**Happy selling globally! 🌍💰**

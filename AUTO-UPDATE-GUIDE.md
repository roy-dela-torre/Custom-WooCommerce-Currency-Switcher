# 🔄 Automatic Updates Guide

This plugin supports automatic updates from GitHub!

## 📥 How It Works

Once installed, the plugin will:
1. Check for new releases on GitHub automatically
2. Show update notifications in WordPress Admin → Plugins
3. Allow one-click updates directly from the admin panel

## 🚀 Creating a New Release (For Developers)

### Method 1: Using Git Tags (Recommended)

1. **Update the version** in `custom-woocommerce-currency.php`:
   ```php
   * Version: 1.0.1
   ```
   And also update the constant:
   ```php
   define('CWC_VERSION', '1.0.1');
   ```

2. **Commit your changes**:
   ```bash
   git add .
   git commit -m "Version 1.0.1 - Added new features"
   git push origin main
   ```

3. **Create a new tag**:
   ```bash
   git tag -a v1.0.1 -m "Release version 1.0.1"
   git push origin v1.0.1
   ```

4. **GitHub Actions will automatically**:
   - Create a new release
   - Make it available for WordPress auto-update

### Method 2: Manual Release on GitHub

1. Go to https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases
2. Click "Draft a new release"
3. Create a new tag (e.g., `v1.0.1`)
4. Fill in release title and description
5. Click "Publish release"

## 📋 Version Numbering

Follow semantic versioning: `MAJOR.MINOR.PATCH`

- **MAJOR**: Breaking changes (1.0.0 → 2.0.0)
- **MINOR**: New features, backward compatible (1.0.0 → 1.1.0)
- **PATCH**: Bug fixes (1.0.0 → 1.0.1)

## ✅ Example Release Workflow

```bash
# 1. Make your changes
# Edit files...

# 2. Update version number in plugin file
# custom-woocommerce-currency.php line 6 and line 23

# 3. Update CHANGELOG.md
# Document your changes

# 4. Commit and push
git add .
git commit -m "Fix: Currency switcher reload issue"
git push origin main

# 5. Create and push tag
git tag -a v1.0.1 -m "Release 1.0.1 - Bug fixes"
git push origin v1.0.1

# 6. Done! Users will see the update in WordPress
```

## 🔍 Testing Updates

To test the update mechanism:

1. Install plugin version 1.0.0
2. Create a new release with version 1.0.1
3. Go to WordPress Admin → Dashboard → Updates
4. You should see the plugin update available
5. Click "Update Now"

## 🐛 Troubleshooting

**Update not showing?**
- Check that the tag has a 'v' prefix (v1.0.1 not 1.0.1)
- Wait a few minutes - WordPress caches update checks
- Force check: Dashboard → Updates → "Check Again"

**Update fails?**
- Ensure GitHub release was created successfully
- Check that the ZIP file is accessible
- Verify version numbers match in both files

## 📁 Files That Control Updates

- `custom-woocommerce-currency.php` - Contains updater class
- `.github/workflows/release.yml` - Automates release creation
- `CHANGELOG.md` - Displayed in update information

## 🎯 Quick Release Checklist

- [ ] Update version in plugin header
- [ ] Update CWC_VERSION constant
- [ ] Update CHANGELOG.md
- [ ] Commit and push changes
- [ ] Create and push version tag
- [ ] Verify release on GitHub
- [ ] Test update in WordPress

## 💡 Pro Tips

1. **Always test locally first** before creating a release
2. **Use meaningful version numbers** that reflect the changes
3. **Write clear changelog entries** - users will see them
4. **Tag format matters** - always use `v` prefix (v1.0.1)
5. **Keep main branch stable** - only push working code

---

**Need help?** Open an issue on GitHub!

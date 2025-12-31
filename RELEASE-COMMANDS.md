# 🚀 Quick Release Commands

## Method 1: Using PowerShell Script (Windows - Easiest)

```powershell
# Update to version 1.0.2 with a message
.\deploy.ps1 -Version "1.0.2" -Message "Fixed currency switching bug"

# That's it! Script handles everything automatically
```

## Method 2: Using Bash Script (Linux/Mac)

```bash
# Update to version 1.0.2 with a message
./deploy.sh 1.0.2 "Fixed currency switching bug"

# That's it! Script handles everything automatically
```

## Method 3: Manual Commands

```bash
# 1. Update version numbers manually in custom-woocommerce-currency.php
#    Line 6: Version: 1.0.2
#    Line 23: define('CWC_VERSION', '1.0.2');

# 2. Commit and push
git add .
git commit -m "Version 1.0.2 - Fixed currency switching bug"
git push origin main

# 3. Create and push tag
git tag -a v1.0.2 -m "Version 1.0.2 - Fixed currency switching bug"
git push origin v1.0.2

# 4. Done! Check GitHub for the release
```

## 📋 Pre-Release Checklist

Before creating a release:

- [ ] Test all changes locally
- [ ] Update version number in plugin file (2 places)
- [ ] Update CHANGELOG.md with new version
- [ ] Commit all changes
- [ ] Run deploy script or manual commands
- [ ] Verify release on GitHub
- [ ] Test update in WordPress (optional)

## 🔍 Verify Release

After pushing:

1. Go to: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases
2. You should see your new release (created by GitHub Actions)
3. WordPress sites will detect the update within 12 hours

## 💡 Tips

- **Always use 'v' prefix** for tags: `v1.0.2` not `1.0.2`
- **Semantic versioning**: MAJOR.MINOR.PATCH (1.0.0)
- **Clear messages**: Describe what changed
- **Test first**: Make sure everything works before releasing

## ⚡ Common Release Scenarios

### Bug Fix Release (Patch)
```powershell
.\deploy.ps1 -Version "1.0.3" -Message "Fix: Resolved session persistence issue"
```

### New Feature Release (Minor)
```powershell
.\deploy.ps1 -Version "1.1.0" -Message "Feature: Added automatic exchange rate updates"
```

### Breaking Changes (Major)
```powershell
.\deploy.ps1 -Version "2.0.0" -Message "Major: Redesigned admin interface"
```

## 🆘 If Something Goes Wrong

### Delete a tag
```bash
# Delete local tag
git tag -d v1.0.2

# Delete remote tag
git push origin :refs/tags/v1.0.2
```

### Redo a release
1. Delete the tag (see above)
2. Fix your code
3. Run deploy script again with same version

---

**Need help?** Check [AUTO-UPDATE-GUIDE.md](AUTO-UPDATE-GUIDE.md) for detailed information.

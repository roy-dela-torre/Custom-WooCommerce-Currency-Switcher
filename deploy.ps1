# WooCommerce Currency Switcher - Quick Release Script (PowerShell)
# Usage: .\deploy.ps1 -Version "1.0.2" -Message "Bug fixes and improvements"

param(
    [Parameter(Mandatory=$true)]
    [string]$Version,
    
    [Parameter(Mandatory=$false)]
    [string]$Message = "Release version $Version"
)

Write-Host "🚀 Deploying Custom WooCommerce Currency Switcher v$Version" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

# Update version in plugin file
Write-Host "📝 Updating version numbers..." -ForegroundColor Yellow

$pluginFile = "custom-woocommerce-currency.php"
$content = Get-Content $pluginFile -Raw

# Update plugin header version
$content = $content -replace "Version:\s*\d+\.\d+\.\d+", "Version: $Version"

# Update constant version
$content = $content -replace "define\('CWC_VERSION',\s*'\d+\.\d+\.\d+'", "define('CWC_VERSION', '$Version'"

Set-Content $pluginFile $content

Write-Host "✅ Version updated to $Version" -ForegroundColor Green
Write-Host ""

# Git operations
Write-Host "📦 Committing changes..." -ForegroundColor Yellow
git add .
git commit -m $Message

Write-Host "⬆️  Pushing to GitHub..." -ForegroundColor Yellow
git push origin main

Write-Host "🏷️  Creating tag v$Version..." -ForegroundColor Yellow
git tag -a "v$Version" -m $Message
git push origin "v$Version"

Write-Host ""
Write-Host "✅ Release v$Version created successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "🔗 View release: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases" -ForegroundColor Cyan
Write-Host "⏱️  GitHub Actions will create the release in a few moments" -ForegroundColor Cyan
Write-Host "🔄 WordPress sites will see the update within 12 hours" -ForegroundColor Cyan
Write-Host ""
Write-Host "💡 To force immediate update check in WordPress:" -ForegroundColor Yellow
Write-Host "   Dashboard → Updates → Check Again" -ForegroundColor White

#!/bin/bash

# WooCommerce Currency Switcher - Quick Release Script
# Usage: ./deploy.sh 1.0.2 "Bug fixes and improvements"

if [ -z "$1" ]; then
    echo "❌ Error: Version number required"
    echo "Usage: ./deploy.sh 1.0.2 \"Release message\""
    exit 1
fi

VERSION=$1
MESSAGE=${2:-"Release version $VERSION"}

echo "🚀 Deploying Custom WooCommerce Currency Switcher v$VERSION"
echo "================================================"

# Update version in plugin file
echo "📝 Updating version numbers..."
sed -i "s/Version: [0-9.]\+/Version: $VERSION/" custom-woocommerce-currency.php
sed -i "s/define('CWC_VERSION', '[0-9.]\+'/define('CWC_VERSION', '$VERSION'/" custom-woocommerce-currency.php

# Git operations
echo "📦 Committing changes..."
git add .
git commit -m "$MESSAGE"

echo "⬆️  Pushing to GitHub..."
git push origin main

echo "🏷️  Creating tag v$VERSION..."
git tag -a "v$VERSION" -m "$MESSAGE"
git push origin "v$VERSION"

echo ""
echo "✅ Release v$VERSION created successfully!"
echo ""
echo "🔗 View release: https://github.com/roy-dela-torre/Custom-WooCommerce-Currency-Switcher/releases"
echo "⏱️  GitHub Actions will create the release in a few moments"
echo "🔄 WordPress sites will see the update within 12 hours"
echo ""
echo "💡 To force immediate update check in WordPress:"
echo "   Dashboard → Updates → Check Again"

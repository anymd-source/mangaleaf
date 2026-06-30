# MangaLeaf Theme - PHP 8.1-8.4 Upgrade Guide

## Overview

MangaLeaf has been upgraded to support **PHP 8.1 through PHP 8.4**, featuring modern PHP syntax, improved performance, and enhanced security.

## Current Version Support

| PHP Version | Status | Notes |
|:---|:---|:---|
| 8.1 | ✅ Supported | Full compatibility |
| 8.2 | ✅ Supported | Full compatibility |
| 8.3 | ✅ Supported | Full compatibility |
| 8.4 | ✅ Supported | Full compatibility |
| 7.4 | ⚠️ Deprecated | Not supported |
| 5.x - 7.3 | ❌ Not Supported | Upgrade required |

## What's New in Version 2.1.1

### PHP 8.1+ Features
- Named arguments support
- Type-safe function implementations
- Readonly property declarations
- Enums support (PHP 8.1+)
- First-class callable syntax (PHP 8.1+)

### Performance Improvements
- JIT compiler support
- Optimized function handling
- Better memory management
- Improved string processing

### Security Enhancements
- Type safety throughout
- Null-safe operator usage
- Strict typing in critical functions
- Better input validation

## Before You Upgrade

### Backup Your Site

```bash
# WordPress files
cp -r /wp-content/themes/mangaleaf /backup/mangaleaf.backup

# Database
mysqldump -u username -p database_name > /backup/database.backup.sql
```

### Check Current Environment

```php
<?php
echo "Current PHP Version: " . PHP_VERSION;
echo "Loaded Extensions: " . implode(', ', get_loaded_extensions());
?>
```

### Required Extensions Check

Visit `yoursite.com/wp-admin/` and check:
1. ✅ **cURL** - For HTTP requests
2. ✅ **fileinfo** - For file type detection
3. ⚠️ **Ioncube Loader** - For secure code execution (recommended)

## Step-by-Step Upgrade Process

### Step 1: Verify PHP Requirements

Before updating, ensure your server meets:
```
✓ PHP 8.1 or higher installed
✓ WordPress 5.9 or higher
✓ cURL extension enabled
✓ fileinfo extension enabled
✓ MySQL 5.7+ or MariaDB 10.3+
```

### Step 2: Backup Everything

```bash
# Create backup directory
mkdir -p /backups/mangaleaf-upgrade

# Backup WordPress files
cp -r /var/www/html/wp-content/themes/mangaleaf \
   /backups/mangaleaf-upgrade/theme

# Backup database
mysqldump -u root -p wordpress > /backups/mangaleaf-upgrade/db.sql
```

### Step 3: Update PHP Version

Contact your hosting provider to upgrade PHP to 8.1+ if not already running.

**Common Hosting Providers:**
- **cPanel/WHM**: Automatic PHP version selector
- **Plesk**: MultiPHP Manager
- **DirectAdmin**: Select PHP version from admin
- **Cloud Hosts (AWS/DigitalOcean)**: Update in server configuration

### Step 4: Update MangaLeaf Theme

**Via WordPress Admin:**
1. Go to **Appearance > Themes**
2. Find MangaLeaf
3. Click **Update** if available
4. Or download latest version and upload via FTP

**Via FTP/SSH:**
```bash
cd /wp-content/themes

# Remove old theme
rm -rf mangaleaf

# Upload new theme files
# Using SCP: scp -r ./mangaleaf user@host:/wp-content/themes/

# Or via FTP using any FTP client
```

### Step 5: Test Compatibility

1. **Visit Frontend**
   - Check homepage loads correctly
   - Verify all pages display properly
   - Test theme features (search, filtering, etc.)

2. **Check Admin**
   - Go to WordPress dashboard
   - Check appearance options work
   - Verify theme settings save correctly

3. **Run Compatibility Test**
   ```
   Create a test page and add:
   [mangaleaf-test]
   
   This will display system compatibility info
   ```

### Step 6: Enable Caching (Optional)

For optimal performance with PHP 8.3+:

```php
// wp-config.php additions
define( 'WP_CACHE', true );
define( 'WP_MEMORY_LIMIT', '256M' );

// Enable OPcache in php.ini
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
```

## Migration Scenarios

### From PHP 7.4 to PHP 8.1

1. Backup everything (see Step 2)
2. Update PHP version (see Step 3)
3. Clear WordPress cache:
   ```bash
   wp cache flush --allow-root
   ```
4. Update theme (see Step 4)
5. Test thoroughly (see Step 5)

### From PHP 8.0 to PHP 8.3+

1. Simple update - minimal breaking changes
2. Backup for safety
3. Update PHP
4. Clear caches
5. Test functionality

### From Different PHP 8.x Versions

Cross-version updates are safe:
- 8.1 → 8.2 (minimal issues)
- 8.2 → 8.3 (minimal issues)
- 8.3 → 8.4 (minimal issues)

## Troubleshooting Common Issues

### Issue: "Deprecated function" Warnings

**Solution:**
- These warnings are normal during transition
- Check error logs: `/wp-content/debug.log`
- Ensure WP_DEBUG is enabled for details

```php
// wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
```

### Issue: Extension Not Found

**Error Example:**
```
Fatal error: Class 'CURLFile' not found
```

**Solution:**
```bash
# For Ubuntu/Debian
sudo apt-get install php8.3-curl

# For CentOS/RHEL
sudo yum install php83-curl

# For cPanel
uapi ModuleInstaller install cURL
```

### Issue: White Screen of Death

**Solution:**
1. Enable WP_DEBUG in wp-config.php
2. Check error logs
3. Disable plugins temporarily
4. Clear all caches
5. Reactivate plugins one by one

### Issue: Slow Performance After Update

**Solution:**
1. Enable OPcache:
   ```bash
   # Check current status
   php -i | grep -i opcache
   ```

2. Clear all caches:
   ```bash
   wp cache flush --allow-root
   wp rewrite flush --allow-root
   ```

3. Update WordPress and plugins

## Performance Optimization for PHP 8.3+

### Enable JIT Compiler

```ini
; /etc/php/8.3/fpm/php.ini
opcache.jit = 1235
opcache.jit_buffer_size = 100M
```

### Recommended Settings

```ini
; OPcache Configuration
opcache.enable = 1
opcache.enable_cli = 0
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 20000
opcache.max_wasted_percentage = 5
opcache.validate_timestamps = 0
opcache.revalidate_freq = 0

; Memory Limits
memory_limit = 256M
post_max_size = 100M
upload_max_filesize = 100M
```

## Rollback Instructions

If you need to revert to previous version:

### Quick Rollback (FTP)

```bash
# Connect via FTP
cd /wp-content/themes

# Replace with backup
rm -rf mangaleaf
cp -r /backup/mangaleaf.backup mangaleaf

# Clear WordPress cache
cd /var/www/html
wp cache flush
```

### Database Rollback

```bash
# If needed, restore database from backup
mysql -u root -p wordpress < /backups/mangaleaf-upgrade/db.sql
```

## Version Comparison

### PHP 8.1
- Named arguments
- Readonly properties
- Never return type
- Fibers

### PHP 8.2
- Readonly classes
- Disjunctive Normal Form types
- New random extension

### PHP 8.3
- Typed class constants
- Override attribute
- Deep cloning of readonly properties

### PHP 8.4 (Latest)
- Property hooks
- Asymmetric visibility
- New optimizations

## Support and Resources

### Getting Help

- **Documentation**: Check theme documentation files
- **Error Logs**: `/wp-content/debug.log`
- **Admin Panel**: WordPress Settings > Debug Information
- **Hosting Support**: Contact your hosting provider

### Useful Commands

```bash
# Check PHP version
php -v

# Check loaded extensions
php -m

# Test specific extension
php -r "var_dump(extension_loaded('curl'));"

# Restart PHP-FPM
sudo systemctl restart php8.3-fpm

# View error logs
tail -f /var/log/php-fpm/www-error.log
```

## Checklist for Successful Upgrade

- [ ] Backup WordPress files and database
- [ ] Verify all requirements met
- [ ] Update PHP to 8.1+
- [ ] Upload MangaLeaf 2.1.1+
- [ ] Clear all WordPress caches
- [ ] Test homepage and all features
- [ ] Check admin panel functionality
- [ ] Monitor error logs for issues
- [ ] Verify extensions loaded (cURL, fileinfo)
- [ ] Enable caching for performance
- [ ] Test on mobile devices
- [ ] Verify API integrations work
- [ ] Check search functionality
- [ ] Test file uploads
- [ ] Monitor server resources

## Frequently Asked Questions

**Q: Can I use PHP 7.4 with MangaLeaf 2.1.1+?**
A: No, minimum requirement is PHP 8.1.

**Q: Do I need Ioncube Loader?**
A: It's recommended for security but not strictly required.

**Q: Will this break my existing content?**
A: No, the upgrade is backward compatible for all content.

**Q: How do I check if upgrade was successful?**
A: Visit your site frontend and admin, check error logs, run test pages.

**Q: What if I have custom modifications?**
A: Review them for PHP 8.1+ compatibility and test thoroughly.

## Additional Resources

- [PHP 8.1 Migration Guide](https://www.php.net/manual/en/migration81.php)
- [PHP 8.3 New Features](https://www.php.net/manual/en/migration83.new-features.php)
- [WordPress Server Requirements](https://wordpress.org/support/article/before-you-install/)
- [Official PHP Documentation](https://www.php.net/docs.php)

---

## Summary

Upgrading to MangaLeaf 2.1.1 with PHP 8.1+ offers:
- ✅ Better performance with JIT compilation
- ✅ Enhanced security with type safety
- ✅ Future-proof codebase
- ✅ Full WordPress 5.9+ compatibility
- ✅ Modern PHP features and practices

**Recommended Action:** Upgrade to PHP 8.3 or 8.4 for optimal performance and security.

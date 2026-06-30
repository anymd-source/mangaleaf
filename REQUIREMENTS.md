# MangaLeaf System Requirements

## Minimum Requirements

### PHP Version
- **PHP 8.1** or higher
- **PHP 8.4** is fully supported

### WordPress
- **WordPress 5.9** or higher
- Recommended: **WordPress 6.0+**

### Server Environment
- **MySQL 5.7+** or **MariaDB 10.3+**
- Minimum PHP extensions (see below)
- Write permissions on WordPress directories

### Storage
- Minimum 50MB for theme installation
- Additional space for media uploads (recommended 1GB+)

## Required PHP Extensions

### 1. **Ioncube Loader**
- Purpose: Secure code execution and protection
- Installation: Follow your hosting provider's instructions or contact support
- Verification: Check in phpinfo() for "ionCube Loader"

### 2. **cURL**
- Purpose: HTTP requests for remote API calls and external integrations
- Status: Usually enabled by default
- Verification: Check `curl_version()` in PHP

### 3. **fileinfo**
- Purpose: File type detection for uploads
- Status: Usually enabled by default
- Verification: Check `finfo_version()` in PHP

## Recommended Extensions (Optional but beneficial)

- **GD Library** - Image processing and thumbnails
- **Imagick** - Advanced image manipulation
- **JSON** - JSON processing (usually included)
- **mbstring** - Multi-byte string support
- **OpenSSL** - SSL/TLS support

## PHP 8.1-8.4 Specific Features

### PHP 8.1 Features
- Named arguments
- Readonly properties
- Fibers for async operations

### PHP 8.2 Features
- Readonly classes
- Disjunctive Normal Form types
- true/false/null types as standalone types

### PHP 8.3 Features
- Typed class constants
- Override attribute for OOP
- Deep cloning of readonly properties

### PHP 8.4 Features
- Property hooks
- Asymmetric visibility
- New JIT compiler improvements

## Browser Requirements

### Minimum Supported Versions
- Chrome/Edge: Latest 2 major versions
- Firefox: Latest 2 major versions
- Safari: Latest 2 major versions
- Mobile browsers: Current versions

## Verification Checklist

Before installation, verify you have:

- [ ] PHP 8.1 or higher installed
- [ ] WordPress 5.9 or higher
- [ ] Ioncube Loader extension enabled
- [ ] cURL extension enabled
- [ ] fileinfo extension enabled
- [ ] Write permissions on `/wp-content/themes/`
- [ ] At least 50MB free disk space
- [ ] MySQL 5.7+ or MariaDB 10.3+

## Troubleshooting

### Extension Not Found
If you see "Extension not found" errors:
1. Contact your hosting provider
2. Request extension installation
3. Check hosting documentation

### PHP Version Issues
If WordPress shows version compatibility warnings:
1. Check your actual PHP version: `phpinfo()`
2. Verify with your host that PHP 8.1+ is available
3. If needed, request PHP version upgrade

### Performance Optimization

With PHP 8.3+, enable:
- OPcache (usually enabled by default)
- JIT compilation for better performance

## Support

For installation help or compatibility issues:
- Contact your hosting provider
- Visit the WordPress support forums
- Check theme documentation

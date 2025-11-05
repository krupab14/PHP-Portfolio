# Krupa Bhalsod Portfolio - Deployment Guide

## Vercel Deployment

### Prerequisites
- Vercel account
- Database hosting (PlanetScale, Railway, or any MySQL provider)

### Step 1: Prepare Database
1. Create a MySQL database on your preferred provider
2. Import the schema from `Admin/query.sql`
3. Note your database credentials

### Step 2: Deploy to Vercel
1. Install Vercel CLI:
   ```bash
   npm i -g vercel
   ```

2. Login to Vercel:
   ```bash
   vercel login
   ```

3. Deploy:
   ```bash
   vercel --prod
   ```

### Step 3: Configure Environment Variables
In Vercel dashboard, add these environment variables:
- `ENVIRONMENT` = `production`
- `DB_HOST` = Your database host
- `DB_USERNAME` = Your database username  
- `DB_PASSWORD` = Your database password
- `DB_NAME` = Your database name
- `SITE_URL` = Your domain (e.g., https://yoursite.vercel.app)

### Step 4: Configure Domain (Optional)
1. Go to Vercel dashboard
2. Select your project
3. Go to Settings > Domains
4. Add your custom domain

## Alternative Hosting Options

### Traditional Web Hosting (cPanel/DirectAdmin)

1. **Upload Files**
   - Zip your project files
   - Upload to public_html or www directory
   - Extract files

2. **Database Setup**
   - Create MySQL database via hosting panel
   - Import `Admin/query.sql`
   - Update `config.php` with database credentials

3. **File Permissions**
   ```bash
   chmod 755 Admin/
   chmod 644 *.php
   chmod 666 uploads/ (if exists)
   ```

### Docker Deployment

1. **Create Dockerfile**
   ```dockerfile
   FROM php:8.0-apache
   RUN docker-php-ext-install mysqli
   COPY . /var/www/html/
   EXPOSE 80
   ```

2. **Build and Run**
   ```bash
   docker build -t portfolio .
   docker run -p 80:80 portfolio
   ```

## Post-Deployment Setup

### 1. Change Admin Credentials
- Login with default credentials (admin/admin123)
- Go to admin panel and change password immediately

### 2. Test Functionality
- [ ] Homepage loads correctly
- [ ] Admin login works
- [ ] Content management works
- [ ] File uploads work
- [ ] Contact form works
- [ ] All responsive breakpoints work

### 3. SEO Optimization
- Update meta descriptions
- Add Google Analytics (optional)
- Submit sitemap to search engines
- Optimize images for web

### 4. Security Checklist
- [ ] Changed default admin credentials
- [ ] HTTPS enabled
- [ ] Error reporting disabled in production
- [ ] File upload directory secured
- [ ] Database credentials secured

## Performance Optimization

### 1. Enable Gzip Compression
Add to `.htaccess`:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/x-javascript
</IfModule>
```

### 2. Browser Caching
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 month"
    ExpiresByType image/jpeg "access plus 1 month"
    ExpiresByType image/gif "access plus 1 month"
    ExpiresByType image/png "access plus 1 month"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/x-javascript "access plus 1 month"
    ExpiresByType application/x-shockwave-flash "access plus 1 month"
    ExpiresByType image/x-icon "access plus 1 year"
    ExpiresDefault "access plus 2 days"
</IfModule>
```

## Troubleshooting

### Database Connection Issues
1. Check database credentials in environment variables
2. Verify database server is accessible
3. Check if database exists and has correct permissions

### File Upload Issues
1. Check PHP upload limits:
   ```php
   upload_max_filesize = 10M
   post_max_size = 10M
   ```
2. Verify directory permissions
3. Check disk space

### Session Issues
1. Verify session directory is writable
2. Check session configuration in `session-handler.php`
3. Clear browser cookies and try again

### Performance Issues
1. Enable PHP OPcache
2. Optimize database queries
3. Compress images
4. Use CDN for static assets

## Maintenance

### Regular Tasks
- [ ] Backup database weekly
- [ ] Monitor error logs
- [ ] Update content regularly
- [ ] Check for security updates
- [ ] Monitor site performance

### Monthly Tasks
- [ ] Review admin access logs
- [ ] Update any outdated content
- [ ] Check for broken links
- [ ] Monitor site analytics

---

For support, contact: krupabhalsod@gmail.com
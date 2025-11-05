# Krupa Bhalsod Portfolio

A modern, responsive portfolio website built with PHP, showcasing projects, skills, and professional experience.

## Quick Setup for Local Development

### Prerequisites
- XAMPP or WAMP server
- Web browser
- Text editor

### Installation Steps

1. **Start XAMPP/WAMP**
   - Start Apache and MySQL services

2. **Setup Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database named `cv_db`
   - Import the SQL file: `Admin/query.sql`

3. **Setup Project**
   - Copy project folder to `htdocs` (XAMPP) or `www` (WAMP)
   - Ensure folder structure is: `htdocs/portfolio/`

4. **Access Application**
   - Portfolio: `http://localhost/portfolio/`
   - Admin Panel: `http://localhost/portfolio/Admin/`

### Default Admin Credentials
- **Username**: admin
- **Password**: admin123

### Database Configuration
The application is configured for standard phpMyAdmin setup:
- **Host**: localhost
- **Username**: root
- **Password**: (empty)
- **Database**: cv_db

## Features

### Frontend
- **Responsive Design**: Mobile-first approach
- **Interactive Elements**: Animated skill progress rings
- **Modern UI**: Clean, professional design
- **Smooth Navigation**: Scroll-to-section functionality

### Admin Panel
- **Homepage Management**: Update profile image, title, and introduction
- **Content Management**: Manage all portfolio sections
- **File Upload**: Safe image upload with validation
- **User-Friendly Interface**: Modern Bootstrap-based design

## Project Structure

```
portfolio/
├── index.php              # Main portfolio page
├── style.css              # Main stylesheet
├── script.js              # JavaScript functionality
├── me.jpeg                # Default profile image
├── about.png              # About section image
├── README.md              # This file
└── Admin/                 # Admin panel
    ├── login.php          # Admin login
    ├── index.php          # Homepage management
    ├── header.php         # Admin header
    ├── footer.php         # Admin footer
    ├── db-connect.php     # Database connection
    ├── session-handler.php # Session management
    ├── logout.php         # Logout functionality
    └── query.sql          # Database schema
```

## Database Tables

- **homepage**: Main page content
- **about**: About section content  
- **skills**: Skills with percentages
- **projects**: Project portfolio
- **internships**: Work experience
- **qualifications**: Educational background
- **contact**: Contact form submissions
- **users**: Admin authentication

## Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Styling**: CSS Grid, Flexbox, Bootstrap (Admin)
- **Icons**: Font Awesome, Boxicons

## Admin Panel Usage

### Managing Content

1. **Homepage**
   - Upload profile image (JPG, PNG, GIF up to 5MB)
   - Update main title and introduction text

2. **About Section**
   - Update about image and description

3. **Skills**
   - Add new skills with percentage proficiency
   - Automatic circular progress indicators

4. **Projects**
   - Add project title, GitHub link, and description

5. **Internships**
   - Track work experience with role, duration, and details

6. **Contact Messages**
   - View messages submitted through contact form

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Ensure XAMPP/WAMP is running
   - Check if MySQL service is started
   - Verify database 'cv_db' exists in phpMyAdmin

2. **Admin Panel Not Loading**
   - Check if all Admin/*.php files are present
   - Verify database connection

3. **Images Not Uploading**
   - Check folder permissions
   - Ensure upload directory is writable

### File Permissions
```bash
chmod 755 Admin/
chmod 644 *.php
chmod 666 uploads/ (if exists)
```

## Customization

### Color Scheme
Update CSS variables in `style.css`:
```css
:root {
    --primary-color: #eeeeee;
    --secondary-color: #522258;
    --title-color: #373a40;
    --button-color: #dc5f00;
    --background-color: #c3b1e1;
}
```

## Security Features

- SQL injection protection with prepared statements
- Input validation and sanitization
- Session management for admin access
- File upload validation
- Error logging

## Browser Support

- Chrome 70+
- Firefox 65+
- Safari 12+
- Edge 79+
- Mobile browsers

## Support

For support or questions:
- Email: krupabhalsod@gmail.com
- Check phpMyAdmin at: `http://localhost/phpmyadmin`

---

**Built with ❤️ by Krupa Bhalsod**# PHP-Portfolio

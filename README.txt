# Campus Lost & Found Portal

A full-featured PHP-based web application for managing lost and found items on campus.

## 🎯 Project Overview

This project demonstrates CRUD operations (Create, Read, Update, Delete) using PHP and MySQL. Students can post lost or found items, search through listings, and connect with each other to reunite lost belongings with their owners.

## 👥 Group Members

- **Member 1** - ID: 001
- **Member 2** - ID: 002
- **Member 3** - ID: 003
- **Member 4** - ID: 004
- **Member 5** - ID: 005

*Update the footer.php file with actual names and IDs*

## ✨ Features

### CRUD Operations
- **CREATE**: Post new lost/found items, Register new users
- **READ**: View all items, Search and filter, View item details
- **UPDATE**: Edit item information, Mark items as returned, Update user profile
- **DELETE**: Remove item posts, Delete user accounts (admin)

### Additional Features
- User authentication (Login/Register)
- Image upload for items
- Search and filter functionality
- Category-based organization
- User dashboard
- Admin panel
- Responsive design
- Contact information protection

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache (XAMPP/WAMP recommended for local development)

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache Web Server
- Web browser (Chrome, Firefox, Safari, Edge)

## 🚀 Installation Instructions

### Local Setup (XAMPP/WAMP)

1. **Install XAMPP/WAMP**
   - Download from [https://www.apachefriends.org](https://www.apachefriends.org)
   - Install and start Apache and MySQL services

2. **Clone/Download the Project**
   ```bash
   cd C:\xampp\htdocs\
   git clone [your-repo-url] campus-lost-found
   # OR extract the zip file here
   ```

3. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin`
   - Create new database: `lost_and_found`
   - Import the SQL file: `database.sql`
   - Or run the SQL queries from the file manually

4. **Configure Database Connection**
   - Open `config.php`
   - Update these lines if needed:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'lost_and_found');
   ```

5. **Create Uploads Folder**
   ```bash
   mkdir uploads
   chmod 777 uploads  # On Linux/Mac
   ```
   - Add a default image: `uploads/default.jpg`

6. **Update Base URL**
   - Open `config.php`
   - Update the BASE_URL:
   ```php
   define('BASE_URL', 'http://localhost/campus-lost-found/');
   ```

7. **Access the Website**
   - Open browser: `http://localhost/campus-lost-found/`

## 🔐 Demo Credentials

### Admin Account
- **Email**: admin@campus.edu
- **Password**: admin123

### Regular User
- **Email**: john@campus.edu
- **Password**: user123

## 📁 Project Structure

```
campus-lost-found/
├── index.php              # Home page with all items
├── config.php            # Database configuration
├── login.php             # User login
├── register.php          # User registration
├── logout.php            # Logout handler
├── items/
│   ├── post_item.php     # Create new item
│   ├── view_item.php     # View item details
│   ├── edit_item.php     # Update item
│   ├── delete_item.php   # Delete item
│   └── mark_returned.php # Mark as returned
├── user/
│   └── dashboard.php     # User dashboard
├── admin/
│   └── dashboard.php     # Admin panel
├── includes/
│   ├── header.php        # Common header
│   └── footer.php        # Common footer
├── css/
│   └── style.css         # Styling
├── js/
│   └── script.js         # JavaScript
├── uploads/              # Uploaded images
├── database.sql          # Database schema
└── README.md            # This file
```

## 🌐 Deployment to Live Hosting

### Recommended Free Hosting Services
1. **InfinityFree** (infinityfree.net)
2. **000webhost** (000webhost.com)
3. **Awardspace** (awardspace.com)

### Deployment Steps

1. **Upload Files**
   - Use FTP client (FileZilla) or hosting file manager
   - Upload all files to `public_html` or `htdocs` folder

2. **Create Database**
   - Go to hosting control panel
   - Create MySQL database
   - Note down: database name, username, password, host

3. **Import Database**
   - Open phpMyAdmin from hosting control panel
   - Select your database
   - Import `database.sql` file

4. **Update Configuration**
   - Edit `config.php` with your hosting database details:
   ```php
   define('DB_HOST', 'your-host');        # Usually 'localhost' or provided by host
   define('DB_USER', 'your-db-username');
   define('DB_PASS', 'your-db-password');
   define('DB_NAME', 'your-db-name');
   define('BASE_URL', 'https://yourdomain.com/');
   ```

5. **Set Permissions**
   - Ensure `uploads` folder has write permissions (777 or 755)

6. **Test the Website**
   - Visit your domain
   - Test all features (register, login, post item, etc.)

## 📊 Database Schema

### Users Table
- user_id (Primary Key)
- full_name
- email (Unique)
- password (Hashed)
- phone
- student_id
- role (user/admin)
- created_at

### Items Table
- item_id (Primary Key)
- user_id (Foreign Key → users)
- title
- description
- category
- type (lost/found)
- status (active/claimed/returned)
- location
- date_lost_found
- image_path
- contact information
- timestamps

## 🎨 Features Breakdown

### For Users
- Register and create account
- Login to personal dashboard
- Post lost items with details and images
- Post found items to help others
- Search and filter items by category, type, date
- View contact information for items
- Edit their own posts
- Mark items as returned when resolved
- Delete their own posts

### For Admins
- All user features
- View admin dashboard with statistics
- Manage all items (view, delete)
- Manage all users
- View system analytics

## 🐛 Troubleshooting

### Common Issues

**"Connection failed" error**
- Check if MySQL is running
- Verify database credentials in config.php
- Ensure database is created and imported

**Images not uploading**
- Check if `uploads` folder exists
- Verify folder permissions (777 on Linux)
- Check file size (max 5MB)
- Ensure supported format (JPG, PNG, GIF)

**Page not found errors**
- Verify BASE_URL in config.php
- Check Apache mod_rewrite is enabled
- Ensure all files are in correct directory

**Login not working**
- Clear browser cache and cookies
- Verify database has user records
- Check password hashing is working

## 📱 Browser Compatibility

- Google Chrome (Recommended)
- Mozilla Firefox
- Safari
- Microsoft Edge
- Opera

## 🔒 Security Features

- Password hashing using PHP password_hash()
- SQL injection prevention with mysqli_real_escape_string()
- XSS protection with htmlspecialchars()
- Session-based authentication
- File upload validation
- Role-based access control

## 📝 Future Enhancements

- Email notifications
- SMS alerts
- QR code generation for items
- Mobile app version
- Advanced matching algorithm
- Multi-language support
- Social media integration

## 📞 Support & Contact

For any questions or issues, contact:
- Email: support@campus.edu
- Phone: +92-300-1234567

## 📄 License

This project is created for educational purposes as part of CSC 337 - Web Programming course.

## 🙏 Acknowledgments

- Course Instructor: [Instructor Name]
- Course: CSC 337 - Web Programming Languages
- Institution: [Your University Name]
- Semester: Spring 2026

---

**Note**: Remember to update the footer.php file with your actual group member names and IDs before submission!

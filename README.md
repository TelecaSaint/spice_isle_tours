Spice Isle Tours

Project Overview
Spice Isle Tours is a dynamic, responsive web platform designed to showcase and facilitate booking of guided tours in Grenada. The website allows users to browse tours, view detailed tour information, and make online bookings seamlessly.

Features

Dynamic tour listings with images, descriptions, and pricing.

User registration and login system for clients and admins.

Tour booking system linked to MySQL database.

Interactive features: hero section fade-in, card hover effects, scroll-to-top button.

Contact form with messages stored in the database.

Responsive design using Bootstrap, CSS Media Queries, Flexbox/Grid.

Admin dashboard for managing tours, blogs, and user messages.

Security measures including password hashing and input sanitization.

Technology Stack

Front-End: HTML5, CSS3, JavaScript, Bootstrap

Back-End: PHP

Database: MySQL (via XAMPP)

Development & Testing: XAMPP local server

Optional Hosting: InfinityFree or similar free hosting

File Structure

/css       → Stylesheets (styles.css, admin.css)  
/js        → JavaScript files (script.js)  
/images    → Images for tours, blog posts, UI  
/includes  → Reusable PHP files (header.php, footer.php, db_connect.php, functions.php)  
index.php  → Homepage  
tours.php  → Tour listings page  
tour_details.php → Individual tour detail page  
contact.php → Contact form page  
booking.php → Tour booking system page  
/admin     → Admin pages for managing tours, blog posts, messages  


Setup & Installation

Clone the repository:

git clone https://github.com/TelecaSaint/spice_isle_tours.git


Install XAMPP and start Apache & MySQL.

Import spice_isle_tours.sql database into phpMyAdmin.

Update database connection in includes/db_connect.php if needed.

Open index.php in your browser via http://localhost/spice_isle_tours/.

Testing

Links, buttons, and menus were verified to ensure proper navigation.

Forms were tested for input validation, error handling, and correct database insertion.

Dynamic features (animations, hover effects, scroll-to-top) were confirmed functional.

Responsiveness was tested on desktop, tablet, and mobile devices.

Deployment

Tested locally on XAMPP.

Attempted hosting on InfinityFree and Render, currently live via: https://spiceisletours.infinityfreeapp.com (Coming Soon placeholder).

License
This project is for educational purposes (T.A. Marryshow Community College).

Author
Teleca St. Louis
GitHub: TelecaSaint

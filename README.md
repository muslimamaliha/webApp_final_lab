# ScholarHub 

ScholarHub is a dynamic study-abroad and scholarship discovery web application developed using **PHP, MySQL, HTML, CSS, Bootstrap 5 and JavaScript**.

The system helps students discover scholarships, universities and study-abroad preparation resources in one place. It also provides authentication and an admin panel for managing website content dynamically.

---

## Project Objectives

The main objectives of ScholarHub are:

- Help students discover scholarship opportunities.
- Provide university information by country.
- Provide study-abroad preparation resources.
- Allow students to create accounts and manage their profiles.
- Provide an admin panel for managing scholarships, universities and fields.
- Store public content dynamically in a MySQL database.
- Provide search and filtering functionality.
- Provide official-source links for scholarship and university information.
- Demonstrate PHP, MySQL, JavaScript, Bootstrap and database concepts learned in the course.

---

## Main Features

### Student/User Features

- Student registration
- Student login/logout
- Student profile
- Scholarship search
- Scholarship filtering by country and study level
- University search and filtering
- Fields of study
- Study-abroad preparation guide
- Visa guide
- Test preparation resources
- Official links for scholarships and universities
- Responsive Bootstrap 5 interface

### Admin Features

- Admin login
- Admin dashboard
- Scholarship management
  - Add scholarship
  - Edit scholarship
  - Delete scholarship
- University management
  - Add university
  - Edit university
  - Delete university
- Field management
  - Add field
  - Edit field
  - Delete field
- Database-driven content management

---

## Technologies Used

| Technology | Purpose |
|---|---|
| HTML5 | Page structure |
| CSS3 | Custom styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Client-side interaction |
| PHP | Backend/server-side programming |
| MySQL/MariaDB | Database |
| PDO | Database connection and prepared statements |
| Git | Version control |
| GitHub | Source code hosting |
| XAMPP | Local development environment |

---
##

## Project Structure

```text
ScholarHub_Dynamic/
│
├── index.php
├── scholarships.php
├── universities.php
├── fields.php
├── prepare.php
├── tests.php
├── visa-guide.php
├── about.php
├── login.php
├── register.php
├── logout.php
├── profile.php
│
├── admin/
│   ├── index.php
│   ├── scholarships.php
│   ├── universities.php
│   ├── fields.php
│   ├── countries.php
│   ├── _header.php
│   └── _footer.php
│
├── config/
│   ├── config.php
│   ├── db.php
│   └── .htaccess
│
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── functions.php
│   └── .htaccess
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── app.js
│   └── images/
│       └── home.jpeg
│
├── database/
│   ├── schema.sql
│   ├── migration_fix.sql
│   ├── README_SEED.txt
│   └── scholarhub_universities_batch1.sql
│
├── .gitignore
└── README.md

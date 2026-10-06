# ScholarHub — Dynamic PHP + MySQL Project

A beginner-friendly study-abroad and scholarship discovery web app.

## Main features
- Home, Scholarships, Universities, Fields, Preparation Guide and About pages
- Automatic active navbar item: the current page becomes darker
- MySQL database instead of hard-coded public content
- Student registration/login/profile
- Admin login and dashboard
- Admin CRUD: add/edit/delete Scholarships, Universities and Fields
- Search and filters for scholarships and universities
- Official-source buttons for scholarship/university records
- Bootstrap 5 responsive UI
- PHP PDO prepared statements
- No Composer, Node.js or framework required
- Designed for PHP + MySQL/MariaDB shared hosting

## Local XAMPP setup
1. Copy the `ScholarHub_Dynamic` folder into `C:\xampp\htdocs\` and rename it to `scholarhub` if you want.
2. Start Apache and MySQL from XAMPP.
3. Open phpMyAdmin: `http://localhost/phpmyadmin/`
4. Import `database/schema.sql`.
5. If your local MySQL password is not empty, edit `config/config.php`.
6. Open `http://localhost/scholarhub/`.

## Admin login
Email: `admin@scholarhub.local`
Password: `..............`
For security, the admin password is provided separately to the course instructor.

### Admin Access

The project includes role-based admin access.
For security, admin credentials are not included in this public repository.

**Change the default admin password before putting the site on the public internet.**

## Deploy to PHP/MySQL shared hosting
This project intentionally avoids Node.js, Composer, Laravel and URL-rewrite dependencies so it can be uploaded to ordinary PHP/MySQL hosting.

1. Create a MySQL/MariaDB database from your hosting control panel.
2. Open phpMyAdmin on the host and import `database/schema.sql`.
3. Upload the project files into the host's public web directory (often `public_html`).
4. Edit `config/config.php` with the host-provided database host, database name, username and password.
5. Visit your domain. Login with the admin account and change its password.
6. Use the Admin panel to add/edit/delete content. Database changes appear on the public site immediately.

## Adding new content after the site is live
You do **not** need to edit PHP code for normal content changes.

Admin → Scholarships → Add Scholarship
Admin → Universities → Add University
Admin → Fields → Add Field

The records are stored in MySQL, so they remain after deployment and are visible to all visitors.

## Important note about scholarship information
Scholarship deadlines, eligibility and benefits can change. The database includes official/provider links, but current details should always be checked on the linked official source.

## GitHub
Upload the project files to a GitHub repository. Do not commit real production database passwords. Keep `config/config.php` with placeholder/local credentials or use hosting-specific configuration.


### If you already have an older `scholarships` table
If the Scholarships page shows `Undefined array key` warnings for `study_level`, `fields`, or `funding_type`, your existing database was created with an older table structure. Import/run `database/migration_fix.sql` in phpMyAdmin, then refresh the page. The public page also safely handles blank values, so these warnings will not appear.

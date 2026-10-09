# Ideal Muscat Ranches — PHP/MySQL website

## What is included
The Monoline styles/assets, company homepage and About page, published service/project/news detail pages, team and FAQ pages, database-backed contact enquiries, admin login, company settings, content create/edit/delete/publish, and enquiry deletion. Images are managed through local asset paths; there is no browser image uploader. No fabricated projects, reviews, team members, email addresses or phone numbers are included. Service categories from the supplied translation are drafts.

## 1. Install alongside your original template
Keep your original monoline-v1.0.0 folder as a backup. Extract this ZIP so you have:
/Applications/XAMPP/xamppfiles/htdocs/ideal-muscat/index.php
Do not put this inside the original template folder. Start Apache and MySQL in XAMPP.

## 2. Import the database
Open http://localhost/phpmyadmin → Import → choose database.sql → Go.
The SQL creates ideal_muscat and its tables. Import once into a fresh database; it deliberately does not delete an existing database. If your host does not permit CREATE DATABASE, create a database in its control panel and remove the first CREATE DATABASE and USE lines before importing.

## 3. Configure the connection
Edit config/database.php. The included values match common local XAMPP settings (127.0.0.1, port 3306, root, blank password). Adjust for your installation. Hosting must use a dedicated database account and a strong password.

## 4. Create your admin account
Open macOS Terminal and run:

```bash
cd /Applications/XAMPP/xamppfiles/htdocs/ideal-muscat
/Applications/XAMPP/xamppfiles/bin/php tools/create-admin.php you@example.com
```

Replace you@example.com with your own email. Enter a password of at least 12 characters when prompted. The prompt displays characters; do this privately. Passwords are hashed in the database. There is no default admin password or public web installer.

## 5. Open the website
Website: http://localhost/ideal-muscat/index.php
Admin: http://localhost/ideal-muscat/admin/login.php
Login → Company settings → add phone/email and edit homepage/About content.
Content → edit a service draft → describe your actual offering → tick Published → Save.
Use Add content for projects, news, team members and FAQs. Drafts never appear publicly.

## 6. Add images
Copy your own image into assets/img/ (e.g. company-farm.jpg). In the relevant content record enter assets/img/company-farm.jpg. Supported file types: jpg, jpeg, png, webp, gif. These images appear on listing/detail pages. Company branding in includes/header.php is text; replace it with your logo if desired.

## 7. Understand the code
config/database.php: connection details.
includes/app.php: database, sessions, HTML escaping, CSRF tokens and authentication.
includes/header.php/footer.php: shared navigation and footer.
index.php/about.php: company content loaded from settings.
includes/list.php/detail.php: published database records.
contact.php: validates and stores enquiries (does not send email).
admin/: editing and login pages.
assets/css/company.css: company-specific layout layered over Monoline CSS.
assets/js/company.js: responsive menu and delete confirmations.
database.sql: schema and seed drafts.

HTML builds the page structure. CSS controls its appearance. JavaScript handles menu interaction. PHP runs on Apache, reads MySQL and renders HTML. Editing a published database record changes the website without editing its HTML.

## 8. Check in XAMPP
Run PHP syntax checks:

```bash
find . -name '*.php' -exec /Applications/XAMPP/xamppfiles/bin/php -l {} \;
```

Open every navigation page on desktop and phone width. Create a draft service and confirm it is absent publicly. Publish it and open its detail page. Edit/delete it. Submit a valid enquiry and check Admin → Enquiries. Invalid email/short messages should be rejected; repeat submissions within a minute should be blocked. Open admin pages while logged out and confirm they redirect to login. Invalid or draft detail IDs should return 404. Log out and confirm access is denied. Check that database.sql, config/database.php and tools/create-admin.php cannot be downloaded/executed over HTTP.

## Verification limits
This build environment had no PHP executable or MySQL server. The archive structure, local references and generated source were checked, but PHP syntax and database/browser behavior MUST be verified in XAMPP using the checks above before publication.

## Before hosting
Use HTTPS, set hosting database credentials, confirm active services and public contacts, back up the database, and provide an appropriate privacy notice and enquiry retention policy. The contact form stores personal data. Its session cooldown/honeypot are basic spam controls, not a substitute for server-side rate limiting or CAPTCHA on a heavily targeted public site. Admin login locks a known account after repeated failed attempts; a password reset interface is not included. Keep the original template credit. No external deployment is included.

## Troubleshooting
Database unavailable: check MySQL is running, the import succeeded, and config matches your port/password.
404: ensure extraction has not created an extra nested ideal-muscat directory.
403: check Apache permissions/configuration rather than applying broad world-writable permissions.
Blank PHP page: inspect XAMPP Apache/PHP error logs.
CSS missing: confirm assets/ is alongside index.php.

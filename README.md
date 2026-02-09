# Instant Landing Page Generator

This platform allows users to instantly create high-converting landing pages after a one-time payment.

## Setup Instructions

1.  **Database Setup:**
    *   Create a MySQL database named `landing_page_db`.
    *   Import the SQL schema from `sql/schema.sql`.
    *   Update `db.php` with your database credentials.

2.  **Configuration:**
    *   Open `config.php`.
    *   Update the database credentials.
    *   Sign up for a Paystack account at [https://paystack.com](https://paystack.com) and get your **Secret Key**. Update `PAYSTACK_SECRET_KEY` in `config.php`.
    *   Configure your SMTP/Email settings in `config.php` for automated email delivery.

3.  **File Permissions:**
    *   Ensure the `uploads/` directory is writable by the web server.

4.  **Hosting:**
    *   Upload all files to your PHP-enabled hosting (Shared hosting or VPS).
    *   Ensure `mod_rewrite` is enabled on your server for clean URLs (handled by `.htaccess`).

5.  **Usage:**
    *   Navigate to the homepage (`index.php`) to create a new landing page.
    *   Fill out the form and proceed to payment.
    *   Once payment is successful, you will be redirected to your new landing page link.

## File Structure

*   `index.php`: The landing page creation form.
*   `create.php`: Handles form submission, image upload, and payment initialization.
*   `verify.php`: Verifies Paystack payment and activates the landing page.
*   `view.php`: The dynamic template for rendering landing pages.
*   `config.php`: Central configuration for DB, Paystack, and Email.
*   `db.php`: Database connection setup.
*   `assets/css/style.css`: Basic styling.
*   `uploads/`: Directory where product images are stored.
*   `sql/schema.sql`: Database schema.
*   `.htaccess`: URL rewriting for clean landing page links.

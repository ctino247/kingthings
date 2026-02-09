CREATE TABLE IF NOT EXISTS landing_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_path VARCHAR(255),
    contact_link VARCHAR(255) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    payment_status ENUM('pending', 'paid') DEFAULT 'pending',
    reference VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

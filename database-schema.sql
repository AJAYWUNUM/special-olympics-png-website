CREATE TABLE IF NOT EXISTS website_enquiries (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(180) NOT NULL,
    phone VARCHAR(60) NULL,
    organisation VARCHAR(180) NULL,
    topic VARCHAR(180) NOT NULL,
    interest VARCHAR(180) NULL,
    source_page VARCHAR(120) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_enquiries_created_at (created_at),
    INDEX idx_enquiries_email (email)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    status ENUM('subscribed', 'unsubscribed') NOT NULL DEFAULT 'subscribed',
    consent_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    unsubscribe_token CHAR(64) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_newsletter_status (status)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


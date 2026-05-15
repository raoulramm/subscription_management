CREATE DATABASE IF NOT EXISTS subscription_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE subscription_manager;

CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS payment_cards (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE,
  last_four VARCHAR(10) NULL
);

CREATE TABLE IF NOT EXISTS subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  service_name VARCHAR(150) NOT NULL,
  category_id INT NULL,
  start_date DATE NULL,
  billing_cycle ENUM('Monthly','Yearly') NOT NULL DEFAULT 'Monthly',
  next_billing_date DATE NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  payment_card_id INT NULL,
  status ENUM('Active','Paused','Cancelled') NOT NULL DEFAULT 'Active',
  reminder_days INT NOT NULL DEFAULT 7,
  notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
  FOREIGN KEY (payment_card_id) REFERENCES payment_cards(id) ON DELETE SET NULL
);

INSERT IGNORE INTO categories (name) VALUES
('Entertainment'),('Music'),('Software'),('Hosting / Domain'),('Business Tools'),('Marketing'),('Fitness'),('Education'),('Other');

INSERT IGNORE INTO payment_cards (name,last_four) VALUES
('MyMonty',NULL),('Raoul wish',NULL),('Visa','9999'),('Cash',NULL),('PayPal',NULL),('Other',NULL);

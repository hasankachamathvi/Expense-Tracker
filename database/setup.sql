-- Create Database
CREATE DATABASE IF NOT EXISTS expense_tracker;

USE expense_tracker;

-- Create Expenses Table
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create Index for better query performance
CREATE INDEX idx_date ON expenses(date);
CREATE INDEX idx_category ON expenses(category);

-- Sample Data (Optional)
INSERT INTO expenses (amount, category, description, date) VALUES
(250.00, 'Food', 'Grocery shopping', '2026-01-05'),
(50.00, 'Transport', 'Taxi fare', '2026-01-06'),
(1200.00, 'Bills', 'Electricity bill', '2026-01-07'),
(300.00, 'Entertainment', 'Movie tickets', '2026-01-08'),
(150.00, 'Food', 'Restaurant dinner', '2026-01-09');

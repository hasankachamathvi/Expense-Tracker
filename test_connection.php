<?php
// Test Database Connection
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Testing Database Connection</h2>";

// Database configuration
$host = 'localhost';
$user = 'userh';
$pass = '1234';
$dbname = 'expense_tracker';

echo "<h3>Step 1: Testing MySQL Connection</h3>";

// Test connection without database
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    echo "❌ Connection Failed: " . $conn->connect_error . "<br>";
    echo "<strong>Solution:</strong> Make sure MySQL is running in XAMPP/WAMP<br>";
    die();
} else {
    echo "✅ MySQL connection successful!<br>";
}

echo "<h3>Step 2: Checking if Database Exists</h3>";

$result = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($result->num_rows == 0) {
    echo "❌ Database '$dbname' does not exist!<br>";
    echo "<strong>Solution:</strong> Run the following SQL in phpMyAdmin:<br>";
    echo "<pre>CREATE DATABASE expense_tracker;</pre>";
    echo "Or click here to create it automatically: ";
    
    if ($conn->query("CREATE DATABASE $dbname")) {
        echo "✅ Database created successfully!<br>";
    } else {
        echo "❌ Error creating database: " . $conn->error . "<br>";
    }
} else {
    echo "✅ Database '$dbname' exists!<br>";
}

$conn->close();

echo "<h3>Step 3: Testing Connection to Database</h3>";

// Test connection with database
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo "❌ Connection to database failed: " . $conn->connect_error . "<br>";
    die();
} else {
    echo "✅ Connected to database '$dbname' successfully!<br>";
}

echo "<h3>Step 4: Checking Tables</h3>";

$result = $conn->query("SHOW TABLES LIKE 'expenses'");
if ($result->num_rows == 0) {
    echo "❌ Table 'expenses' does not exist!<br>";
    echo "<strong>Solution:</strong> Creating table now...<br>";
    
    $sql = "CREATE TABLE expenses (
        id INT AUTO_INCREMENT PRIMARY KEY,
        amount DECIMAL(10, 2) NOT NULL,
        category VARCHAR(50) NOT NULL,
        description VARCHAR(255) NOT NULL,
        date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($sql)) {
        echo "✅ Table 'expenses' created successfully!<br>";
        
        // Add indexes
        $conn->query("CREATE INDEX idx_date ON expenses(date)");
        $conn->query("CREATE INDEX idx_category ON expenses(category)");
        echo "✅ Indexes created successfully!<br>";
        
        // Insert sample data
        $conn->query("INSERT INTO expenses (amount, category, description, date) VALUES
            (250.00, 'Food', 'Grocery shopping', '2026-01-05'),
            (50.00, 'Transport', 'Taxi fare', '2026-01-06'),
            (1200.00, 'Bills', 'Electricity bill', '2026-01-07'),
            (300.00, 'Entertainment', 'Movie tickets', '2026-01-08'),
            (150.00, 'Food', 'Restaurant dinner', '2026-01-09')");
        echo "✅ Sample data inserted!<br>";
    } else {
        echo "❌ Error creating table: " . $conn->error . "<br>";
    }
} else {
    echo "✅ Table 'expenses' exists!<br>";
    
    // Count records
    $result = $conn->query("SELECT COUNT(*) as count FROM expenses");
    $row = $result->fetch_assoc();
    echo "📊 Total expenses in database: " . $row['count'] . "<br>";
}

echo "<h3>Step 5: Testing PHP API Files</h3>";

$apiFiles = ['add_expense.php', 'get_expenses.php', 'delete_expense.php', 'get_summary.php'];
foreach ($apiFiles as $file) {
    $path = "php/$file";
    if (file_exists($path)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file is missing!<br>";
    }
}

echo "<h3>Summary</h3>";
echo "✅ All checks completed! If all items show ✅, your application should work.<br>";
echo "<br><strong>Next Steps:</strong><br>";
echo "1. Go back to <a href='index.html'>index.html</a> and test the application<br>";
echo "2. Open browser console (F12) to check for JavaScript errors<br>";
echo "3. If still not working, check that you're accessing via localhost (e.g., http://localhost/Expense Tracker/)<br>";

$conn->close();
?>

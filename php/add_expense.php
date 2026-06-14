<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST')
     {
    $amount = $_POST['amount'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $date = $_POST['date'] ?? '';
    
    // Validate inputs
    if (empty($amount) || empty($category) || empty($description) || empty($date)) 
    {
        echo json_encode([
            'success' => false,
            'message' => 'All fields are required'
        ]);
        exit;
    }
    
    // Validate amount
    if (!is_numeric($amount) || $amount <= 0) 
        {
        echo json_encode
        ([
            'success' => false,
            'message' => 'Invalid amount'
        ]);
        exit;
    }
    
    $conn = getConnection();
    
    $stmt = $conn->prepare("INSERT INTO expenses (amount, category, description, date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("dsss", $amount, $category, $description, $date);
    
    if ($stmt->execute()) 
        {
        echo json_encode([
            'success' => true,
            'message' => 'Expense added successfully',
            'id' => $conn->insert_id
        ]);
    } 
    else 
        {
        echo json_encode([
            'success' => false,
            'message' => 'Error adding expense: ' . $stmt->error
        ]);
    }
    
    $stmt->close();
    $conn->close();
} 
else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?>

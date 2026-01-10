<?php
require_once 'config.php';

$conn = getConnection();

if (isset($_GET['date'])) {
    // Filter by specific date
    $date = $_GET['date'];
    $stmt = $conn->prepare("SELECT * FROM expenses WHERE date = ? ORDER BY date DESC, id DESC");
    $stmt->bind_param("s", $date);
} else {
    // Get all expenses (last 30 days)
    $stmt = $conn->prepare("SELECT * FROM expenses ORDER BY date DESC, id DESC LIMIT 100");
}

$stmt->execute();
$result = $stmt->get_result();

$expenses = [];
while ($row = $result->fetch_assoc()) {
    $expenses[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => $expenses
]);

$stmt->close();
$conn->close();
?>

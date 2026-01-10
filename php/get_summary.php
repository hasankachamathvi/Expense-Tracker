<?php
require_once 'config.php';

$month = $_GET['month'] ?? '';

if (empty($month)) {
    echo json_encode([
        'success' => false,
        'message' => 'Month is required'
    ]);
    exit;
}

// Parse month (format: YYYY-MM)
$year = substr($month, 0, 4);
$monthNum = substr($month, 5, 2);

$conn = getConnection();

// Get total expenses for the month
$stmt = $conn->prepare("SELECT SUM(amount) as total FROM expenses WHERE YEAR(date) = ? AND MONTH(date) = ?");
$stmt->bind_param("ss", $year, $monthNum);
$stmt->execute();
$result = $stmt->get_result();
$totalRow = $result->fetch_assoc();
$total = $totalRow['total'] ?? 0;

// Get category-wise breakdown
$stmt = $conn->prepare("SELECT category, SUM(amount) as total FROM expenses WHERE YEAR(date) = ? AND MONTH(date) = ? GROUP BY category ORDER BY total DESC");
$stmt->bind_param("ss", $year, $monthNum);
$stmt->execute();
$result = $stmt->get_result();

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

echo json_encode([
    'success' => true,
    'data' => [
        'total' => $total,
        'categories' => $categories
    ]
]);

$stmt->close();
$conn->close();
?>

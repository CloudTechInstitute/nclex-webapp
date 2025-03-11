<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query to fetch all products along with their subscription counts
    $query = "
    SELECT 
        p.name AS product_name, 
        p.duration, 
        COUNT(s.product) AS subscription_count 
    FROM products p
    LEFT JOIN subscriptions s ON p.name = s.product
    GROUP BY p.name, p.duration
    ORDER BY subscription_count DESC
";


    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $products]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No products found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
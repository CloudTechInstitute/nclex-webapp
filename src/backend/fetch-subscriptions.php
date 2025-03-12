<?php
include 'connection.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow cross-origin requests
header('Access-Control-Allow-Methods: GET');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$conn) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
        exit;
    }

    // Default values for pagination
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 9; // Default 9 items per page
    $offset = ($page - 1) * $limit;

    // Ensure offset is never negative
    if ($offset < 0) {
        $offset = 0;
    }

    // Get total count of products
    $countQuery = "SELECT COUNT(DISTINCT p.name) as total FROM products p LEFT JOIN subscriptions s ON p.name = s.product";
    $countResult = $conn->query($countQuery);
    $totalRows = ($countResult && $countResult->num_rows > 0) ? $countResult->fetch_assoc()['total'] : 0;
    $totalPages = ($limit > 0) ? ceil($totalRows / $limit) : 1;

    // Query to fetch paginated products along with their subscription counts
    $query = "
    SELECT 
        p.name AS product_name, 
        p.duration, 
        COUNT(s.product) AS subscription_count 
    FROM products p
    LEFT JOIN subscriptions s ON p.name = s.product
    GROUP BY p.name, p.duration
    ORDER BY subscription_count DESC
    LIMIT $limit OFFSET $offset
    ";

    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
            echo json_encode([
                'status' => 'success',
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_products' => $totalRows,
                'data' => $products
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No products found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query failed']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
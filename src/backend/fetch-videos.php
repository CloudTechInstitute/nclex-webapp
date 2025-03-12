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
    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10; // Default 10 items per page
    $offset = ($page - 1) * $limit;

    // Get total count of videos
    $countQuery = "SELECT COUNT(*) as total FROM videos";
    $countResult = $conn->query($countQuery);
    $totalRows = ($countResult && $countResult->num_rows > 0) ? $countResult->fetch_assoc()['total'] : 0;
    $totalPages = ceil($totalRows / $limit);

    // Fetch paginated data
    $query = "SELECT * FROM videos ORDER BY ID DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            $videos = [];
            while ($row = $result->fetch_assoc()) {
                // Convert date format from Y-m-d to d-m-Y if applicable
                if (!empty($row['date'])) {
                    $row['date'] = date("d-m-Y", strtotime($row['date']));
                }
                $videos[] = $row;
            }
            echo json_encode([
                'status' => 'success',
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_videos' => $totalRows,
                'data' => $videos
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No videos found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Query failed']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
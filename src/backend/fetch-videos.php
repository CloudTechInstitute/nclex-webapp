<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM videos ORDER BY ID DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $videos = [];
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $videos]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No videos found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
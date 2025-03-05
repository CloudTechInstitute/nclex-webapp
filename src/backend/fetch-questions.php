<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM questions ORDER BY ID DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $questions]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No questions found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
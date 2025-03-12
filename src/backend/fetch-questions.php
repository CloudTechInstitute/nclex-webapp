<?php
include 'connection.php';
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ensure valid pagination values
    $page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
    $limit = isset($_GET['limit']) && (int) $_GET['limit'] > 0 ? (int) $_GET['limit'] : 10;
    $offset = max(0, ($page - 1) * $limit); // Prevent negative offsets

    // Get total count of questions
    $countQuery = "SELECT COUNT(*) as total FROM questions";
    $countResult = $conn->query($countQuery);
    $totalRows = ($countResult && $countResult->num_rows > 0) ? $countResult->fetch_assoc()['total'] : 0;
    $totalPages = ceil($totalRows / $limit);

    // Fetch paginated data
    $query = "SELECT * FROM questions ORDER BY ID DESC LIMIT $limit OFFSET $offset";

    // Debug query
    error_log("Generated Query: $query");

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $questions = [];
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        echo json_encode([
            'status' => 'success',
            'current_page' => $page,
            'total_pages' => $totalPages,
            'total_questions' => $totalRows,
            'data' => $questions
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No questions found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
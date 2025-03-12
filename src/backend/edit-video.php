<?php
header("Content-Type: application/json");
include "connection.php"; // Ensure database connection

// Ensure request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Validate required fields
$requiredFields = [
    'videoId',
    'videoName',
    'videoCategory',

];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(["status" => "error", "message" => "Missing field: $field"]);
        exit;
    }
}

// Sanitize input data
$id = intval($_POST['videoId']);
$videoName = trim($_POST['videoName']);
$videoCategory = trim($_POST['videoCategory']);

// Prepare SQL update query
$query = "UPDATE videos SET name=?, category=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $videoName, $videoCategory, $id);

// Execute query and return JSON response
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "video updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update video"]);
}

$stmt->close();
$conn->close();
?>
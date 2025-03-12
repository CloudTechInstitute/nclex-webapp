<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$questionId = $data['id'];
$query = "DELETE FROM questions WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $questionId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete question"]);
}

$stmt->close();
$conn->close();
?>
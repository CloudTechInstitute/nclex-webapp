<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$videoId = $data['id'];
$query = "DELETE FROM videos WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $videoId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "video deleted successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete video"]);
}

$stmt->close();
$conn->close();
?>
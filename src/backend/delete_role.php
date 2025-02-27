<?php
include 'connection.php';

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$roleId = $data['id'];
$query = "DELETE FROM roles WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $roleId);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to delete role"]);
}

$stmt->close();
$conn->close();
?>
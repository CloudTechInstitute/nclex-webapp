<?php
session_start();
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Ensure the user is logged in
if (!isset($_SESSION['LoggedUser'], $_SESSION['UserRole'], $_SESSION['UserID'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$userID = $_SESSION['UserID'];

// Ensure userID is numeric (extra security)
if (!is_numeric($userID)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
    exit;
}

// Retrieve input data safely
$subscriberEmail = trim($_POST['subscriberEmail'] ?? '');
$id = trim($_POST['subscriberID'] ?? '');

// Validate required fields
if (empty($subscriberEmail) || empty($id)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No field should be left empty']);
    exit;
}

// Validate email format
if (!filter_var($subscriberEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

// Fetch current status of the user
$stmt = $conn->prepare("SELECT status FROM students WHERE id = ? AND email = ?");
$stmt->bind_param("is", $id, $subscriberEmail);
$stmt->execute();
$stmt->bind_result($currentStatus);
$stmt->fetch();
$stmt->close();

// Check if user exists
if (empty($currentStatus)) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

// Ensure only suspended users are restored
if ($currentStatus !== "suspended") {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'User is not suspended']);
    exit;
}

// Update user status to "active"
$updateStmt = $conn->prepare("UPDATE students SET status = 'active' WHERE id = ?");
$updateStmt->bind_param("i", $id);

if ($updateStmt->execute() && $updateStmt->affected_rows > 0) {
    echo json_encode(['status' => 'success', 'message' => 'User restored successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to restore account']);
}

$updateStmt->close();
$conn->close();
?>
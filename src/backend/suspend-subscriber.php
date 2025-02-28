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

// Fetch current email & ID from the correct table (assuming it's 'students')
$stmt = $conn->prepare("SELECT email, id FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}
$stmt->close();

// Update user status to "suspended"
$updateStmt = $conn->prepare("UPDATE students SET status = 'suspended' WHERE id = ?");
$updateStmt->bind_param("i", $id);

if ($updateStmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'User suspended successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
}

$updateStmt->close();
$conn->close();
?>
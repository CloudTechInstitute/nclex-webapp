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
$fullname = trim($_POST['full_name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$idNumber = trim($_POST['idnumber'] ?? '');
$date = date('Y-m-d');

// Validate required fields
if (empty($fullname) || empty($email) || empty($phone) || empty($idNumber)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No field should be left empty']);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

// Validate phone (ensure only digits)
if (!ctype_digit($phone)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid phone number']);
    exit;
}

// Fetch current email & phone
$stmt = $conn->prepare("SELECT email, phone FROM employees WHERE id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

$stmt->bind_result($currentEmail, $currentPhone);
$stmt->fetch();
$stmt->close();

// Check if email or phone has changed
$emailChanged = ($email !== $currentEmail);
$phoneChanged = ($phone !== $currentPhone);

// Only check for duplicates if email or phone is changing
if ($emailChanged || $phoneChanged) {
    $checkStmt = $conn->prepare("SELECT id FROM employees WHERE (email = ? OR phone = ?) AND id != ?");
    $checkStmt->bind_param("ssi", $email, $phone, $userID);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Email or phone number already in use']);
        exit;
    }
    $checkStmt->close();
}

// Update user details only if something changed
$query = "UPDATE employees SET name = ?, IDnumber = ?, updatedOn = ?";
$types = "sss";
$params = [$fullname, $idNumber, $date];

if ($emailChanged) {
    $query .= ", email = ?";
    $types .= "s";
    $params[] = $email;
}

if ($phoneChanged) {
    $query .= ", phone = ?";
    $types .= "s";
    $params[] = $phone;
}

$query .= " WHERE id = ?";
$types .= "i";
$params[] = $userID;

// Prepare and execute update
$updateStmt = $conn->prepare($query);
$updateStmt->bind_param($types, ...$params);

if ($updateStmt->execute()) {
    // Update session if name changed
    if ($fullname !== $_SESSION['LoggedUser']) {
        $_SESSION['LoggedUser'] = $fullname;
    }
    echo json_encode(['status' => 'success', 'message' => 'Account updated successfully']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again', 'error' => $updateStmt->error]);
}

$updateStmt->close();
$conn->close();
?>
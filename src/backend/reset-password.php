<?php
session_start();
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['LoggedUser']) || !isset($_SESSION['UserRole'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
        exit;
    }

    $user = $_SESSION['LoggedUser']; // Logged-in user's name
    $role = $_SESSION['UserRole']; // Logged-in user's role
    $status = "active";
    $oldPassword = isset($_POST['old_password']) ? trim($_POST['old_password']) : '';
    $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Validate required fields
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match']);
        exit;
    }

    // Fetch the existing password from the database using name and role
    $stmt = $conn->prepare("SELECT password FROM employees WHERE name = ? AND role = ?");
    $stmt->bind_param("ss", $user, $role);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit;
    }

    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify old password (without hashing)
    if ($oldPassword !== $storedPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect old password']);
        exit;
    }

    // Update only the password in the database
    $updateStmt = $conn->prepare("UPDATE employees SET password = ?, status = ? WHERE name = ? AND role = ?");
    $updateStmt->bind_param("ssss", $newPassword, $status, $user, $role);

    if ($updateStmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not update password', 'error' => $updateStmt->error]);
    }

    $updateStmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
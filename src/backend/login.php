<?php

include 'connection.php'; // Include database connection

header("Content-Type: application/json");

$response = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and sanitize input
    $username = isset($_POST['username']) ? filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING) : '';
    $role = isset($_POST['role']) ? filter_var(trim($_POST['role']), FILTER_SANITIZE_STRING) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($username) || empty($role) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Fill in all required fields!!']);
        exit;
    }

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM employees WHERE name = ? AND role = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify hashed password
        if ($password === $user['password']) {
            session_start();
            $_SESSION['LoggedUser'] = $user['name']; // Store username in session
            $_SESSION['UserRole'] = $user['role']; // Store username in session
            $_SESSION['UserID'] = $user['id']; // Store user id in session
            $_SESSION['UserStatus'] = $user['status']; // Store user id in session
            $_SESSION['dp'] = $user['profileImage']; // Store user id in session
            unset($user['password']); // Remove password from response for security

            $response["status"] = "success";
            $response["message"] = "Login Successful";
            $response["user"] = $user; // Send user details
        } else {
            $response["status"] = "error";
            $response["message"] = "Invalid username or password. Please try again.";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "User not found. Please try again.";
    }

    $stmt->close();
} else {
    $response["status"] = "error";
    $response["message"] = "Request method not allowed.";
}

$conn->close();
echo json_encode($response);

?>
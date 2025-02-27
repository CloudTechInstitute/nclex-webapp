<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = isset($_POST['productName']) ? trim($_POST['productName']) : '';
    $topics = isset($_POST['topics']) ? trim($_POST['topics']) : ''; // Already a comma-separated string
    $productQuiz = isset($_POST['productQuiz']) ? trim($_POST['productQuiz']) : '';
    $productSpeedTest = isset($_POST['productSpeedTest']) ? trim($_POST['productSpeedTest']) : '';
    $productAssessments = isset($_POST['productAssessments']) ? trim($_POST['productAssessments']) : '';
    $productDuration = isset($_POST['productDuration']) ? trim($_POST['productDuration']) : '';
    $productCost = isset($_POST['productCost']) ? trim($_POST['productCost']) : '';
    $productStatus = isset($_POST['productStatus']) ? trim($_POST['productStatus']) : '';
    $date = date('Y-m-d');

    // Validate required fields
    if (empty($productName) || empty($topics) || empty($productQuiz) || empty($productSpeedTest) || empty($productAssessments) || empty($productDuration) || !isset($productCost) || empty($productStatus)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO products (`name`, `resources`, `quizzes`, `speedTest`, `assessment`, `duration`, `cost`, `status`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $productName, $topics, $productQuiz, $productSpeedTest, $productAssessments, $productDuration, $productCost, $productStatus, $date);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Product created successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not create Product, something went wrong', 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
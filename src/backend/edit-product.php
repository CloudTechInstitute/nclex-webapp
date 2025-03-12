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
    'productId',
    'productName',
    'productResources',
    'productQuiz',
    'productTest',
    'productAssessment',
    'productDuration',
    'productCost',
    'productStatus'
];

foreach ($requiredFields as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(["status" => "error", "message" => "Missing field: $field"]);
        exit;
    }
}

// Sanitize input data
$id = intval($_POST['productId']);
$productName = trim($_POST['productName']);
$productResources = trim($_POST['productResources']);
$productQuiz = intval($_POST['productQuiz']);
$productTest = intval($_POST['productTest']);
$productAssessment = intval($_POST['productAssessment']);
$productDuration = trim($_POST['productDuration']);
$productCost = floatval($_POST['productCost']);
$productStatus = trim($_POST['productStatus']);

// Prepare SQL update query
$query = "UPDATE products SET name=?, resources=?, quizzes=?, speedTest=?, assessment=?, duration=?, cost=?, status=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssiiisssi", $productName, $productResources, $productQuiz, $productTest, $productAssessment, $productDuration, $productCost, $productStatus, $id);

// Execute query and return JSON response
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Product updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update product"]);
}

$stmt->close();
$conn->close();
?>
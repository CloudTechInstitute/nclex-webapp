<?php
header("Content-Type: application/json");
include "connection.php"; // Ensure database connection

// Ensure request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    exit;
}

// Validate required fields
if (
    !isset($_POST['questionId']) || !isset($_POST['question']) ||
    !isset($_POST['questionCategory']) || !isset($_POST['questionType']) ||
    !isset($_POST['questionMarks']) || !isset($_POST['questionSolution']) ||
    !isset($_POST['options'])
) {
    echo json_encode(["status" => "error", "message" => "Missing fields"]);
    exit;
}

// Sanitize input data
$id = intval($_POST['questionId']);
$question = trim($_POST['question']);
$category = trim($_POST['questionCategory']); // Store category name
$type = trim($_POST['questionType']);
$marks = intval($_POST['questionMarks']);
$solution = trim($_POST['questionSolution']);
$options = $_POST['options']; // Options array

// Convert options array to a comma-separated string
$options_string = implode(",", array_map('trim', $options));

// Prepare SQL update query
$query = "UPDATE questions SET question=?, category=?, type=?, mark_allocated=?, solution=?, options=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssissi", $question, $category, $type, $marks, $solution, $options_string, $id);

// Execute query and return JSON response
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Question updated successfully"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to update question"]);
}

$stmt->close();
$conn->close();
?>
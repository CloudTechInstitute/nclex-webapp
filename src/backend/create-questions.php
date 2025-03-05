<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim and sanitize input data
    $question = isset($_POST['questionName']) ? trim($_POST['questionName']) : '';
    $option1 = isset($_POST['option1']) ? trim($_POST['option1']) : '';
    $option2 = isset($_POST['option2']) ? trim($_POST['option2']) : '';
    $option3 = isset($_POST['option3']) ? trim($_POST['option3']) : '';
    $option4 = isset($_POST['option4']) ? trim($_POST['option4']) : '';
    $option5 = isset($_POST['option5']) ? trim($_POST['option5']) : '';
    $solution = isset($_POST['questionSolution']) ? trim($_POST['questionSolution']) : '';
    $type = isset($_POST['questionType']) ? trim($_POST['questionType']) : ''; // Question type
    $category = isset($_POST['category']) ? trim($_POST['category']) : '';
    $markAllocated = isset($_POST['markAllocated']) ? trim($_POST['markAllocated']) : '';
    $correctAnswer = isset($_POST['correctAnswer']) ? trim($_POST['correctAnswer']) : '';

    $is_attempted = 0;

    // Validate required fields
    if (empty($question) || empty($option1) || empty($correctAnswer) || empty($solution) || empty($type) || empty($category) || empty($markAllocated)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    // Filter and combine options into a single string
    $options = array_filter([$option1, $option2, $option3, $option4, $option5]); // Remove empty options
    $optionsString = implode(',', $options); // Convert to a comma-separated string

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO questions (question, options, answer, solution, type, category, mark_allocated, is_attempted) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $question, $optionsString, $correctAnswer, $solution, $type, $category, $markAllocated, $is_attempted);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Question added successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Could not add question', 'error' => $stmt->error]);
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
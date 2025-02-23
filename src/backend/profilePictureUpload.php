<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['UserID'])) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
        exit;
    }

    $userID = $_SESSION['UserID'];
    $uploadDir = '../images/'; // Directory where images are stored

    // Get the current profile image name
    $query = "SELECT profileImage FROM employees WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($oldImage);
    $stmt->fetch();
    $stmt->close();

    // Check if a file is uploaded
    if (!isset($_FILES['picture']) || $_FILES['picture']['error'] != UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'File upload error']);
        exit;
    }

    $imageName = basename($_FILES['picture']['name']); // Extract only the filename
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedImageTypes = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageExt, $allowedImageTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type! Only JPG, JPEG, PNG are allowed.']);
        exit;
    }

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $imageName)) {

        // Delete the old image if it exists and is not the default image
        if (!empty($oldImage) && $oldImage !== 'blank_dp.png' && file_exists($uploadDir . $oldImage)) {
            unlink($uploadDir . $oldImage); // Delete the old image
        }

        // Update database with new image name
        $query = "UPDATE employees SET profileImage = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $imageName, $userID);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Profile picture updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Try again.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload file!']);
    }

    $conn->close();
}
?>
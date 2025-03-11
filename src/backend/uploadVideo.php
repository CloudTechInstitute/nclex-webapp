<?php
ini_set('upload_max_filesize', '200M');
ini_set('post_max_size', '210M');
ini_set('max_execution_time', '300');
ini_set('max_input_time', '300');
ini_set('memory_limit', '256M');

include 'connection.php';
header('Content-Type: application/json');

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Check if file is too large (post_max_size exceeded)
if (empty($_FILES)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'File is too large. Increase post_max_size in php.ini',
    ]);
    exit;
}

// Check if file was uploaded correctly
$errorMessages = [
    UPLOAD_ERR_OK => 'No error, file uploaded successfully.',
    UPLOAD_ERR_INI_SIZE => 'File exceeds the upload_max_filesize directive in php.ini.',
    UPLOAD_ERR_FORM_SIZE => 'File exceeds the MAX_FILE_SIZE directive in the HTML form.',
    UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'File upload stopped by extension.',
];

$errorCode = $_FILES['video']['error'];
if ($errorCode !== UPLOAD_ERR_OK) {
    echo json_encode([
        'status' => 'error',
        'message' => $errorMessages[$errorCode] ?? 'Unknown upload error.',
    ]);
    exit;
}

// File details
$videoFile = $_FILES['video'];
$fileName = basename($videoFile['name']);
$videoTmpPath = $videoFile['tmp_name'];
$videoSize = $videoFile['size'];
$videoType = $videoFile['type'];
$videoName = isset($_POST['videoname']) ? trim($_POST['videoname']) : '';
$videoCategory = isset($_POST['videoCategory']) ? trim($_POST['videoCategory']) : '';
$date = date('Y-m-d');

// Set file size limit (200MB)
$maxSize = 200 * 1024 * 1024;
if ($videoSize > $maxSize) {
    echo json_encode([
        'status' => 'error',
        'message' => 'File size exceeds the 200MB limit. Please upload a smaller file.',
        'file_size' => round($videoSize / (1024 * 1024), 2) . ' MB'
    ]);
    exit;
}

// Allowed video formats
$allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/mkv'];
if (!in_array($videoType, $allowedTypes)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Allowed formats: MP4, AVI, MOV, MKV.']);
    exit;
}

// Ensure upload directory exists
$uploadDir = 'uploads/videos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Generate a unique filename
$fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
$newFileName = uniqid('glnclexVideo_', true) . '.' . $fileExtension;
$targetFilePath = $uploadDir . $newFileName;

// Move uploaded file
if (!move_uploaded_file($videoTmpPath, $targetFilePath)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
    exit;
}

// Store video details in the database
$stmt = $conn->prepare("INSERT INTO videos (name, filename, filepath, category, date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $videoName, $fileName, $targetFilePath, $videoCategory, $date);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Video uploaded successfully', 'video_path' => $targetFilePath]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database insert failed', 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
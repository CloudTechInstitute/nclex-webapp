<?php
require 'connection.php';
require '../../vendor/autoload.php'; // PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['questions'])) {
    $file = $_FILES['questions'];
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileType, ['xls', 'xlsx', 'csv'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Only .xls, .xlsx, and .csv are allowed.']);
        exit;
    }

    $data = [];

    if ($fileType === 'csv') {
        $data = readCSV($fileTmpPath);
    } else {
        $data = readExcel($fileTmpPath);
    }

    if (!empty($data)) {
        $inserted = insertIntoDatabase($data, $conn);
        if ($inserted) {
            echo json_encode(['status' => 'success', 'message' => 'File uploaded and data inserted successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert data into the database.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No valid data found in the file.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

// Function to read CSV file
function readCSV($filePath)
{
    $data = [];
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $header = fgetcsv($handle, 1000, ","); // Read the header row

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = array_combine($header, $row);
        }
        fclose($handle);
    }
    return $data;
}

// Function to read Excel file (.xls or .xlsx)
function readExcel($filePath)
{
    $spreadsheet = IOFactory::load($filePath);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = [];

    $rows = $worksheet->toArray(); // Convert entire sheet to array
    $headers = array_shift($rows); // Get the header row

    foreach ($rows as $row) {
        if (!empty(array_filter($row))) { // Ignore empty rows
            $data[] = array_combine($headers, $row);
        }
    }
    return $data;
}

// Function to insert data into the database
function insertIntoDatabase($data, $conn)
{
    $stmt = $conn->prepare("INSERT INTO questions (question, options, answer, solution, type, category, mark_allocated, is_attempted) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        return false;
    }

    foreach ($data as $row) {
        $is_attempted = 0;

        $stmt->bind_param(
            "ssssssii",
            $row['question'],
            $row['options'],
            $row['answer'],
            $row['solution'],
            $row['type'],
            $row['category'],
            $row['mark_allocated'],
            $is_attempted
        );

        if (!$stmt->execute()) {
            return false;
        }
    }

    $stmt->close();
    return true;
}
?>
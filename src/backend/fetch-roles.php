<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM roles ORDER BY ID DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $roles = [];
        while ($row = $result->fetch_assoc()) {
            // Convert date format from Y-m-d to d-m-y
            $row['date'] = date("d-m-Y", strtotime($row['date']));
            $roles[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $roles]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No roles found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
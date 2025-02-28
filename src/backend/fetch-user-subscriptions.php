<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT * FROM subscriptions ORDER BY ID DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user_subscriptions = [];
        while ($row = $result->fetch_assoc()) {
            $row['date_subscribed'] = date("d-m-Y", strtotime($row['date_subscribed']));
            $user_subscriptions[] = $row;
        }
        echo json_encode(['status' => 'success', 'data' => $user_subscriptions]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No subscriptions found']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
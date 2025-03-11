<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch video count
    $productQuery = "SELECT COUNT(*) AS product_count FROM products";
    $productResult = $conn->query($productQuery);

    // Fetch question count
    $subscriptionQuery = "SELECT COUNT(*) AS subscription_count FROM subscriptions";
    $subscriptionResult = $conn->query($subscriptionQuery);

    // Fetch ebooks count
    // $ebookQuery = "SELECT COUNT(*) AS ebook_count FROM ebooks";
    // $ebookResult = $conn->query($ebookQuery);

    // Fetch audios count
    // $audioQuery = "SELECT COUNT(*) AS audio_count FROM audios";
    // $audioResult = $conn->query($audioQuery);

    if ($productResult && $subscriptionResult) {
        $productRow = $productResult->fetch_assoc();
        $subscriptionRow = $subscriptionResult->fetch_assoc();

        echo json_encode([
            'status' => 'success',
            'product_count' => $productRow['product_count'],
            'subscription_count' => $subscriptionRow['subscription_count'],

        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch data']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
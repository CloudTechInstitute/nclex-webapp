<?php
include 'connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch video count
    $videoQuery = "SELECT COUNT(*) AS video_count FROM videos";
    $videoResult = $conn->query($videoQuery);

    // Fetch question count
    $questionQuery = "SELECT COUNT(*) AS question_count FROM questions";
    $questionResult = $conn->query($questionQuery);

    // Fetch ebooks count
    $ebookQuery = "SELECT COUNT(*) AS ebook_count FROM ebooks";
    $ebookResult = $conn->query($ebookQuery);

    // Fetch audios count
    $audioQuery = "SELECT COUNT(*) AS audio_count FROM audios";
    $audioResult = $conn->query($audioQuery);

    if ($videoResult && $questionResult) {
        $videoRow = $videoResult->fetch_assoc();
        $questionRow = $questionResult->fetch_assoc();
        $audioRow = $audioResult->fetch_assoc();
        $ebookRow = $ebookResult->fetch_assoc();

        echo json_encode([
            'status' => 'success',
            'video_count' => $videoRow['video_count'],
            'question_count' => $questionRow['question_count'],
            'audio_count' => $audioRow['audio_count'],
            'ebook_count' => $ebookRow['ebook_count']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch data']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
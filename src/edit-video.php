<?php include 'head.php';
include 'backend/connection.php';
session_start();
if (!isset($_SESSION['LoggedUser'])) {
    header('location:login.php');
    exit;
} else {
    $user = $_SESSION['LoggedUser'];
    $role = $_SESSION['UserRole'];
}

?>

<?php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID input

    // Fetch question details
    $stmt = $conn->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $video = $result->fetch_assoc();

    } else {
        echo "video not found!";
        exit();
    }

    $stmt->close();
} else {
    echo "No video ID provided!";
    exit();
}
?>

<body class="dark:bg-gray-800 dark:text-white">
    <div class=" flex h-screen">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php' ?>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <!-- Content Area -->
            <div class="px-6 py-4 md:flex justify-between mt-5 lg:mt-0 items-end mb-5">
                <p class="uppercase font-bold text-xl ml-10 md:ml-0">edit video</p>

            </div>
            <div class="[&::-webkit-scrollbar]:w-2
                                    [&::-webkit-scrollbar-track]:rounded-full
                                    [&::-webkit-scrollbar-track]:bg-gray-100
                                    [&::-webkit-scrollbar-thumb]:rounded-full
                                    [&::-webkit-scrollbar-thumb]:bg-gray-300
                                    dark:[&::-webkit-scrollbar-track]:bg-gray-700
                                    dark:[&::-webkit-scrollbar-thumb]:bg-gray-600 overflow-y-auto px-4">
                <div class="w-full px-6 mb-5 ">

                    <div class="">
                        <?php include 'components/edit-video-form.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="backend/js/edit-video.js"></script>

    <?php include 'footer.php'; ?>
<?php include 'head.php';
include 'backend/connection.php';
session_start();
if (!isset($_SESSION['LoggedUser'])) {
    header('location:login.php');
    exit;
} else {
    $user = $_SESSION['LoggedUser'];
    $role = $_SESSION['UserRole'];
    $userID = $_SESSION['UserID'];
    $userStatus = $_SESSION['UserStatus'];
}

?>

<?php

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize ID input

    // Fetch question details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $question = $result->fetch_assoc();
        // $options = explode(',', $question['options']); // Convert options string to array
    } else {
        echo "Product not found!";
        exit();
    }

    $stmt->close();
} else {
    echo "No product ID provided!";
    exit();
}
?>


<body class="dark:bg-gray-800 dark:text-white">
    <div class=" flex h-screen">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php' ?>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Content Area -->
            <div class="px-6 py-8  flex justify-between items-end mb-8">
                <p class="uppercase ml-10 lg:ml-0 font-bold text-xl">Edit Product</p>
            </div>
            <div class="overflow-y-auto px-6">
                <div class="lg:flex gap-6">
                    <div
                        class="dark:bg-gray-800 p-3 rounded-lg w-full mb-4 lg:mb-0 lg:w-[75%] border dark:border-gray-700 border-gray-400 shadow-md">
                        <?php include 'components/edit-product-form.php'; ?>
                    </div>
                    <div
                        class="dark:bg-gray-800 p-6 rounded-lg w-full lg:w-[25%] mb-4 lg:mb-0 border dark:border-green-600 border-gray-400 shadow-md">
                        <div class="text-center mb-6">
                            <div class="mb-5">
                                <?php echo $question["name"]; ?>
                            </div>
                            <div class="text-5xl text-green-600 font-bold mb-5">
                                <span class="text-2xl align-super">$</span><?php echo $question["cost"]; ?>
                            </div>
                            <div class="font-semibold text-xl">
                                <?php echo $question["duration"] . " "; ?>Access
                            </div>
                        </div>

                        <div class="">
                            <div class="">
                                <i class="fa-solid fa-check mr-3 text-green-600"></i><span
                                    class="text-md font-light">2300+ Practice
                                    Questions</span>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-check mr-3 text-green-600"></i><span
                                    class="text-md font-light">High Yield Review
                                    Videos
                                </span>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-check mr-3 text-green-600"></i><span
                                    class="text-md font-light"><?php echo $question["speedTest"] . " "; ?> Speed
                                    Tests</span>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-check mr-3 text-green-600"></i><span
                                    class="text-md font-light"><?php echo $question["assessment"] . " "; ?>Self
                                    Assessment
                                    Tests</span>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-check mr-3 text-green-600"></i><span
                                    class="text-md font-light"><?php echo $question["quizzes"] . " "; ?>Quizzes</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- role modal -->

    <script type="text/javascript" src="backend/js/edit-product.js"></script>

    <?php include 'footer.php'; ?>
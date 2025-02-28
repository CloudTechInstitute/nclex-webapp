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
    $dp = $_SESSION['dp'];
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
                <p class="uppercase ml-10 lg:ml-0 font-bold text-xl">Settings</p>
            </div>
            <div class="overflow-y-auto px-6">
                <div class="lg:flex gap-6">
                    <div
                        class="mb-5 lg:mb-0 w-full lg:max-w-sm bg-white border border-gray-400 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col items-center py-20">
                            <?php
                            $query = "SELECT * FROM employees WHERE id = '$userID'";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                $profileImage = !empty($row['profileImage']) ? $row['profileImage'] : 'blank_dp.png';
                            } else {
                                $profileImage = 'blank_dp.png'; // Default image if user doesn't exist
                            }

                            echo '<div class="w-24 h-24 mb-3 rounded-full shadow-lg overflow-hidden">
                                    <img class="w-full h-full object-cover" src="images/' . $profileImage . '" alt="Profile Image" />
                                </div>';
                            ?>

                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?php echo $user; ?></h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400 mb-4"><?php echo $role; ?></span>

                            <?php if ($userStatus == 'active') {
                                echo '<span class="text-xs uppercase text-green-600 p-2 border border-green-500 rounded-lg">' . $userStatus . '</span>';
                            } else {
                                echo '<span class="text-xs uppercase text-red-600 p-2 border border-red-500 rounded-lg">' . $userStatus . '</span>';
                            }
                            ?>


                        </div>
                    </div>
                    <div
                        class="dark:bg-gray-800 p-3 lg:h-[500px] lg:max-h-[500px] mb-4 lg:mb-0 rounded-lg w-full lg:w-[70%] border dark:border-gray-700 border-gray-400 shadow-md">
                        <?php include 'components/tab.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- role modal -->

    <script type="text/javascript" src="backend/js/uploadProfile.js"></script>

    <?php include 'footer.php'; ?>
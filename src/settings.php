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

<body class="dark:bg-gray-800 dark:text-white">
    <div class=" flex h-screen">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php' ?>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Content Area -->
            <div class="px-6 py-8 flex justify-between items-end mb-8">
                <p class="uppercase font-bold text-xl">Settings</p>
            </div>
            <div class="overflow-y-auto px-6">
                <div class="flex gap-6">
                    <div
                        class="w-full max-w-sm bg-white border border-gray-400 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col items-center py-20">
                            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="images/dp.jpg"
                                alt="profile image" />
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
                        class="dark:bg-gray-800 p-3 h-[500px] max-h-[500px] rounded-lg w-[70%] border dark:border-gray-700 border-gray-400 shadow-md">
                        <?php include 'components/tab.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- role modal -->


    <!-- <script type="text/javascript" src="backend/js-functions.js"></script> -->
    <script type="text/javascript" src="backend/fetchEmployees.js"></script>
    <script type="text/javascript" src="backend/settings-scripts.js"></script>

    <?php include 'footer.php'; ?>
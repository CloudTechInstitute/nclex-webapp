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

<body class="dark:bg-gray-800 dark:text-white">
    <div class=" flex h-screen">
        <!-- Sidebar -->
        <?php include 'components/sidebar.php' ?>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col w-full overflow-y-auto">
            <!-- Content Area -->
            <div class="px-6 py-2 lg:py-4 md:flex justify-between mt-5 lg:mt-0 items-end mb-8">
                <p class="uppercase font-bold text-xl ml-10 md:ml-0">user subscriptions</p>
                <div class="flex gap-4 justify-between mt-5 lg:mt-0">
                    <?php if ($role == "account manager") {
                        echo '   
                     <button data-modal-target="role-modal" data-modal-toggle="role-modal"
                         class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600"
                         type="button">
                         New Role
                     </button>
                     <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                         class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600"
                         type="button">
                         New Account
                     </button>';
                    } else {
                        echo '<button data-modal-target="product-modal" data-modal-toggle="product-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600"
                        type="button">
                        New Product
                    </button>';
                    }
                    ?>
                </div>


            </div>
            <div class="overflow-y-auto">
                <div class="flex gap-6 w-full px-6 mb-5">
                    <div class="w-full">
                        <div class="border border-gray-500 overflow-x-auto">
                            <?php include 'components/user-subscriptions.php'; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- modals starts here -->
    <?php switch ($role) {
        case "account manager": ?>
    <div id="role-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include 'components/modals/role-modal.php'; ?>
    </div>
    <div id="crud-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include 'components/modals/account-modal.php'; ?>
    </div>
    <?php break;

        case "product manager": ?>
    <div id="product-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include 'components/modals/product-modal.php'; ?>
    </div>
    <?php break;

        case "content manager": ?>
    <div id="Question-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/question-modal.php"; ?>
    </div>
    <div id="importQuestion-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/import-question-modal.php"; ?>
    </div>
    <?php break;

        default:
            break;
    } ?>
    </div>

    <!-- <script type="text/javascript" src="backend/js/create-product.js"></script> -->
    <script type="text/javascript" src="backend/js/user-subscriptions.js"></script>

    <?php include 'footer.php'; ?>
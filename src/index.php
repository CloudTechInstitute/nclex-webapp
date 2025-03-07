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
            <div class="px-6 py-4 flex flex-wrap mt-5 lg:mt-0 justify-between items-center gap-4 md:gap-0">
                <p class="ml-10 md:ml-0 uppercase font-bold text-xl">Dashboard</p>
                <div class="flex flex-wrap gap-2 justify-center  md:justify-end">
                    <?php
                    switch ($role) {
                        case "account manager":
                            ?>
                    <button data-modal-target="role-modal" data-modal-toggle="role-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Role
                    </button>
                    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Account
                    </button>
                    <?php break;

                        case "content manager":
                            ?>
                    <button data-modal-target="Question-modal" data-modal-toggle="Question-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Question
                    </button>
                    <button data-modal-target="importQuestion-modal" data-modal-toggle="importQuestion-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        Import Questions
                    </button>
                    <?php break;

                        case "product manager":
                            ?>
                    <button data-modal-target="product-modal" data-modal-toggle="product-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Product
                    </button>
                    <button data-modal-target="product-modal" data-modal-toggle="product-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Product
                    </button>
                    <?php break;

                        default:
                            // No buttons for undefined roles
                            break;
                    }
                    ?>

                </div>
            </div>

            <!-- cards here -->
            <div>
                <main class="p-6 w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php
                    switch ($role) {
                        case 'account manager':
                            include 'components/account-manager-card.php';
                            break;

                        case 'content manager':
                            include 'components/content-manager-card.php';
                            break;

                        default:

                            break;
                    }

                    ?>
                </main>


                <!-- tables here -->
                <?php switch ($role) {
                    case 'account manager': ?>
                <div class="w-full px-6 mb-5 ">
                    <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent employee accounts</p>
                    <div class="border border-gray-500 overflow-x-auto">
                        <?php include 'components/employee-table.php'; ?>
                    </div>
                </div>

                <div class="mb-5 lg:mb-0 w-full px-6 ">
                    <div class="hidden w-full">
                        <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent roles</p>
                        <div class="border border-gray-500 overflow-x-auto">
                            <?php include 'components/roles-table.php'; ?>
                        </div>
                    </div>
                    <div class="w-full">
                        <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent subscriber accounts</p>
                        <div class="border border-gray-500 overflow-x-auto">
                            <?php include 'components/subscriber-table.php'; ?>
                        </div>
                    </div>
                </div>
                <?php break;
                    case 'content manager': ?>
                <div class="w-full px-6 mb-5 ">
                    <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent videos</p>
                    <div class="border border-gray-500 overflow-x-auto">
                        <?php include 'components/videos-table.php'; ?>
                    </div>
                </div>

                <div class="mb-5 lg:mb-0 w-full px-6 ">
                    <div class="w-full">
                        <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent questions</p>
                        <div class="border border-gray-500 overflow-x-auto">
                            <?php include 'components/questions-table.php'; ?>
                        </div>
                    </div>
                </div> <?php } ?>

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

    <?php
    switch ($role) {
        case "content manager": ?>
    <script type="text/javascript" src="backend/js/content-dashboardCards.js"></script>
    <script type="text/javascript" src="backend/js/create-question.js"></script>
    <script type="text/javascript" src="backend/js/fetch-questions.js"></script>
    <script type="text/javascript" src="backend/js/fetch-videos.js"></script>
    <script type="text/javascript" src="backend/js/importquestion.js"></script>
    <?php break; ?>
    <?php default: ?>
    <script type="text/javascript" src="backend/js/js-functions.js"></script>
    <script type="text/javascript" src="backend/js/fetchEmployees.js"></script>
    <script type="text/javascript" src="backend/js/fetchSubscriber.js"></script>
    <script type="text/javascript" src="backend/js/dashboardCards.js"></script>
    <script type="text/javascript" src="backend/js/create-product.js"></script>
    <?php break; ?>
    <?php } ?>
    <?php include 'footer.php'; ?>
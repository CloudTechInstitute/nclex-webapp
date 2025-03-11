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
        <div class="flex-1 flex flex-col overflow-y-auto w-full">
            <!-- Content Area -->
            <div class="px-6 py-4 md:flex justify-between mt-5 lg:mt-0 items-end mb-8">
                <p class="uppercase font-bold text-xl ml-10 md:ml-0">questions</p>
                <div class="flex flex-wrap gap-2 justify-center  md:justify-end">
                    <button data-modal-target="Question-modal" data-modal-toggle="Question-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        New Question
                    </button>
                    <button data-modal-target="importQuestion-modal" data-modal-toggle="importQuestion-modal"
                        class="block text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 dark:bg-green-400">
                        Import Questions
                    </button>
                </div>
            </div>
            <div class="overflow-y-auto">
                <div class="w-full px-6 mb-5 ">
                    <p class="uppercase font-bold mb-2 text-sm text-gray-400">questions</p>
                    <div class="border border-gray-500 overflow-x-auto">
                        <?php include 'components/questions-table.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="Question-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/question-modal.php"; ?>
    </div>
    <div id="importQuestion-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/import-question-modal.php"; ?>
    </div>


    <div id="editModal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/edit-question-modal.php"; ?>
    </div>

    <script type="text/javascript" src="backend/js/create-question.js"></script>
    <script type="text/javascript" src="backend/js/fetch-questions.js"></script>
    <script type="text/javascript" src="backend/js/importquestion.js"></script>

    <?php include 'footer.php'; ?>
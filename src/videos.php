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
        <div class="flex-1 flex flex-col  overflow-y-auto w-full">
            <!-- Content Area -->
            <div class="px-6 py-4 md:flex justify-between mt-5 lg:mt-0 items-end mb-8">
                <p class="uppercase font-bold text-xl ml-10 md:ml-0">videos</p>
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
            <div class="[&::-webkit-scrollbar]:w-2
                                    [&::-webkit-scrollbar-track]:rounded-full
                                    [&::-webkit-scrollbar-track]:bg-gray-100
                                    [&::-webkit-scrollbar-thumb]:rounded-full
                                    [&::-webkit-scrollbar-thumb]:bg-gray-300
                                    dark:[&::-webkit-scrollbar-track]:bg-gray-700
                                    dark:[&::-webkit-scrollbar-thumb]:bg-gray-600 overflow-y-auto">
                <div class="p-2 mx-6 my-4 border border-gray-300 rounded-lg max-w-xl">
                    <form class="p-4 md:p-5 " id="uploadVideoForm" method="post" enctype="multipart/form-data">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <label class="col-span-2  block text-sm font-medium text-gray-900 dark:text-white">Upload
                                Video <span class="text-green-400 mr-2">(file size limit 10MB)</span>
                            </label>
                            <div class="col-span-2 md:col-span-1">
                                <input type="text" name="videoname" id="videoname"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="enter video name" required="">
                            </div>
                            <div class="col-span-2 md:col-span-1">

                                <select id="videoCategory" name="videoCategory"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option hidden disabled selected>--Select one--</option>
                                    <?php
                                    $categoryQuery = "SELECT category FROM categories";
                                    $categoryResult = $conn->query($categoryQuery);

                                    if ($categoryResult->num_rows > 0) {
                                        while ($category = $categoryResult->fetch_assoc()) {
                                            echo "<option value='{$category['category']}'>{$category['category']}</option>";
                                        }
                                    } else {
                                        echo "<option disabled>No categories found</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <div class="col-span-2">
                                <input type="file" name="video" id="video-file"
                                    class="block p-4 w-full text-sm text-gray-900 border border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600"
                                    required />
                            </div>
                        </div>
                        <div id="progressContainer"
                            class="w-full mb-2 bg-gray-200 rounded-full dark:bg-gray-700 hidden">
                            <div id="uploadProgress"
                                class="bg-green-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                style="width: 0%">0%</div>
                        </div>
                        <button type="submit"
                            class="inline-flex font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Upload
                        </button>
                    </form>
                </div>
                <div class="w-full px-6 mb-5 ">
                    <p class="uppercase font-bold mb-2 text-sm text-gray-400">recent videos</p>
                    <div class="border border-gray-500 overflow-x-auto">
                        <?php include 'components/videos-table.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modals starts here -->

    <div id="Question-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/question-modal.php"; ?>
    </div>
    <div id="importQuestion-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <?php include "components/modals/import-question-modal.php"; ?>
    </div>

    </div>

    <script type="text/javascript" src="backend/js/create-question.js"></script>
    <script type="text/javascript" src="backend/js/fetch-videos.js"></script>
    <script type="text/javascript" src="backend/js/importquestion.js"></script>
    <script type="text/javascript" src="backend/js/uploadVideo.js"></script>


    <?php include 'footer.php'; ?>
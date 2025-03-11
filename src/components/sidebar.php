<aside id="sidebar"
    class="w-64 h-screen p-5 flex flex-col justify-between outline outline-2 outline-gray-300 dark:outline-none bg-gray-100 dark:bg-gray-900 transition-transform transform -translate-x-full md:translate-x-0 fixed md:relative z-50">
    <div>
        <h1 class="text-2xl ml-10 lg:ml-0 font-bold dark:text-green-400 text-blue-900 uppercase">Global Nclex</h1>
        <nav class="mt-6">
            <a href="index.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-gauge"></i>
                    <div>Dashboard</div>
                </div>
            </a>
            <?php
            switch ($role) {
                case 'account manager': ?>
            <a href="employees.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-users"></i>
                    <div>Employee Accounts</div>
                </div>
            </a>
            <a href="subscribers.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-users"></i>
                    <div>Subscribers</div>
                </div>
            </a>
            <a href="roles.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-sliders"></i>
                    <div>Roles</div>
                </div>
            </a>
            <a href="user-subscriptions.php"
                class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-list"></i>
                    <div>Subscriptions</div>
                </div>
            </a>
            <?php break;

                case 'content manager':
                    ?>
            <a href="videos.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-video"></i>
                    <div>Videos</div>
                </div>
            </a>
            <a href="questions.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-book"></i>
                    <div>Questions</div>
                </div>
            </a>
            <a href="lessons.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-book-open"></i>
                    <div>Lessons</div>
                </div>
            </a>
            <a href="subscriptions.php"
                class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-list"></i>
                    <div>Subscriptions</div>
                </div>
            </a><?php
                    break;

                case 'product manager':
                    ?>

            <a href="products.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-layer-group text-blue-600 dark:text-green-400"></i>
                    <div>Products</div>
                </div>
            </a>
            <a href="user-subscriptions.php"
                class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-users-gear"></i>
                    <div>User Subscriptions</div>
                </div>
            </a>
            <a href="subscriptions.php"
                class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-list"></i>
                    <div>Subscriptions</div>
                </div>
            </a>
            <?php
                    break;
                default:
            }
            ?>


            <a href="settings.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid text-blue-600 dark:text-green-400 fa-gear"></i>
                    <div>Settings</div>
                </div>
            </a>
        </nav>
    </div>
    <div class="p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-200 dark:bg-gray-800">
        <div class="flex justify-start gap-2 items-center mb-2">

            <div>
                <p class="font-bold text-sm"><?php echo $user; ?></p>
                <p class="text-xs"><?php echo $role; ?></p>
            </div>
        </div>
        <form method="post" action="logout.php">
            <button
                class="block w-full text-white dark:text-gray-900 bg-blue-900 hover:bg-red-500 dark:hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-500  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:focus:ring-green-600"
                type="submit">
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- Sidebar Toggle Button -->
<button id="sidebarToggle"
    class="fixed top-4 left-4 z-50 bg-blue-900 text-white dark:bg-green-400 p-2 rounded-md md:hidden">
    <i class="fa-solid fa-bars"></i>
</button>

<script>
const sidebar = document.getElementById("sidebar");
const toggleButton = document.getElementById("sidebarToggle");

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
});

// Close sidebar when clicking outside on small screens
document.addEventListener("click", (event) => {
    if (!sidebar.contains(event.target) && !toggleButton.contains(event.target) && window.innerWidth < 768) {
        sidebar.classList.add("-translate-x-full");
    }
});
</script>
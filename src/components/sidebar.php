<aside
    class="w-64 h-screen p-5 flex flex-col justify-between outline outline-2 outline-gray-300 dark:outline-none bg-gray-100 dark:bg-gray-900">
    <div>
        <h1 class="text-2xl font-bold dark:text-green-400 text-blue-900">Content Center</h1>
        <nav class="mt-6">
            <a href="index.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-gauge"></i>
                    <div>Dashboard</div>
                </div>
            </a>
            <a href="employees.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-users"></i>
                    <div>Employee Accounts</div>
                </div>
            </a>
            <a href="subscribers.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-users"></i>
                    <div>Subscribers</div>
                </div>
            </a>
            <a href="roles.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-sliders"></i>
                    <div>Roles</div>
                </div>
            </a>
            <a href="subscriptions.php"
                class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-list"></i>
                    <div>Subscriptions</div>
                </div>
            </a>

            <a href="#" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-video"></i>
                    <div>Videos</div>
                </div>
            </a>

            <a href="#" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-book"></i>
                    <div>E-Books</div>
                </div>
            </a>
            <a href="#" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-book-open"></i>
                    <div>Quizzes</div>
                </div>
            </a>
            <a href="settings.php" class="block font-semibold p-4 hover:bg-gray-300 dark:hover:bg-gray-800 rounded">
                <div class="flex gap-3 items-center">
                    <i class="fa-solid fa-gear"></i>
                    <div>Settings</div>
                </div>
            </a>
        </nav>
    </div>
    <div class="p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-200 dark:bg-gray-800">
        <div class="flex justify-start gap-2 items-center mb-2">
            <div>
                <div class="w-5 h-5 p-5 rounded-full bg-gray-400"></div>
            </div>
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
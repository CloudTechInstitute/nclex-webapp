<?php include 'head.php'; ?>
<?php include 'backend/connection.php'; // Include database connection ?>

<body class="">

    <div
        class="w-full p-4 flex justify-center items-center h-screen bg-white sm:p-6 md:p-8 dark:bg-gray-900 dark:border-gray-700">
        <form class="border border-gray-300 dark:border-lime-800 p-10 space-y-6 w-full rounded-lg max-w-lg mx-auto"
            action="#" id="loginForm" method="post">
            <h5 class="text-3xl text-center font-medium text-gray-900 dark:text-white">Sign In</h5>

            <div>
                <label for="username"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                <input type="text" name="username" id="username"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    placeholder="Enter your username" required />
            </div>

            <div>
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                <select name="role" id="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required>
                    <option selected hidden disabled>-- Select One --</option>

                    <?php
                    // Fetch roles from database
                    $query = "SELECT * FROM roles"; // Adjust column names if needed
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($row['role']) . "'>" . htmlspecialchars($row['role']) . "</option>";
                        }
                    } else {
                        echo "<option disabled>No roles available</option>";
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </select>
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    password</label>
                <input type="password" name="password" id="password" placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                    required />
            </div>

            <button type="submit" id="loginBtn"
                class="w-full text-white dark:text-gray-800 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-lime-500 dark:hover:bg-lime-500 dark:focus:ring-lime-500">
                Login
            </button>

        </form>
    </div>

    <script type="text/javascript" src="backend/js/login.js"></script>
    <?php include 'footer.php'; ?>
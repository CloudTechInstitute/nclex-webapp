<?php
// Ensure connection is established
if (!isset($conn)) {
    die("Database connection error.");
}

// Securely fetching user data using prepared statements
$query = "SELECT * FROM employees WHERE name = ? LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>

<div class="mb-4 border-b border-gray-200 dark:border-gray-700">
    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
        data-tabs-toggle="#default-styled-tab-content"
        data-tabs-active-classes="text-blue-600 hover:text-blue-600 dark:text-green-500 dark:hover:text-green-500 border-blue-600 dark:border-green-500"
        data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
        role="tablist">
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                data-tabs-target="#styled-profile" type="button" role="tab" aria-controls="profile"
                aria-selected="false">Profile</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="dashboard-styled-tab"
                data-tabs-target="#styled-dashboard" type="button" role="tab" aria-controls="dashboard"
                aria-selected="false">Reset Password</button>
        </li>
        <li class="me-2" role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="settings-styled-tab"
                data-tabs-target="#styled-settings" type="button" role="tab" aria-controls="settings"
                aria-selected="false">Update Profile Image</button>
        </li>
        <!-- <li role="presentation">
            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="contacts-styled-tab"
                data-tabs-target="#styled-contacts" type="button" role="tab" aria-controls="contacts"
                aria-selected="false">Contacts</button>
        </li> -->
    </ul>
</div>

<div id="default-styled-tab-content">
    <!-- Profile Section -->
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-profile" role="tabpanel"
        aria-labelledby="profile-tab">
        <form class="w-full" method="post" id="updateAccountProfileForm">
            <div class="flex gap-6">
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($row['name']) ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required />
                </div>
            </div>
            <div class="flex gap-6">
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500
                        focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required />
                </div>
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                    <input type="text" value="<?= htmlspecialchars($row['role']) ?>" disabled
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
            </div>
            <div class="flex gap-6">
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required />
                </div>
                <div class="mb-5 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Number</label>
                    <input type="text" value="<?= htmlspecialchars($row['IDnumber']) ?>" name=" idnumber"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                </div>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Submit
            </button>
        </form>
    </div>

    <!-- Reset Password Section -->
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-dashboard" role="tabpanel"
        aria-labelledby="dashboard-tab">
        <form class="w-full" method="post" id="resetPasswordForm">
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter Old Password</label>
                <input type="password" name="old_password" placeholder="*******" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Enter New Password</label>
                <input type="password" name="new_password" placeholder="*******" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm New Password</label>
                <input type="password" name="confirm_password" placeholder="*******" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Submit
            </button>
        </form>
    </div>

    <!-- Profile Picture Upload -->
    <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-settings" role="tabpanel"
        aria-labelledby="settings-tab">
        <form class="max-w-sm" id="profileUpdateForm" method="post" enctype="multipart/form-data">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload Profile Picture</label>
            <input type="file" name="picture" id="user_avatar"
                class="block p-4 w-full text-sm text-gray-900 border border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600" />
            <div class="mt-1 mb-3 text-sm text-gray-500 dark:text-gray-500">A profile picture helps confirm your
                identity.
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Update Picture
            </button>
        </form>
    </div>

    <!-- Contacts Section -->
    <!-- <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-contacts" role="tabpanel"
        aria-labelledby="contacts-tab">
        <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content for the Contacts tab.</p>
    </div> -->
</div>

<?php
}
$stmt->close();
?>
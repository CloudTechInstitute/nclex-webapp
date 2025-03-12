<form class="p-4 md:p-5 max-w-md border border-white rounded-lg" id="editvideoForm" method="post">
    <input type="hidden" name="videoId" value="<?= htmlspecialchars($video['id']) ?>" />

    <div class="gap-4 mb-4">
        <div class="mb-4">
            <label for="video" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Video Name</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="videoName" name="videoName" value="<?= htmlspecialchars($video['name']) ?>" />
        </div>

        <div class="flex gap-2 mb-4">
            <div class="w-full">
                <label for="videoCategory"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select id="videoCategory" name="videoCategory"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option hidden disabled>--Select one--</option>
                    <?php
                    include 'backend/connection.php'; // Ensure database connection is included
                    
                    $categoryQuery = "SELECT id, category FROM categories";
                    $categoryResult = $conn->query($categoryQuery);

                    while ($category = $categoryResult->fetch_assoc()) {
                        // Compare category name instead of ID
                        $selected = ($category['category'] == $video['category']) ? 'selected' : '';
                        echo "<option value='{$category['category']}' $selected>{$category['category']}</option>";
                    }
                    ?>
                </select>

            </div>

        </div>
        <button type="submit"
            class="font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600">
            Submit
        </button>
    </div>
</form>
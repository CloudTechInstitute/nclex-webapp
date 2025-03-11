<form class="p-4 md:p-5 max-w-2xl" id="editQuestionForm" method="post">
    <input type="hidden" name="questionId" value="<?= htmlspecialchars($question['id']) ?>" />

    <div class="grid gap-4 mb-4 grid-cols-2">
        <div class="col-span-2">
            <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Question</label>
            <textarea
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="question" name="question" rows="4"><?= htmlspecialchars($question['question']) ?></textarea>
        </div>

        <div class="flex gap-2 col-span-2">
            <div class="w-full">
                <label for="questionCategory"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                <select id="questionCategory" name="questionCategory"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option hidden disabled>--Select one--</option>
                    <?php
                    include 'backend/connection.php'; // Ensure database connection is included
                    
                    $categoryQuery = "SELECT id, category FROM categories";
                    $categoryResult = $conn->query($categoryQuery);

                    while ($category = $categoryResult->fetch_assoc()) {
                        // Compare category name instead of ID
                        $selected = ($category['category'] == $question['category']) ? 'selected' : '';
                        echo "<option value='{$category['category']}' $selected>{$category['category']}</option>";
                    }
                    ?>
                </select>

            </div>

            <div class="w-full">
                <label for="questionType"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type</label>
                <select id="questionType" name="questionType"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option hidden disabled>--Select one--</option>
                    <option value="mcq" <?= ($question['type'] == 'mcq') ? 'selected' : '' ?>>Multiple Choice Question
                    </option>
                    <option value="msq" <?= ($question['type'] == 'msq') ? 'selected' : '' ?>>Multiple Select Question
                    </option>
                </select>
            </div>

            <div class="w-full">
                <label for="questionMarks"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Marks</label>
                <input type="text" name="questionMarks" id="questionMarks"
                    value="<?= htmlspecialchars($question['mark_allocated']) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
        </div>

        <div class="col-span-2">
            <label for="questionSolution"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Solution</label>
            <textarea
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution"
                rows="6"><?= htmlspecialchars($question['solution']) ?></textarea>
        </div>

        <div class="col-span-2 space-y-2">
            <label for="options" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Options</label>

            <?php
            for ($i = 0; $i < 5; $i++) {
                $optionValue = isset($options[$i]) ? trim($options[$i]) : ''; // Check if option exists
                echo '<input type="text" name="options[]" value="' . htmlspecialchars($optionValue) . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">';
            }
            ?>
        </div>

        <button type="submit"
            class="font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600">
            Submit
        </button>
    </div>
</form>
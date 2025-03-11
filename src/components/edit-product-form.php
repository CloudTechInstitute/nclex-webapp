<form class="p-4 md:p-5 w-full" id="editQuestionForm" method="post">
    <input type="hidden" name="questionId" value="<?= htmlspecialchars($question['id']) ?>" />

    <div class="grid gap-4 mb-4 grid-cols-2">
        <div class="col-span-4">
            <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="question" name="question" value="<?= htmlspecialchars($question['name']) ?>" />
        </div>
        <div class="flex gap-2 col-span-3">
            <div class="w-full">
                <label for="questionMarks"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resources</label>
                <input type="text" name="questionMarks" id="questionMarks"
                    value="<?= htmlspecialchars($question['resources']) ?>"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            </div>
        </div>
        <div class="col-span-1">
            <label for="questionSolution"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quizzes</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution" value="<?= htmlspecialchars($question['quizzes']) ?>" />
        </div>
        <div class="col-span-1">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Speed
                Tests</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution" value="<?= htmlspecialchars($question['speedTest']) ?>" />
        </div>
        <div class="col-span-1">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Assessments</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution"
                value="<?= htmlspecialchars($question['assessment']) ?>" />
        </div>
        <div class="col-span-1">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Duration</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution" value="<?= htmlspecialchars($question['duration']) ?>" />
        </div>
        <div class="col-span-1">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Cost</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" name="questionSolution" value="<?= htmlspecialchars($question['cost']) ?>" />
        </div>
        <div class="col-span-2">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Status</label>
            <select id="questionType" name="questionType"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option hidden disabled>--Select one--</option>
                <option value="free" <?= ($question['status'] == 'free') ? 'selected' : '' ?>>Free
                </option>
                <option value="paid" <?= ($question['status'] == 'paid') ? 'selected' : '' ?>>Paid
                </option>
            </select>
        </div>
        <div class="col-span-2">
            <label for="questionSolution" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Date Created</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="questionSolution" disabled name="questionSolution"
                value="<?= htmlspecialchars($question['date']) ?>" />
        </div>


        <button type="submit"
            class="font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600">
            Submit
        </button>
    </div>
</form>
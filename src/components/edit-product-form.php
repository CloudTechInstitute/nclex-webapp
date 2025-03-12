<form class="p-4 md:p-5 w-full" id="updateProductForm" method="post">
    <input type="hidden" name="productId" value="<?= htmlspecialchars($question['id']) ?>" />

    <div class="grid gap-4 mb-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
        <div class="col-span-1 md:col-span-4">
            <label for="productName"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productName" name="productName" value="<?= htmlspecialchars($question['name']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productResources"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Resources</label>
            <input type="text" name="productResources" id="productResources"
                value="<?= htmlspecialchars($question['resources']) ?>"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productQuiz"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quizzes</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productQuiz" name="productQuiz" value="<?= htmlspecialchars($question['quizzes']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productTest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Speed
                Tests</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productTest" name="productTest" value="<?= htmlspecialchars($question['speedTest']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productAssessment"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assessments</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productAssessment" name="productAssessment"
                value="<?= htmlspecialchars($question['assessment']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productDuration"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duration</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productDuration" name="productDuration" value="<?= htmlspecialchars($question['duration']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productCost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost</label>
            <input type="number"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productCost" name="productCost" value="<?= htmlspecialchars($question['cost']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productStatus"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
            <select id="productStatus" name="productStatus"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option hidden disabled>--Select one--</option>
                <option value="free" <?= ($question['status'] == 'free') ? 'selected' : '' ?>>Free</option>
                <option value="paid" <?= ($question['status'] == 'paid') ? 'selected' : '' ?>>Paid</option>
            </select>
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="productDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                Created</label>
            <input type="text"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                id="productDate" disabled name="productDate" value="<?= htmlspecialchars($question['date']) ?>" />
        </div>

        <div class="col-span-1 md:col-span-2">
            <button type="submit"
                class="font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600 w-full md:w-auto">
                Submit
            </button>
        </div>
    </div>
</form>
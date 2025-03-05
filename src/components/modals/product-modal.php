<div class="relative p-4 w-full max-w-md max-h-full">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <!-- Modal header -->
        <div
            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Create New Product
            </h3>
            <button type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="product-modal">
                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form class="p-4 md:p-5" id="productForm" method="post" s>
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">

                    <input type="text" name="productName" id="productName"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="enter product name" required="">
                </div>
                <div class="col-span-2 sm:col-span-1 w-full">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Learning
                        Resources</label>
                    <div class="flex justify-between gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 h-5">
                                <input type="checkbox" name="topics[]" value="Audio"
                                    class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                                Audio
                            </div>
                            <div class="flex items-center gap-2 h-5">
                                <input type="checkbox" name="topics[]" value="Video"
                                    class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                                Video
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-2 h-5">
                                <input type="checkbox" name="topics[]" value="Text"
                                    class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                                Text
                            </div>
                            <div class="flex items-center gap-2 h-5">
                                <input type="checkbox" name="topics[]" value="E-book"
                                    class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                                E-book
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 mb-4">
                <input type="number" name="productQuiz" id="productQuiz"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="enter max number of quizzes" min="1" required="">
            </div>
            <div class="col-span-2 mb-4">
                <input type="number" name="productSpeedTest" id="productSpeedTest"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="enter max number of speed tests" min="1" required="">
            </div>
            <div class="col-span-2 mb-4">
                <input type="number" name="productAssessments" id="productAssessments"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="enter max number of assessments" min="1" required="">
            </div>
            <div class="flex gap-4 items-center">
                <div class="col-span-2 mb-4">
                    <input type="text" name="productDuration" id="productDuration"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="enter product duration" required="">
                </div>
                <div class="col-span-2 mb-4">
                    <input type="number" name="productCost" id="productCost"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="enter cost of product" min="0" required="">
                </div>
            </div>
            <div class="col-span-2 mb-4">

                <select name="productStatus" id="productStatus"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option selected disabled hidden>Select one</option>
                    <option value="free">free</option>
                    <option value="paid">paid</option>
                </select>
            </div>
            <button type="submit" id="productSubmit"
                class="inline-flex font-bold text-white dark:text-gray-900 bg-blue-900 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-400 dark:hover:bg-green-400 dark:focus:ring-green-600">
                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Create Product
            </button>
        </form>
    </div>
</div>
<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get the current page name
?>
<table class="w-full text-sm text-left text-gray-500 dark:text-gray-700">
    <thead class="text-xs text-white uppercase bg-gray-500 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3 font-bold uppercase">Filename</th>
            <th scope="col" class="px-6 py-3 font-bold uppercase">Category</th>
            <th scope="col" class="px-6 py-3 font-bold uppercase">Date Added</th>
            <?php if ($currentPage !== 'index.php') { ?>
            <th scope="col" class="px-6 py-3 font-bold uppercase">Action</th>
            <?php
            } ?>
            <!-- <th scope="col" class="px-6 py-3 font-bold uppercase">Mark</th> -->
        </tr>
    </thead>
    <tbody id="videosTableBody">
        <!-- Table data goes here -->
    </tbody>
</table>
<div id="videosPagination" class="p-2 bg-gray-700"></div>
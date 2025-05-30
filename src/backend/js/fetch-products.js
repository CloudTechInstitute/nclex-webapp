let currentPage = 1;
const recordsPerPage = window.location.pathname.includes("index.php") ? 4 : 9;

async function fetchProducts(page = 1) {
  let tableBody = document.getElementById("productsTableBody");
  let paginationContainer = document.getElementById("pagination");

  if (!tableBody || !paginationContainer) {
    console.error("Table body or pagination container not found.");
    return;
  }

  // Show the loading spinner
  tableBody.innerHTML = `
        <tr>
            <td colspan="9" class="text-center py-4">
                <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="block text-gray-600 mt-2 font-semibold">Fetching products...</span>
            </td>
        </tr>
    `;

  try {
    let response = await fetch(
      `backend/fetch-products.php?page=${page}&limit=${recordsPerPage}`
    );
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    let result = await response.json();
    if (result.status === "success" && Array.isArray(result.data)) {
      displayProducts(result.data);
      updatePaginationButtons(result.total_pages);
    } else {
      tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-gray-400">${
        result.message || "Failed to fetch products"
      }</td></tr>`;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-gray-400">Error: ${error.message}</td></tr>`;
  }
}

function displayProducts(products) {
  let tableBody = document.getElementById("productsTableBody");
  if (!tableBody) return;

  if (!Array.isArray(products) || products.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-gray-400">No products found</td></tr>`;
    return;
  }

  let isIndexPage = window.location.pathname.includes("index.php");

  tableBody.innerHTML = products
    .map(
      (product) => `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
              product.name
            }</th>
            <td class="px-6 py-2">${product.resources}</td>
            <td class="px-6 py-2">${product.quizzes}</td>
            <td class="px-6 py-2">${product.speedTest}</td>
            <td class="px-6 py-2">${product.assessment}</td>
            <td class="px-6 py-2">${product.duration}</td>
            <td class="px-6 py-2">${product.cost}</td>
            <td class="px-6 py-2 font-bold">${product.status}</td>
            <td class="px-6 py-2">
            ${
              isIndexPage
                ? "" // Hide the edit button on index.php
                : `<a href="edit-products.php?id=${product.id}">
                    <button class="edit-btn text-white bg-blue-600 hover:bg-blue-700 font-medium dark:bg-green-600 dark:hover:bg-green-500 dark:text-gray-900 rounded-lg text-sm px-4 py-2 focus:outline-none">
                        Edit
                    </button>
                  </a>`
            }
            </td>
        </tr>
    `
    )
    .join("");
}

function updatePaginationButtons(totalPages) {
  let paginationContainer = document.getElementById("pagination");

  if (window.location.pathname.includes("index.php")) {
    paginationContainer.innerHTML = "";
    return;
  }

  if (!paginationContainer) return;

  paginationContainer.innerHTML = `
        <button onclick="prevPage()" ${
          currentPage === 1 ? "disabled" : ""
        }><i class="fa-solid fa-chevron-left mr-4"></i></button>
        <span>Page ${currentPage} of ${totalPages}</span>
        <button onclick="nextPage(${totalPages})" ${
    currentPage === totalPages ? "disabled" : ""
  }><i class="fa-solid fa-chevron-right ml-4"></i></button>
    `;
}

function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    fetchProducts(currentPage);
  }
}

function nextPage(totalPages) {
  if (currentPage < totalPages) {
    currentPage++;
    fetchProducts(currentPage);
  }
}

document.addEventListener("DOMContentLoaded", () => fetchProducts());

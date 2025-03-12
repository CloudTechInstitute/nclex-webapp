let subscriptioncurrentPage = 1;
const SubscriptionrecordsPerPage = window.location.pathname.includes(
  "index.php"
)
  ? 4
  : 9;

async function fetchSubscriptions(page = 1) {
  let tableBody = document.getElementById("subscriptionsTableBody");
  let paginationContainer = document.getElementById("paginationControls");

  if (!tableBody || !paginationContainer) {
    console.error("Table body or pagination container not found.");
    return;
  }

  tableBody.innerHTML = `<tr><td colspan="8" class="text-center py-4">Fetching subscriptions...</td></tr>`;

  try {
    let response = await fetch(
      `backend/fetch-subscriptions.php?page=${page}&limit=${SubscriptionrecordsPerPage}`
    );
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    let result = await response.json();

    if (result.status === "success" && Array.isArray(result.data)) {
      displaySubscriptions(result.data);

      // Ensure totalPages is passed correctly
      let totalPages = result.total_pages || 1;
      updatePaginationControls(totalPages);
    } else {
      tableBody.innerHTML = `<tr><td colspan="8" class="text-center text-gray-400">${
        result.message || "Failed to fetch subscriptions"
      }</td></tr>`;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    tableBody.innerHTML = `<tr><td colspan="8" class="text-center text-gray-400">Error: ${error.message}</td></tr>`;
  }
}

// Function to display subscriptions with pagination
function displaySubscriptions(subscriptions) {
  let tableBody = document.getElementById("subscriptionsTableBody");
  if (!tableBody) return;

  if (!Array.isArray(subscriptions) || subscriptions.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-gray-400">No subscriptions found</td></tr>`;
    return;
  }

  tableBody.innerHTML = subscriptions
    .map(
      (subscription) => `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">${subscription.product_name}</th>
            <td class="px-6 py-2">${subscription.duration}</td>
            <td class="px-6 py-2">${subscription.subscription_count}</td>
            <td class="px-6 py-2">
                <button class="edit-btn text-white bg-blue-600 hover:bg-blue-700 font-medium dark:bg-green-600 dark:hover:bg-green-500 dark:text-gray-900 rounded-lg text-sm px-4 py-2 focus:outline-none">
                        active
                </button>
            </td>
        </tr>
    `
    )
    .join("");
}

// Function to update pagination controls
function updatePaginationControls(totalPages) {
  let paginationContainer = document.getElementById("paginationControls");

  if (window.location.pathname.includes("index.php")) {
    paginationContainer.innerHTML = "";
    return;
  }

  if (!paginationContainer) return;

  paginationContainer.innerHTML = `
        <button onclick="prevPage()" ${
          subscriptioncurrentPage === 1 ? "disabled" : ""
        }>
          <i class="fa-solid fa-chevron-left mr-4"></i>
        </button>
        <span>Page ${subscriptioncurrentPage} of ${totalPages}</span>
        <button onclick="nextPage(${totalPages})" ${
    subscriptioncurrentPage === totalPages ? "disabled" : ""
  }>
          <i class="fa-solid fa-chevron-right ml-4"></i>
        </button>
    `;
}

function prevPage() {
  if (subscriptioncurrentPage > 1) {
    subscriptioncurrentPage--;
    fetchSubscriptions(subscriptioncurrentPage);
  }
}

function nextPage(totalPages) {
  if (subscriptioncurrentPage < totalPages) {
    subscriptioncurrentPage++;
    fetchSubscriptions(subscriptioncurrentPage);
  }
}

// Fetch subscriptions when the page loads
document.addEventListener("DOMContentLoaded", () => fetchSubscriptions());

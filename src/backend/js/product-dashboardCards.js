async function fetchProductStats() {
  let productCard = document.getElementById("productCard");
  let subscriptionsCard = document.getElementById("subscriptionsCard");
  //   let audioCard = document.getElementById("audioCard");
  //   let ebookCard = document.getElementById("ebookCard");

  // Show skeleton loaders
  [productCard, subscriptionsCard].forEach(showSkeleton);

  try {
    let response = await fetch("backend/product-fetch-scripts.php");
    if (!response.ok) throw new Error("Network response was not ok");

    let result = await response.json();

    if (result.status === "success") {
      displayDashboardStats(
        result.product_count || 0,
        result.subscription_count || 0
      );
    } else {
      console.error("Error:", result.message);
      showError(productCard, result.message);
      showError(subscriptionsCard, result.message);
    }
  } catch (error) {
    console.error("Fetch error:", error);
    let errorMsg = "Failed to load data. Please try again later.";
    showError(productCard, errorMsg);
    showError(subscriptionsCard, errorMsg);
  }
}

function displayDashboardStats(productCount, subscriptionCount) {
  document.getElementById("productCard").innerHTML = `
        <p class="font-normal text-gray-700 dark:text-gray-400">Total Products</p>
        <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${productCount}</h5>
      `;

  document.getElementById("subscriptionsCard").innerHTML = `
        <p class="font-normal text-gray-700 dark:text-gray-400">Total Subscriptions</p>
        <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${subscriptionCount}</h5>
      `;

  //   document.getElementById("audioCard").innerHTML = `
  //         <p class="font-normal text-gray-700 dark:text-gray-400">Audio</p>
  //         <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${audioCount}</h5>
  //       `;

  //   document.getElementById("ebookCard").innerHTML = `
  //         <p class="font-normal text-gray-700 dark:text-gray-400">Ebooks</p>
  //         <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${ebookCount}</h5>
  //       `;
}

// Utility Functions
function showSkeleton(card) {
  card.innerHTML = `
        <div video="status" class="max-w-sm animate-pulse">
            <div class="h-3 bg-gray-200 rounded-md dark:bg-gray-700 w-24 mb-2"></div>
            <div class="h-8 bg-gray-200 rounded-md dark:bg-gray-700 w-16 mb-2"></div>
            <span class="sr-only">Loading...</span>
        </div>`;
}

function showError(card, message) {
  card.innerHTML = `<p class="text-center text-gray-400">${message}</p>`;
}

// Fetch stats when the page loads
document.addEventListener("DOMContentLoaded", fetchProductStats);

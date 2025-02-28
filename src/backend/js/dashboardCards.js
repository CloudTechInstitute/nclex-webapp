async function fetchDashboardStats() {
  let roleCard = document.getElementById("roleCard");
  let studentCard = document.getElementById("studentCard");
  let employeeCard = document.getElementById("employeeCard");
  let subscriptionCard = document.getElementById("subscriptionCard");

  // Show skeleton loaders
  [roleCard, studentCard, employeeCard, subscriptionCard].forEach(showSkeleton);

  try {
    let response = await fetch("backend/fetch-scripts.php");
    if (!response.ok) throw new Error("Network response was not ok");

    let result = await response.json();

    if (result.status === "success") {
      displayDashboardStats(
        result.employee_count || 0,
        result.role_count || 0,
        result.student_count || 0,
        result.subscription_count || 0
      );
    } else {
      console.error("Error:", result.message);
      showError(roleCard, result.message);
      showError(studentCard, result.message);
      showError(employeeCard, result.message);
      showError(subscriptionCard, result.message);
    }
  } catch (error) {
    console.error("Fetch error:", error);
    let errorMsg = "Failed to load data. Please try again later.";
    showError(roleCard, errorMsg);
    showError(studentCard, errorMsg);
    showError(employeeCard, errorMsg);
    showError(subscriptionCard, errorMsg);
  }
}

function displayDashboardStats(
  employeeCount,
  roleCount,
  studentCount,
  subscriptionCount
) {
  document.getElementById("roleCard").innerHTML = `
    <p class="font-normal text-gray-700 dark:text-gray-400">Roles</p>
    <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${roleCount}</h5>
  `;

  document.getElementById("studentCard").innerHTML = `
    <p class="font-normal text-gray-700 dark:text-gray-400">Subscribers</p>
    <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${studentCount}</h5>
  `;

  document.getElementById("employeeCard").innerHTML = `
    <p class="font-normal text-gray-700 dark:text-gray-400">Employees</p>
    <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${employeeCount}</h5>
  `;

  document.getElementById("subscriptionCard").innerHTML = `
    <p class="font-normal text-gray-700 dark:text-gray-400">Subscriptions</p>
    <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${subscriptionCount}</h5>
  `;
}

// Utility Functions
function showSkeleton(card) {
  card.innerHTML = `
    <div role="status" class="max-w-sm animate-pulse">
        <div class="h-3 bg-gray-200 rounded-md dark:bg-gray-700 w-24 mb-2"></div>
        <div class="h-8 bg-gray-200 rounded-md dark:bg-gray-700 w-16 mb-2"></div>
        <span class="sr-only">Loading...</span>
    </div>`;
}

function showError(card, message) {
  card.innerHTML = `<p class="text-center text-gray-400">${message}</p>`;
}

// Fetch stats when the page loads
document.addEventListener("DOMContentLoaded", fetchDashboardStats);

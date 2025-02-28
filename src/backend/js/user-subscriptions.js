async function fetchSubscribers() {
  let tableBody = document.getElementById("user-subscriptionsTableBody");

  // Show the spinner inside the table body
  tableBody.innerHTML = `
              <tr>
                  <td colspan="4" class="text-center py-4">
                      <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                      </svg>
                      <span class="block text-gray-600 mt-2 font-semibold">Fetching user subscriptions...</span>
                  </td>
              </tr>
          `;
  try {
    let response = await fetch("backend/fetch-user-subscriptions.php");
    let result = await response.json();

    if (result.status === "success") {
      displayUserSubscriptions(result.data); // Pass the correct data
    } else {
      console.error("Error:", result.message);
      tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">${result.message}</td></tr>`;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">${error.message}</td></tr>`; // Corrected error handling
  }
}

// Function to display employees in the table
function displayUserSubscriptions(subscriptions) {
  let tableBody = document.getElementById("user-subscriptionsTableBody");

  if (!subscriptions || subscriptions.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">No subscriptions found</td></tr>`;
    return;
  }

  let rows = subscriptions
    .map((subscription, index) => {
      let modalId = `edit-modal-${index}`; // Unique modal ID
      return `
          <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
            <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">${subscription.subscriber}</th>
            <td class="px-6 py-2">${subscription.product}</td>
            <td class="px-6 py-2">${subscription.duration}</td>
            <td class="px-6 py-2">${subscription.date_subscribed}</td>
            <td class="px-6 py-2">${subscription.days_left}</td>
            <td class="px-6 py-2">
                <!-- Modal toggle -->
                <button data-modal-target="${modalId}" class="open-modal block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                Manage
                </button>
  
                <!-- Main modal -->
                <div id="${modalId}" class="modal hidden fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-lg shadow-md w-96">
                        <div class="flex justify-between items-center border-b pb-2">
                            <h3 class="text-xl font-semibold">Manage Subscription</h3>
                            <button class="close-modal text-gray-500 text-2xl">&times;</button>
                        </div>
                        <div class="mt-3">
                            <p>Subscriber: <strong>${subscription.subscriber}</strong></p>
                            <p>Product: <strong>${subscription.product}</strong></p>
                            <p>Duration: <strong>${subscription.duration}</strong></p>
                        </div>
                    </div>
                </div>
            </td>
          </tr>
        `;
    })
    .join("");

  tableBody.innerHTML = rows;

  // Add event listeners for modals after rendering
  document.querySelectorAll(".open-modal").forEach((button) => {
    button.addEventListener("click", function () {
      let modal = document.getElementById(
        this.getAttribute("data-modal-target")
      );
      modal.classList.remove("hidden");
    });
  });

  document.querySelectorAll(".close-modal").forEach((button) => {
    button.addEventListener("click", function () {
      this.closest(".modal").classList.add("hidden");
    });
  });
}

// Fetch roles when the page loads
document.addEventListener("DOMContentLoaded", fetchSubscribers);

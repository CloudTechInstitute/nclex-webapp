async function fetchSubscribers() {
  let tableBody = document.getElementById("subscriberTableBody");

  // Show the spinner inside the table body
  tableBody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center py-4">
                    <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="block text-gray-600 mt-2 font-semibold">Fetching subscribers...</span>
                </td>
            </tr>
        `;

  try {
    let response = await fetch("backend/fetch-subscribers.php");
    let result = await response.json();

    if (result.status === "success") {
      displaySubscribers(result.data); // Pass the correct data
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
function displaySubscribers(subscribers) {
  let tableBody = document.getElementById("subscriberTableBody");

  if (!subscribers || subscribers.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-gray-400">No subscribers found</td></tr>`;
    return;
  }

  let rows = subscribers
    .map(
      (subscriber) => `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">${
            subscriber.firstname
          }</th>
          <td class="px-6 py-2">${subscriber.lastname}</td>
          <td class="px-6 py-2">${subscriber.othernames}</td>
          <td class="px-6 py-2">${subscriber.email}</td>
          <td class="px-6 py-2">30-Day</td>
          <td class="px-6 py-2 font-bold ${
            subscriber.status === "active"
              ? "text-green-600"
              : subscriber.status === "suspended"
              ? "text-yellow-600"
              : subscriber.status === "blocked"
              ? "text-gray-600"
              : "text-red-600"
          }">
            ${subscriber.status}
          </td>
          <td class="px-6 py-2">
            <!-- Modal toggle -->
            <button data-modal-target="edit-modal-${
              subscriber.id
            }" data-modal-toggle="edit-modal-${subscriber.id}" 
              class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-1.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" 
              type="button">
              Manage
            </button>

            <!-- Main modal -->
            <div id="edit-modal-${
              subscriber.id
            }" tabindex="-1" aria-hidden="true" 
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center flex items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-900 bg-opacity-50">
              <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                      Manage ${subscriber.firstname} account
                    </h3>
                    <button type="button" class="close-modal-btn end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal-${
                      subscriber.id
                    }">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <!-- Modal body -->
                  <div class="p-4 md:p-5">
                  <form method="post" id="editSubscriberForm">
                    <input type="text" readonly name="subscriberName" id="subscriberName"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white mb-2"
                          value="${subscriber.firstname} ${
        subscriber.lastname
      }">
                    
                    <input type="hidden" name="subscriberID" id="subscriberID" value="${
                      subscriber.id
                    }">

                    <input type="text" readonly name="subscriberEmail" id="subscriberEmail"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white mb-2"
                          value="${subscriber.email}">
                    
                    <input type="text" readonly name="subscriberStatus" id="subscriberStatus"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white mb-2"
                        value="${subscriber.status}">

                    ${
                      subscriber.status === "suspended"
                        ? `
                      <button type="submit" class="restore-btn w-full mt-4 text-white bg-blue-600 dark:bg-green-600 font-medium rounded-lg text-sm px-5 py-2.5">
                        Restore Account
                      </button>`
                        : `
                      <button type="submit" class="suspend-btn w-full mt-4 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Suspend Account
                      </button>`
                    }     
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      `
    )
    .join("");

  tableBody.innerHTML = rows;

  // Add event listeners for opening and closing modals
  document.querySelectorAll("[data-modal-toggle]").forEach((button) => {
    button.addEventListener("click", function () {
      let modalId = this.getAttribute("data-modal-target");
      let modal = document.getElementById(modalId);
      if (modal) modal.classList.remove("hidden");
    });
  });

  document.querySelectorAll(".close-modal-btn").forEach((button) => {
    button.addEventListener("click", function () {
      let modalId = this.getAttribute("data-modal-hide");
      let modal = document.getElementById(modalId);
      if (modal) modal.classList.add("hidden");
    });
  });
}

// Fetch roles when the page loads
document.addEventListener("DOMContentLoaded", fetchSubscribers);

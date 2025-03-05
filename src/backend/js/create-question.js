document
  .getElementById("QuestionForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);

    let toastMessage = "";
    let toastType = "";

    try {
      let response = await fetch("backend/create-questions.php", {
        method: "POST",
        body: formData,
      });

      let result;
      if (response.ok) {
        result = await response.json();
        toastMessage = result.message;
        toastType = "success";

        this.reset();
      } else {
        throw new Error("Unable to create question. Please try again.");
      }
    } catch (error) {
      console.error("Error:", error);
      toastMessage = "Unable to create question. Please try again.";
      toastType = "error";
    }

    // Close the modal
    let modal = document.getElementById("Question-modal");
    if (modal) {
      modal.classList.add("hidden");
      modal.setAttribute("aria-hidden", "true"); // Accessibility
    }

    // Simulate clicking the toggle button (if available)
    let modalToggle = document.querySelector(
      "[data-modal-toggle='Question-modal']"
    );
    if (modalToggle) {
      modalToggle.click();
    }

    // Remove backdrop if still present
    let backdrop = document.querySelector(
      ".fixed.inset-0.bg-black.bg-opacity-50"
    );
    if (backdrop) {
      backdrop.remove();
    }

    // Restore scrolling to the body
    document.body.classList.remove("overflow-hidden");

    // Create toast notification dynamically
    let toast = document.createElement("div");
    toast.className =
      "flex items-center w-full max-w-sm p-4 mb-4 text-gray-500 bg-gray-100 rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-700 fixed top-5 left-1/2 -translate-x-1/2";

    let iconColor =
      toastType === "success"
        ? "text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
        : "text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200";

    toast.innerHTML = `
      <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${iconColor}">
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
          </svg>
      </div>
      <div class="ms-3 text-sm font-normal">${toastMessage}</div>
      <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
          onclick="this.parentElement.remove()">
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
      </button>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.remove();
    }, 3000);
  });

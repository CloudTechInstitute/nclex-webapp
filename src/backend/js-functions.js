document
  .getElementById("roleForm")
  .addEventListener("submit", async function (e) {
    e.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);
    let toastMessage = "";
    let toastType = "";

    try {
      let response = await fetch("backend/roles.php", {
        method: "POST",
        body: formData,
      });

      let result = await response.json();
      if (response.ok && result.status === "success") {
        toastMessage = result.message;
        toastType = "success";
        this.reset();
        fetchRoles(); // Refresh roles list
      } else {
        throw new Error(
          result.message || "Unable to create Role. Please try again."
        );
      }
    } catch (error) {
      console.error("Error:", error);
      toastMessage =
        error.message || "Unable to create Role. Please try again.";
      toastType = "error";
    }

    closeModal("role-modal"); // Close modal
    showToast(toastMessage, toastType);
  });

async function fetchRoles() {
  let tableBody = document.getElementById("rolesTableBody");
  tableBody.innerHTML = `
      <tr>
          <td colspan="4" class="text-center py-4">
              <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M100 50.59C100 78.205 77.614 100.59 50 100.59C22.386 100.59 0 78.205 0 50.59C0 22.976 22.386 0.59 50 0.59C77.614 0.59 100 22.976 100 50.59Z" fill="currentColor"/>
                  <path d="M93.968 39.04C96.393 38.404 97.862 35.912 97.008 33.554C95.293 28.823 92.871 24.369 89.817 20.348C85.845 15.119 80.883 10.724 75.212 7.413C69.542 4.102 63.275 1.94 56.77 1.051C51.767 0.368 46.698 0.447 41.734 1.279C39.261 1.693 37.813 4.198 38.45 6.623C39.087 9.049 41.569 10.472 44.051 10.107C47.851 9.549 51.719 9.527 55.54 10.049C60.864 10.777 65.993 12.546 70.633 15.255C75.274 17.965 79.335 21.562 82.585 25.841C84.918 28.912 86.8 32.291 88.181 35.876C89.083 38.216 91.542 39.678 93.968 39.04Z" fill="currentFill"/>
              </svg>
              <span class="block text-gray-600 mt-2 font-semibold">Fetching roles...</span>
          </td>
      </tr>
  `;

  try {
    let response = await fetch("backend/fetch-roles.php");
    let result = await response.json();

    if (result.status === "success" && Array.isArray(result.data)) {
      displayRoles(result.data);
    } else {
      tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">${
        result.message || "No roles found."
      }</td></tr>`;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">Failed to load roles.</td></tr>`;
  }
}

async function deleteRole(roleId) {
  if (!confirm("Are you sure you want to delete this role?")) return;

  try {
    let response = await fetch("backend/delete_role.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: roleId }),
    });

    let result = await response.json();
    if (result.status === "success") {
      document.getElementById(`role-${roleId}`).remove();
      showToast("Role deleted successfully!", "success");
    } else {
      showToast("Error deleting role: " + result.message, "error");
    }
  } catch (error) {
    console.error("Error:", error);
    showToast("Failed to delete role.", "error");
  }
}

function displayRoles(roles) {
  let tableBody = document.getElementById("rolesTableBody");
  let roleSelect = document.getElementById("employeeRole");

  tableBody.innerHTML = roles
    .map(
      (role) => `
      <tr id="role-${
        role.id
      }" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
          <th class="px-6 py-2 font-medium text-gray-900 dark:text-white">${
            role.role
          }</th>
          <td class="px-6 py-2">${role.date}</td>
          <td class="px-6 py-2 font-bold ${
            role.status === "active" ? "text-green-600" : "text-red-600"
          }">${role.status}</td>
          <td class="px-6 py-2">
              
              <button class="px-3 py-1 text-yellow-600 hover:underline" onclick="editRole('${
                role.id
              }')">Edit</button>
              <button class="px-3 py-1 text-red-600 hover:underline" onclick="deleteRole('${
                role.id
              }')">Delete</button>
          </td>
      </tr>
  `
    )
    .join("");

  roleSelect.innerHTML =
    `<option selected hidden disabled>Select category</option>` +
    roles
      .map((role) => `<option value="${role.role}">${role.role}</option>`)
      .join("");
}

function closeModal(modalId) {
  let modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("hidden");
    modal.setAttribute("aria-hidden", "true");
    document.body.classList.remove("overflow-hidden");
  }
}

function showToast(message, type) {
  let toast = document.createElement("div");
  toast.className = `fixed top-5 left-1/2 -translate-x-1/2 p-4 rounded-lg shadow-lg ${
    type === "success" ? "bg-green-600 text-white" : "bg-red-600 text-white"
  }`;
  toast.textContent = message;
  document.body.appendChild(toast);
  setTimeout(() => toast.remove(), 3000);
}

document.addEventListener("DOMContentLoaded", fetchRoles);

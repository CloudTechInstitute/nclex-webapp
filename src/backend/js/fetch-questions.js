async function fetchQuestion() {
  let tableBody = document.getElementById("questionsTableBody");

  // Show the spinner inside the table body
  tableBody.innerHTML = `
          <tr>
              <td colspan="4" class="text-center py-4">
                  <svg aria-hidden="true" class="w-8 h-8 mx-auto text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                      <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                  </svg>
                  <span class="block text-gray-600 mt-2 font-semibold">Fetching Questions...</span>
              </td>
          </tr>
      `;

  try {
    let response = await fetch("backend/fetch-questions.php");
    let result = await response.json();

    // console.log("API Response:", result);

    if (result.status === "success") {
      displayQuestions(result.data); // Pass the correct data
    } else {
      console.error("Error:", result.message);
      tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">${result.message}</td></tr>`;
    }
  } catch (error) {
    console.error("Fetch error:", error);
    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">${error.message}</td></tr>`; // Corrected error handling
  }
}

async function deleteQuestion(questionId) {
  if (!confirm("Are you sure you want to delete this role?")) return;

  try {
    let response = await fetch("backend/delete_question.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: questionId }),
    });

    let result = await response.json();
    if (result.status === "success") {
      document.getElementById(`role-${questionId}`).remove();
      showToast("Role deleted successfully!", "success");
    } else {
      showToast("Error deleting role: " + result.message, "error");
    }
  } catch (error) {
    console.error("Error:", error);
    showToast("Failed to delete role.", "error");
  }
}
// Function to display Questions in the table
function displayQuestions(questions) {
  let tableBody = document.getElementById("questionsTableBody");
  if (!questions || questions.length === 0) {
    tableBody.innerHTML = `<tr><td colspan="4" class="text-center text-gray-400">No questions found</td></tr>`;
    return;
  }

  // Get the current page filename without query parameters
  const currentPage = window.location.pathname.split("/").pop().split("?")[0];

  // Apply slice only if on index.php
  let questionsData =
    currentPage === "index.php" ? questions.slice(0, 5) : questions;

  let rows = questionsData
    .map((question) => {
      // Escape all strings to prevent JS injection and syntax errors
      const id = question.id;
      const questionText = question.question.replace(/'/g, "\\'");
      const category = question.category.replace(/'/g, "\\'");
      const type = question.type;
      const mark = question.mark_allocated;
      const solution = question.solution.replace(/'/g, "\\'");
      const options = JSON.stringify(question.options).replace(/'/g, "\\'");

      return `
      <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-200 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
          <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">${questionText}</th>
          <td class="px-6 py-2">${category}</td>
          <td class="px-6 py-2">${type}</td>
          <td class="px-6 py-2">${mark}</td>
          <td class="px-6 py-2 flex gap-2">
              <button class="px-3 py-1 bg-red-500 rounded-md text-white" onclick="deleteQuestion('${id}')">Delete</button>
              <a href="edit-question.php?id=${id}" class="px-3 py-1 bg-green-600 rounded-md text-white text-center inline-block">Edit</a>          </td>
      </tr>
      `;
    })
    .join("");

  tableBody.innerHTML = rows;
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

function populateModal(id, question, category, type, marks, solution, options) {
  console.log("populateModal called with:", {
    id,
    question,
    category,
    type,
    marks,
    solution,
    options,
  });
  document.querySelector("#editQuestionForm input[name='questionId']").value =
    id;
  document.querySelector("#editQuestionForm textarea[name='question']").value =
    question;
  document.querySelector(
    "#editQuestionForm select[name='questionCategory']"
  ).value = category;
  document.querySelector(
    "#editQuestionForm select[name='questionType']"
  ).value = type;
  document.querySelector(
    "#editQuestionForm input[name='questionMarks']"
  ).value = marks;
  document.querySelector(
    "#editQuestionForm textarea[name='questionSolution']"
  ).value = solution;

  // Populate the options
  const optionInputs = document.querySelectorAll(
    "#editQuestionForm input[name='options']"
  );
  optionInputs.forEach((input, index) => {
    input.value = options[index] || ""; // Fills existing options, leaves others empty
  });
}

// Fetch roles when the page loads
document.addEventListener("DOMContentLoaded", fetchQuestion);

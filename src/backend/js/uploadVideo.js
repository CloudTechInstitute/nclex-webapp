document
  .getElementById("uploadVideoForm")
  ?.addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let progressContainer = document.getElementById("progressContainer");
    let progressBar = document.getElementById("uploadProgress");

    // Show progress bar only when upload starts
    progressContainer.classList.remove("hidden");
    progressBar.style.width = "0%";
    progressBar.textContent = "0%";

    try {
      let response = await fetch("backend/uploadVideo.php", {
        method: "POST",
        body: formData,
      });

      let result = await response.json();

      if (response.ok) {
        progressBar.style.width = "100%";
        progressBar.textContent = "Upload Complete!";
        showToast("Video uploaded successfully!", "success");
        this.reset();
        setTimeout(() => {
          progressContainer.classList.add("hidden"); // Hide after upload
        }, 2000);
      } else {
        throw new Error("Upload failed!");
      }
    } catch (error) {
      console.error("Error:", error);
      showToast("Upload failed. Try again.", "error");
      progressContainer.classList.add("hidden"); // Hide progress bar on error
    }
  });

async function fetchWithProgress(url, formData, progressBar) {
  const request = new Request(url, {
    method: "POST",
    body: formData,
  });

  const response = await fetch(request);

  if (!response.body) throw new Error("No response body detected.");

  const reader = response.body.getReader();
  const contentLength = +response.headers.get("Content-Length") || 0;
  let receivedLength = 0;
  let chunks = [];

  while (true) {
    const { done, value } = await reader.read();
    if (done) break;
    chunks.push(value);
    receivedLength += value.length;

    if (contentLength) {
      let progress = Math.round((receivedLength / contentLength) * 100);
      progressBar.style.width = `${progress}%`;
      progressBar.textContent = `${progress}%`; // Update progress text
    }
  }

  const blob = new Blob(chunks);
  return new Response(blob, response);
}

function showToast(message, type) {
  let toast = document.createElement("div");
  toast.className =
    "flex items-center w-full max-w-sm p-4 mb-4 text-gray-500 bg-gray-100 rounded-lg shadow-lg dark:text-gray-400 dark:bg-gray-700 fixed top-5 left-1/2 -translate-x-1/2";

  let iconColor =
    type === "success"
      ? "text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200"
      : "text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200";

  toast.innerHTML = `
        <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 ${iconColor}">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
            </svg>
        </div>
        <div class="ms-3 text-sm font-normal">${message}</div>
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
}

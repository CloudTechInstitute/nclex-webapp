async function fetchContentStats() {
  let videoCard = document.getElementById("videoCard");
  let questionCard = document.getElementById("questionCard");
  let audioCard = document.getElementById("audioCard");
  let ebookCard = document.getElementById("ebookCard");

  // Show skeleton loaders
  [videoCard, questionCard, audioCard, ebookCard].forEach(showSkeleton);

  try {
    let response = await fetch("backend/content-fetch-scripts.php");
    if (!response.ok) throw new Error("Network response was not ok");

    let result = await response.json();

    if (result.status === "success") {
      displayDashboardStats(
        result.audio_count || 0,
        result.video_count || 0,
        result.question_count || 0,
        result.ebook_count || 0
      );
    } else {
      console.error("Error:", result.message);
      showError(videoCard, result.message);
      showError(questionCard, result.message);
      showError(audioCard, result.message);
      showError(ebookCard, result.message);
    }
  } catch (error) {
    console.error("Fetch error:", error);
    let errorMsg = "Failed to load data. Please try again later.";
    showError(videoCard, errorMsg);
    showError(questionCard, errorMsg);
    showError(audioCard, errorMsg);
    showError(ebookCard, errorMsg);
  }
}

function displayDashboardStats(
  audioCount,
  videoCount,
  questionCount,
  ebookCount
) {
  document.getElementById("videoCard").innerHTML = `
      <p class="font-normal text-gray-700 dark:text-gray-400">Videos</p>
      <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${videoCount}</h5>
    `;

  document.getElementById("questionCard").innerHTML = `
      <p class="font-normal text-gray-700 dark:text-gray-400">Questions</p>
      <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${questionCount}</h5>
    `;

  document.getElementById("audioCard").innerHTML = `
      <p class="font-normal text-gray-700 dark:text-gray-400">Audio</p>
      <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${audioCount}</h5>
    `;

  document.getElementById("ebookCard").innerHTML = `
      <p class="font-normal text-gray-700 dark:text-gray-400">Ebooks</p>
      <h5 class="mb-2 text-4xl font-semibold tracking-tight text-gray-900 dark:text-white">${ebookCount}</h5>
    `;
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
document.addEventListener("DOMContentLoaded", fetchContentStats);

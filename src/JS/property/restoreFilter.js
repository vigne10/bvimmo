// Function to restore search filters
function restoreMainPageWithFilters() {
  const previousURL = document.referrer;
  window.location.href = previousURL;
}

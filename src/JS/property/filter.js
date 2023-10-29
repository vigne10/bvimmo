// Select property items
const propertyItems = document.querySelectorAll("#property-card");

// Function to update URL parameters
function updateURLParams(category, userProperty) {
  const searchParams = new URLSearchParams(window.location.search); //  Create an instance of the "URLSearchParams" object from the ? from the current URL

  if (category !== "all") {
    searchParams.set("category", category);
  } else {
    searchParams.delete("category");
  }

  if (userProperty !== "all-properties") {
    searchParams.set("user", userProperty);
  } else {
    searchParams.delete("user");
  }
  const newURL =
    window.location.pathname +
    (searchParams.toString() ? "?" + searchParams.toString() : ""); //  Create the new URL with parameters
  window.history.replaceState({}, "", newURL); //   Replace URL in browser
}

// Function to filter properties based on category and whether they belong to the user or not
function filterProperties(category, userProperty) {
  propertyItems.forEach(function (item) {
    const itemCategory = item.getAttribute("data-category");
    const itemUserProperty = item.getAttribute("data-user");

    // Show and hide properties based on parameters passed to the function
    if (
      (category === "all" || category === itemCategory) &&
      (userProperty === "all-properties" || userProperty === itemUserProperty)
    ) {
      item.style.display = "block";
    } else {
      item.style.display = "none";
    }
  });

  // Update URL parameters with selected filters
  updateURLParams(category, userProperty);
}

// Function to get currently selected filter category
function getCurrentCategoryFilter() {
  const activeCategoryButton = document.querySelector(
    "[data-category-filter].active"
  );
  return activeCategoryButton
    ? activeCategoryButton.getAttribute("data-category-filter")
    : "all";
}

// Function to get user filter
function getCurrentUserFilter() {
  const activeUserButton = document.querySelector("[data-user-filter].active");
  return activeUserButton
    ? activeUserButton.getAttribute("data-user-filter")
    : "all-properties";
}

// Function to restore filters from URL parameters on page load
function restoreFiltersFromURL() {
  const categoryFilterButtons = document.querySelectorAll(
    "[data-category-filter]"
  );
  const userFilterButtons = document.querySelectorAll("[data-user-filter]");
  const searchParams = new URLSearchParams(window.location.search);
  const category = searchParams.get("category") || "all";
  const userProperty = searchParams.get("user") || "all-properties";

  // Select filter buttons matching URL parameters
  const categoryButton = document.querySelector(
    `[data-category-filter="${category}"]`
  );
  const userButton = document.querySelector(
    `[data-user-filter="${userProperty}"]`
  );

  // Update active class of filter buttons
  categoryFilterButtons.forEach((button) => {
    button.classList.remove("active");
  });
  userFilterButtons.forEach((button) => {
    button.classList.remove("active");
  });
  categoryButton.classList.add("active");
  userButton.classList.add("active");

  // Filter properties with URL parameters
  filterProperties(category, userProperty);
}

// Code executed when the DOM is fully loaded
function onDOMContentLoaded() {
  // Select filter items
  const categoryFilterButtons = document.querySelectorAll(
    "[data-category-filter]"
  );
  const userFilterButtons = document.querySelectorAll("[data-user-filter]");

  // Add event listeners for filter buttons by category
  categoryFilterButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Remove active class from all category filter buttons
      categoryFilterButtons.forEach(function (btn) {
        btn.classList.remove("active");
      });

      // Add active class to clicked button
      this.classList.add("active");

      // Filter properties based on selected category
      const category = this.getAttribute("data-category-filter");
      filterProperties(category, getCurrentUserFilter());
    });
  });

  // Add event listeners for filter buttons by user
  userFilterButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      // Remove active class from all filter buttons by user
      userFilterButtons.forEach(function (btn) {
        btn.classList.remove("active");
      });

      // Add active class to clicked button
      this.classList.add("active");

      // Filter assets based on user filter
      const userProperty = this.getAttribute("data-user-filter");
      filterProperties(getCurrentCategoryFilter(), userProperty);
    });
  });

  restoreFiltersFromURL();
}

document.addEventListener("DOMContentLoaded", onDOMContentLoaded);

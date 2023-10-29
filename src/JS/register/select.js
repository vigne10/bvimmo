$(document).ready(function () {
  // Select country and city items
  var $countrySelect = $("#country");
  var $citySelect = $("#city");

  // Listen to the country change event
  $countrySelect.on("changed.bs.select", function () {
    var countrySelect = document.getElementById("country");
    var selectedOption = countrySelect.options[countrySelect.selectedIndex];
    var selectedCountry = selectedOption.value;

    // Browse all city options
    $citySelect.find("option").each(function (index) {
      // if (index === 0) {
      //   return;
      // }

      var cityCountry = $(this).data("country"); // Get the country associated with the city

      $(this).attr("hidden", "hidden"); // Add "hidden" attribute to all options

      // Check if the country of the city matches the selected country
      if (cityCountry === selectedCountry) {
        $(this).removeAttr("hidden"); // Remove the "hidden" attribute if the country matches
      }
    });

    $citySelect.selectpicker("refresh"); // Refresh the select cities to apply the changes
  });

  // Initialize the selectpicker
  $(".selectpicker").selectpicker();
});

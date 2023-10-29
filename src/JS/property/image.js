// Get file input element
var inputImage = document.getElementById("image");
// Get img element to display the image
var previewImage = document.getElementById("previewImage");

// Listen for the change event on the file type input
inputImage.addEventListener("change", function (event) {
  // Get selected file
  var file = event.target.files[0];

  // Get if a file has been selected
  if (file) {
    // Create an URL object for the file
    var imageURL = URL.createObjectURL(file);

    // Update image source with file URL
    previewImage.src = imageURL;
  } else {
    // If no file is selected, reset the image
    previewImage.src = "";
  }
});

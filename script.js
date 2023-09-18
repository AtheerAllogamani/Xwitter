function displayInput() {
    var inputField = document.getElementById("tweet");
    var inputValue = inputField.value;
  
    var outputList = document.getElementById("output");
    var listItem = document.createElement("li");
    listItem.appendChild(document.createTextNode(inputValue));
  
    // Move the existing list items down
    for (var i = outputList.childNodes.length - 1; i >= 0; i--) {
      outputList.insertBefore(outputList.childNodes[i], outputList.childNodes[i + 1]);
    }
  
    // Add the new item at the top
    outputList.insertBefore(listItem, outputList.firstChild);
  
    // Clear the input field
    inputField.value = "";
}

function changeProfilePic() {
    var fileInput = document.getElementById("fileInput");
    fileInput.click();
  
    fileInput.addEventListener("change", function() {
      var file = fileInput.files[0];
      var reader = new FileReader();
  
      reader.onload = function(e) {
        var profilePic = document.getElementById("profilePic");
        profilePic.src = e.target.result;
      };
  
      reader.readAsDataURL(file);
    });
  }
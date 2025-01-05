function login() {
    var keyInput = document.getElementById("keyInput").value;
    
    // You can add logic here to validate the key, make an API call, etc.
    
    if (keyInput === "NBL") {
        // Redirect to home page or API.php
        window.location.href = "nbl.php";
    } else {
        alert("Invalid key. Please try again.");
    }
}

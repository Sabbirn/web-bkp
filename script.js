document
  .getElementById("registerForm")
  .addEventListener("submit", function (event) {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm_password").value;
    if (password !== confirmPassword) {
      alert("Passwords do not match!");
      event.preventDefault();
    }
  });

function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  // Remove the toast after 5 seconds
  setTimeout(() => {
    toast.classList.remove("show");
  }, 5000);
}

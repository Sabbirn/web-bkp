<?php
// Database connection
$conn = new mysqli('localhost', 'lsvbpnax_tokenl', 'YRXw6RrV829aPZzLDeP7', 'lsvbpnax_tokenl');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password === $confirm_password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hash);

        if ($stmt->execute()) {
            $message = "Registration successful. Wait for admin approval.";
            $messageType = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $messageType = "error";
        }
        $stmt->close();
    } else {
        $message = "Passwords do not match.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register | Token System</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Toast styles */
      .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 15px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 5px;
        opacity: 0;
        transition: opacity 0.5s ease;
        z-index: 9999;
      }
      .toast.show {
        opacity: 1;
      }
      .toast.success {
        background-color: green;
      }
      .toast.error {
        background-color: red;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="form-container">
        <h2>Register</h2>
        <form id="registerForm" action="" method="POST">
          <input
            type="text"
            name="username"
            id="username"
            placeholder="Username"
            required
            style ="box-sizing: border-box"
          />
          <input
            type="email"
            name="email"
            id="email"
            placeholder="Email"
            required
            style ="box-sizing: border-box"
          />
          <input
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            required
            style ="box-sizing: border-box"
          />
          <input
            type="password"
            name="confirm_password"
            id="confirm_password"
            placeholder="Confirm Password"
            required
            style ="box-sizing: border-box"
          />
          <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login here</a></p>
      </div>
    </div>

    <!-- Toast Message -->
    <?php if (isset($message)): ?>
      <div id="toast" class="toast <?php echo $messageType; ?> show">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <script>
      // Show toast message for 5 seconds and then hide it
      setTimeout(function() {
        var toast = document.getElementById("toast");
        if (toast) {
          toast.classList.remove("show");
        }
      }, 5000);
      ///////////////////////////////////
      var bg = document.getElementById("toast").innertext;
      if(bg === "Registration successful. Wait for admin approval."){
        bg.style.backgroundColor = "green";
      }
      //////////////////////////////////
    </script>
  </body>
</html>

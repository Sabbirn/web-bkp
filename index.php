<?php
session_start();
$conn = new mysqli('localhost', 'lsvbpnax_tokenl', 'YRXw6RrV829aPZzLDeP7', 'lsvbpnax_tokenl');
$toastMessage = ''; // Default empty message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, is_approved FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash, $is_approved);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            if ($is_approved) {
                $_SESSION['user_id'] = $id;
                header('Location: dashboard.php');
                exit;
            } else {
                $toastMessage = 'Your account is awaiting admin approval.';
            }
        } else {
            $toastMessage = 'Invalid password.';
        }
    } else {
        $toastMessage = 'No user found with that username.';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* Add basic styling for the toast */
      .toast {
        visibility: hidden;
        min-width: 250px;
        margin: 0 auto;
        background-color: #f44336;
        color: white;
        text-align: center;
        border-radius: 5px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
        font-size: 17px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        opacity: 0;
        transition: opacity 0.5s, visibility 0.5s;
      }

      .toast.show {
        visibility: visible;
        opacity: 1;
      }
      .mb {
        margin: 0;
        padding: 0;
        color : gray;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="form-container">
        <h2>Login</h2>
        <form id="loginForm" action="" method="POST">
          <input
            type="text"
            name="username"
            id="username"
            placeholder="Username"
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
          <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
        <p class="mb">Contact a Developer : <a href="https://sabbirn.github.io/developer/">Contact Here</a></p>
      </div>
    </div>

    <div id="toast" class="toast"><?php echo $toastMessage; ?></div>

    <script>
      // Function to show a toast message
      function showToast(message) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.classList.add('show');
        
        // Remove the toast after 5 seconds
        setTimeout(() => {
          toast.classList.remove('show');
        }, 50000);
      }

      // Trigger the toast notification if there's a PHP message
      const toastMessage = '<?php echo addslashes($toastMessage); ?>';
      if (toastMessage) {
        showToast(toastMessage);
      }
    </script>
  </body>
</html>

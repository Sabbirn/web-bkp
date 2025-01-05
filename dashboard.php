<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Database connection (Replace with your actual DB details)
$servername = "localhost";
$username = "lsvbpnax_tokenl";
$password = "YRXw6RrV829aPZzLDeP7";
$dbname = "lsvbpnax_tokenl";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information based on session user_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user data
    $row = $result->fetch_assoc();
    $username = $row['username'];
} else {
    $username = 'User not found';
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .web {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="container mt-2">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title ">Welcome, <?php echo htmlspecialchars($username); ?> !</h1>
                <p class="card-text">This Is Your Dashboard.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="card mt-2 web">
        <p class="m-0 p-0 text-center fs-5 fw-bold text-uppercase">SMS Bomber</p>
        <iframe id="frame" src="https://sabbirn.github.io/SMB/sms.html" style="height:100vh;width:100%;" scrolling="no"></iframe>
        </div>
        <!--  -->
        <div class="card mt-2 web">
        <p class="m-0 p-0 text-center fs-5 fw-bold text-uppercase">SMS Bomber 2</p>
         <iframe id="frame" src="" style="height:100vh;width:100%;" scrolling="no"></iframe>
        </div>
        <!--  -->
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

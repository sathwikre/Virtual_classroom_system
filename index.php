<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Database Connection
$host = "localhost";
$username = "root";  // Default XAMPP username
$password = "";
$dbname = "harvad_db";  // Your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle email sending
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message']; // Get message from form

    $sql = "SELECT email FROM user";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $emails = [];
        while ($row = $result->fetch_assoc()) {
            $emails[] = $row['email'];
        }

        // Setup PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'suramsathwikreddy292@gmail.com';  // Your email
            $mail->Password = 'hrqd lgyw fnuu rlza';  // Your email app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('suramsathwikreddy292@gmail.com', 'sathwik');
            $mail->Subject = 'Notification';
            $mail->Body = $message;

            foreach ($emails as $email) {
                $mail->addAddress($email);
            }

            if ($mail->send()) {
                echo "<script>showStatus('Emails sent successfully!', 'success');</script>";
            } else {
                echo "<script>showStatus('Failed to send emails.', 'error');</script>";
            }
        } catch (Exception $e) {
            echo "<script>showStatus('Mailer Error: " . $mail->ErrorInfo . "', 'error');</script>";
        }
    } else {
        echo "<script>showStatus('No emails found in the database.', 'error');</script>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Custom Emails</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            color: white;
            margin: 50px;
        }
        .container {
            max-width: 450px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        textarea {
            width: 100%;
            height: 100px;
            border-radius: 8px;
            border: none;
            padding: 10px;
            resize: none;
            font-size: 16px;
            outline: none;
        }
        button {
            padding: 12px 25px;
            background: #ff9800;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        button:hover {
            background: #e68900;
            transform: scale(1.05);
        }
        #status {
            margin-top: 15px;
            font-size: 16px;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.5s, transform 0.5s;
        }
        .success {
            color: #4CAF50;
        }
        .error {
            color: #FF3D00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📩 Send Custom Email</h2>
        <textarea id="message" placeholder="send class link"></textarea>
        <button id="sendMailBtn">Send Email</button>
        <p id="status"></p>
    </div>

    <script>
        document.getElementById("sendMailBtn").addEventListener("click", function () {
            let message = document.getElementById("message").value;
            if (message.trim() === "") {
                alert("Please enter a message.");
                return;
            }

            let formData = new FormData();
            formData.append("message", message);

            fetch("index.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("status").innerHTML = data;
            })
            .catch(error => console.error("Error:", error));
        });

        function showStatus(message, type) {
            let statusEl = document.getElementById("status");
            statusEl.innerText = message;
            statusEl.className = type;
            statusEl.style.opacity = "1";
            statusEl.style.transform = "translateY(0px)";
            setTimeout(() => {
                statusEl.style.opacity = "0";
                statusEl.style.transform = "translateY(-10px)";
            }, 3000);
        }
    </script>
</body>
</html>

<?php
// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "harvad_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Insert data into the database
    $sql = "INSERT INTO usert(username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Registration successful! Redirecting to index page</p>";
        header("Refresh: 2; url=index.html"); // Redirect to login page after 1 second
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link rel="icon" href="loder.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            overflow: hidden;
            animation: backgroundAnimation 10s infinite alternate ease-in-out;
        }

        @keyframes backgroundAnimation {
            0% {
                background: linear-gradient(135deg, #1e3c72, #2a5298);
            }
            50% {
                background: linear-gradient(135deg, #2a5298, #1e3c72);
            }
            100% {
                background: linear-gradient(135deg, #1e3c72, #2a5298);
            }
        }

        .signup-container {
            text-align: center;
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            animation: fadeIn 2s ease-out, floatEffect 4s infinite alternate ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatEffect {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(10px);
            }
        }

        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        form input, form button {
            width: 100%;
            padding: 14px;
            margin: 12px 0;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s ease, background-color 0.3s ease;
        }

        form input:focus, form button:focus {
            outline: none;
            border-color: #2a5298;
        }

        form input {
            background-color: #f9f9f9;
        }

        form button {
            background-color: #1e90ff;
            color: white;
            cursor: pointer;
            border: none;
            transition: transform 0.3s ease-in-out;
            animation: pulse 1.5s infinite;
        }

        form button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Add Teacher</h2>
        <form action="#" method="post">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Add</button>
        </form>
    </div>
</body>
</html>

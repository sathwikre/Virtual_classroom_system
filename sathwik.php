<?php
// Temporarily increase PHP limits
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('memory_limit', '128M');

// Database connection
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "harvad_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdf_file"])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // Read the PDF file
    $pdf_file = file_get_contents($_FILES["pdf_file"]["tmp_name"]);

    // Insert into database using prepared statements
    $sql = "INSERT INTO material (name, description, pdf_file) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $description, $pdf_file);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>New record created successfully</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Materials</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #d4fc79, #96e6a1);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
            animation: backgroundAnimation 10s infinite alternate;
        }
        @keyframes backgroundAnimation {
            0% {
                background: linear-gradient(to bottom right, #d4fc79, #96e6a1);
            }
            100% {
                background: linear-gradient(to bottom right, #84fab0, #8fd3f4);
            }
        }
        .form-container {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            width: 90%;
            max-width: 400px;
            animation: fadeIn 2s ease;
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
        h2 {
            margin-bottom: 20px;
            font-size: 2em;
            color: #333;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 30px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus,
        input[type="file"]:focus {
            border-color: #57c4ad;
            box-shadow: 0 0 10px rgba(87, 196, 173, 0.5);
        }
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background: #57c4ad;
            border: none;
            border-radius: 30px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        input[type="submit"]:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Insert Material</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Material Name" required>
            <input type="text" name="description" placeholder="Description" required>
            <input type="file" name="pdf_file" accept="application/pdf" required>
            <input type="submit" value="Insert">
        </form>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
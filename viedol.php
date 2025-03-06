<?php
// PHP code for handling file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "harvad_db";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle file upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create uploads directory if not exists
    }

    $video_name = basename($_FILES["video"]["name"]);
    $video_path = $target_dir . $video_name;
    $videoFileType = strtolower(pathinfo($video_path, PATHINFO_EXTENSION));

    // Check for file upload errors
    if ($_FILES["video"]["error"] !== 0) {
        die("File upload error: " . $_FILES["video"]["error"]);
    }

    // Allow only specific video formats
    $allowed_types = ["mp4", "avi", "mov", "mkv"];
    if (!in_array($videoFileType, $allowed_types)) {
        die("Error: Only MP4, AVI, MOV, and MKV files are allowed.");
    }

    // Check if file already exists
    if (file_exists($video_path)) {
        die("Error: File already exists.");
    }

    // Move uploaded file
    if (move_uploaded_file($_FILES["video"]["tmp_name"], $video_path)) {
        // Insert video details into database using prepared statement
        $sql = "INSERT INTO videoslc (video_name, video_path) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $video_name, $video_path);

        if ($stmt->execute()) {
            $success_message = "✅ The file <b>" . htmlspecialchars($video_name) . "</b> has been uploaded.";
        } else {
            $error_message = "Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error_message = "❌ Error: Unable to upload file.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Video</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            text-align: center;
            padding: 20px;
            animation: fadeIn 1.5s ease-in-out;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: inline-block;
            animation: slideUp 1s ease-in-out;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* File Upload */
        input[type="file"] {
            display: none;
        }

        .file-upload-label {
            background-color: #ff6f61;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
            display: inline-block;
            margin-bottom: 15px;
        }

        .file-upload-label:hover {
            background-color: #ff3b2f;
            transform: scale(1.05);
        }

        /* Upload Button */
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Message Styles */
        .message {
            margin-top: 15px;
            font-size: 1rem;
            font-weight: bold;
        }

        .success {
            color: #0f0;
            animation: fadeIn 1s ease-in-out;
        }

        .error {
            color: #f00;
            animation: fadeIn 1s ease-in-out;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎥 Upload Your Video</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="video" class="file-upload-label">📁 Choose Video</label>
            <input type="file" name="video" id="video" accept="video/*" required>
            <br>
            <button type="submit" name="submit">🚀 Upload Video</button>
        </form>

        <?php
        // Display success or error messages
        if (isset($success_message)) {
            echo "<p class='message success'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p class='message error'>$error_message</p>";
        }
        ?>
    </div>
</body>
</html>

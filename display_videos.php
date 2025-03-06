<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "harvad_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all uploaded videos
$sql = "SELECT video_name, video_path FROM videoslc ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Videos</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            text-align: center;
            padding: 20px;
            color: white;
            animation: fadeIn 1.5s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
        }

        /* Video Container */
        .video-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .video-box {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            animation: fadeUp 1s ease-in-out;
        }

        .video-box:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        video {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <h1>🎥 Uploaded Videos</h1>

    <div class="video-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='video-box'>";
                echo "<h3>" . htmlspecialchars($row['video_name']) . "</h3>";
                echo "<video controls>
                        <source src='" . htmlspecialchars($row['video_path']) . "' type='video/mp4'>
                        Your browser does not support the video tag.
                      </video>";
                echo "</div>";
            }
        } else {
            echo "<p>No videos uploaded yet.</p>";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>

<?php
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

// Step 3: Retrieve and Display PDF
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the PDF file from the database
    $sql = "SELECT pdf_file FROM materials WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pdf_file = $row['pdf_file'];

        // Output the PDF file
        header("Content-type: application/pdf");
        echo $pdf_file;
        exit; // Stop further execution
    } else {
        echo "PDF not found.";
        exit;
    }
}

// Step 4: Display List of Materials with Links
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Study Materials</title>
    <link rel="icon" href="loder.png">
    <style>
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
        .container {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            width: 90%;
            max-width: 500px;
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
        h1 {
            margin-bottom: 20px;
            font-size: 2.5em;
            color: #ffffff;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 15px 0;
        }
        a {
            text-decoration: none;
            color: #fff;
            background: #57c4ad;
            padding: 12px 25px;
            border-radius: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            display: inline-block;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        a:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Study Materials</h1>
        <ul id="materials-list">
            <?php
            // Fetch all materials from the database
            $sql = "SELECT id, name FROM materials";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li><a href='view_pdf.php?id=" . $row['id'] . "' target='_blank'>" . $row['name'] . "</a></li>";
                }
            } else {
                echo "<li>No materials found.</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
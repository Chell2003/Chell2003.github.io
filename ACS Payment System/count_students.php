<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "acs_db";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Count the number of students
$sql = "SELECT COUNT(*) as studentCount FROM clients";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Fetch the result
$row = $result->fetch_assoc();
$studentCount = $row['studentCount'];

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Count</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            text-align: center;
        }

        .student-count-container {
            max-width: 400px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-height: 200px;
            border-left-style: solid;
            border-color: darkred;
            
        }

        h2{
            font-size: 24px;
            color: #333;
        }

        h1 {
            font-size: 80px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="student-count-container">
        <h2>Number of students:</h2>
        <h1><?php echo $studentCount; ?></h1>
    </div>
</body>
</html>

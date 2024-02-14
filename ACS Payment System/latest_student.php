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

// Fetch the details of the most recently added student
$sql = "SELECT * FROM clients ORDER BY id DESC LIMIT 1";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Check if there is a result
if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    
    // Close the connection
    $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Added Student</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            text-align: left;
        }

        .student-details-container {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: left;
            margin-bottom: 10px;
            border-left-style: solid;
            border-color: darkred;
        }

        h2 {
            font-size: 24px;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="student-details-container">
        <h2>Latest Added Student</h2>
        <p>Student Number:<b> <?php echo $row['Student_Num']; ?></b></p>
        <p>Student Name:<b> <?php echo $row['name']; ?></b></p>
        <p>Email:<b> <?php echo $row['email']; ?></b></p>
        <p>Phone Number:<b> <?php echo $row['phone']; ?></b></p>
        <p>Year and Section:<b> <?php echo $row['yearandsection']; ?></b></p>
    </div>
</body>
</html>

<?php
} else {
    echo "No students found.";
}
?>

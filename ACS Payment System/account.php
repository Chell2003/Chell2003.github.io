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
$sql = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Check if there is a result
if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
}
    // Close the connection
    $connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border-left-style: solid;
            border-color: darkred;
        }

        .container h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .container p {
            margin-bottom: 0;
        }

        @media screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                box-sizing: border-box;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome back, <?php echo $row['name']; ?>!</h1>
        <p><?php echo $row['email']; ?></p>
    </div>
</body>
</html>


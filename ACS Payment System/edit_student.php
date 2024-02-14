<?php
include 'index.php';

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

$id = $_GET['id'];

// Fetch the existing data of the student
$sql = "SELECT * FROM clients WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Student not found";
    exit;
}

$row = $result->fetch_assoc();

// Handle form submission for updating student information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Student_Num = $_POST["Student_Num"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $yearandsection = $_POST["yearandsection"];

    // Update student information in the database
    $updateSql = "UPDATE clients SET Student_Num = ?, name = ?, email = ?, phone = ?, yearandsection = ? WHERE id = ?";
    $updateStmt = $connection->prepare($updateSql);
    $updateStmt->bind_param("issssi", $Student_Num, $name, $email, $phone, $yearandsection, $id);
    $updateStmt->execute();

    // Redirect to the student list page after updating
    header("Location: student.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 600px;
            margin-top: 50px;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group input {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            width: calc(100% - 5px);
            display: inline-block;
            box-sizing: border-box;
        }

        button {
            background-color: #337ab7;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2c6699;
        }

        a {
            display: inline-block;
            background-color: #ddd;
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 10px;
        }

        .btn-cancel {
            display: inline-block;
            background-color: #ddd;
            color: #333;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 3px;
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Student</h2>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <!-- Add other form fields for editing student information -->
            <div class="input-group">
                <label for="Student_Num">Student Number:</label>
                <input type="text" name="Student_Num" autocomplete="off" value="<?php echo $row['Student_Num']; ?>">
            </div>

            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" name="name" autocomplete="off" value="<?php echo $row['name']; ?>">
            </div>

            <div class="input-group">
                <label for="email">Email:</label>
                <input type="text" name="email" autocomplete="off" value="<?php echo $row['email']; ?>">
            </div>

            <div class="input-group">
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>">
            </div>

            <div class="input-group">
                <label for="yearandsection">Year and Section:</label>
                <input type="text" name="yearandsection" value="<?php echo $row['yearandsection']; ?>">
            </div>

            <!-- Add the submit button and cancel link -->
            <div>
                <button type="submit">Update</button>
                <a class="btn-cancel" href="student.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>

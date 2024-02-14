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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the expected keys exist in the $_POST array
    if (isset($_POST['student_id'], $_POST['amount_paid'], $_POST['payment_date'])) {
        // Get values from the form
        $student_id = $_POST['student_id'];
        $amount_paid = $_POST['amount_paid'];
        $payment_date = $_POST['payment_date'];

        // Validate and sanitize input if needed
        $student_id = mysqli_real_escape_string($connection, $student_id);
        $amount_paid = mysqli_real_escape_string($connection, $amount_paid);
        $payment_date = mysqli_real_escape_string($connection, $payment_date);

        // Insert payment into the payments table
        $sql = "INSERT INTO payments (student_id, amount_paid, payment_date) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ids", $student_id, $amount_paid, $payment_date);

        if ($stmt->execute()) {
            header('Location: success_message.php');
            exit();
        } else {
            echo "Error adding payment: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Form data is not complete.";
    }
} else {
    echo "Invalid request.";
}

$connection->close();
?>

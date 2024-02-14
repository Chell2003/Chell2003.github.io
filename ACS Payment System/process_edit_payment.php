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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form data is set
    if (isset($_POST['payment_id'], $_POST['amount_paid'], $_POST['payment_date'])) {
        $payment_id = $_POST['payment_id'];
        $amount_paid = $_POST['amount_paid'];
        $payment_date = $_POST['payment_date'];

        // Update payment in the database
        $sql = "UPDATE payments SET amount_paid = ?, payment_date = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("dsi", $amount_paid, $payment_date, $payment_id);

        if ($stmt->execute()) {
            header("Location: payment.php"); // Redirect back to the payment list page
            exit();
        } else {
            echo "Error updating payment: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid form data.";
    }
} else {
    echo "Invalid request method.";
}

$connection->close();
?>

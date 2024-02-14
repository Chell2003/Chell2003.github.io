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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if 'id' parameter is set in the URL
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $payment_id = $_GET['id'];

        // Delete payment from the database
        $sql = "DELETE FROM payments WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $payment_id);

        if ($stmt->execute()) {
            header("Location: payment.php"); // Redirect back to the payment list page
            exit();
        } else {
            echo "Error deleting payment: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid request.";
    }
}

$connection->close();
?>

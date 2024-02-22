<?php
include 'index.php';  // Include necessary dependencies if needed
$servername = "localhost";
$username = "id21910875_jelixces10";
$password = "Jelixces-10";
$database = "id21910875_acs_db";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch students who do not have a payment entry
$sql = "SELECT clients.id, clients.name FROM clients
        LEFT JOIN payments ON clients.id = payments.student_id
        WHERE payments.id IS NULL";

$result = $connection->query($sql);

// Close the connection
$connection->close();
?>

<!-- HTML and Form for Adding Payment -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/add_payment.css">
    <title>Add Payment</title>
</head>
<body>
    <div class="modal-container">
        <h2>Add Payment</h2>
        <form action="process_payment.php" method="post">
            <label for="student_id">Student Name:</label>
            <select name="student_id" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                    }
                }
                ?>
            </select>

            <label for="amount_paid">Amount Paid:</label>
            <input type="number" name="amount_paid" step="0.01" required>

            <label for="payment_date">Payment Date:</label>
            <input type="date" name="payment_date" required>

            <button type="submit">Add Payment</button>
        </form>
    </div>
</body>
</html>

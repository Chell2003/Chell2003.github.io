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

// Check if 'id' parameter is set in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Fetch payment details from the database
    $sql = "SELECT * FROM payments WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
        

        // Include the edit payment form
        include 'index.php';
        include 'contentpage.css';
        
        echo "
        <div class='page-content'>
            <div class='titles'>
                <h2>Edit Payment</h2>
            </div>
            <div id='EDIT_PAYMENT' class='tabcontent'>
                <div class='edit_payment_form'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <form action='process_edit_payment.php' method='post'>
                                <input type='hidden' name='payment_id' value='{$payment['id']}'>
                
                                <label for='amount_paid'>Amount Paid:</label>
                                <input type='number' name='amount_paid' value='{$payment['amount_paid']}' step='0.01' required>
                
                                <label for='payment_date'>Payment Date:</label>
                                <input type='date' name='payment_date' value='{$payment['payment_date']}' required>
                
                                <button type='submit'>Update Payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>";
    } else {
        echo "Payment not found.";
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

$connection->close();
?>
<link rel="stylesheet" type="text/css" href="style/edit_payment.css">
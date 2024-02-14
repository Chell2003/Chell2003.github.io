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

$payment_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($payment_id) {
    $sql = "SELECT clients.name as student_name, clients.Student_Num as student_number, payments.amount_paid, payments.payment_date
            FROM payments
            INNER JOIN clients ON payments.student_id = clients.id
            WHERE payments.id = $payment_id";

    $result = $connection->query($sql);

    if ($result && $result->num_rows > 0) {
        $paymentDetails = $result->fetch_assoc();
    } else {
        echo "<p>Error: Payment details not found.</p>";
        exit();
    }
} else {
    echo "<p>Error: Payment ID not provided.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .receipt-container {
            max-width: 148mm; /* A4 width */
            max-height: 210mm; /* A4 height */
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .header {
            color: black;
            padding: 10mm;
            text-align: center;
            border-top: 1px solid #ccc;
        }

        .receipt-details {
            padding: 10mm;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5mm;
        }

        .footer {
            color: black;
            padding: 3mm;
            text-align: center;
        }

        .signature-area {
            margin-top: 5mm;
            margin-bottom: 5mm;
            border-top: 1px solid #ccc;
            padding-top: 5mm;
            text-align: center;
        }

        .signature-label {
            font-weight: bold;
            font-size: 12px;
        }

        .logo img {
            width: 25mm;
        }

        .logo {
            text-align: center;
            padding-top: 5mm;
        }

        .logo h1 {
            font-size: 16px;
        }

        h2 {
            font-size: 18px;
        }

        strong {
            font-size: 14px;
        }

        p {
            font-size: 14px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="receipt-container">
        <div class="logo">
            <img src="style/img/logo2.png" alt="ACS Logo">
            <h1>ALLIANCE OF COMPUTER SCIENTISTS</h1>
        </div>
        <div class="header">
            <h2>Payment Receipt</h2>
        </div>

        <div class="receipt-details">
            <div class="detail-row">
                <div><strong>Student Name:</strong></div>
                <div><?php echo $paymentDetails['student_name']; ?></div>
            </div>
            <div class="detail-row">
                <div><strong>Student Number:</strong></div>
                <div><?php echo $paymentDetails['student_number']; ?></div>
            </div>
            <div class="detail-row">
                <div><strong>Amount Paid:</strong></div>
                <div>₱<?php echo number_format($paymentDetails['amount_paid'], 2); ?></div>
            </div>
            <div class="detail-row">
                <div><strong>Payment Date:</strong></div>
                <div><?php echo $paymentDetails['payment_date']; ?></div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your payment!</p>
        </div>

        <div class="signature-area">
            <p class="signature-label">Treasurer Signature:</p>
            <!-- Add a line or an empty space for the signature -->
            <p>______________________________</p>
        </div>

        <script>
            window.onafterprint = function () {
                // Redirect back to payment.php
                window.location.href = 'payment.php';
            };

            window.onbeforeprint = function () {
                // Do nothing or add any pre-print logic if needed
            };
        </script>
    </div>
</body>
</html>

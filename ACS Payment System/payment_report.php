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

// Query to get the Student Number, names, payment amounts, and payment dates for clients with non-zero payments
$sql = "SELECT clients.Student_Num, clients.yearandsection, clients.name, payments.amount_paid, payments.payment_date
        FROM clients
        INNER JOIN payments ON clients.id = payments.student_id
        WHERE payments.amount_paid > 0";

$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Fetch all rows into an array
$payments = [];
while ($row = $result->fetch_assoc()) {
    $payments[] = $row;
}

// Calculate the sum of all payments
$totalSum = array_sum(array_column($payments, 'amount_paid'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'index.php'?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Payments</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            padding-top: 70px;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 5px;
        }

        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: darkred;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .total-sum {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        
    </style>
</head>

<body>
    <h2>Total Payments</h2>
    <table>
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Student Name</th>
                <th>Year and Section</th>
                <th>Payment Date</th>
                <th>Amount</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Output student number, name, amount paid, and payment date
            foreach ($payments as $payment) {
                echo "
                <tr>
                    <td>{$payment['Student_Num']}</td>
                    <td>{$payment['name']}</td>
                    <td>{$payment['yearandsection']}</td>
                    <td>{$payment['payment_date']}</td>
                    <td>₱{$payment['amount_paid']}</td>
                    
                </tr>
                ";
            }
            ?>
            <tr class="total-sum">

                <td colspan="4">Total:</td>
                <td>₱<?= $totalSum ?></td>
               
            </tr>
        </tbody>
    </table>
</body>

</html>

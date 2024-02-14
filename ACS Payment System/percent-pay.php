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

// Fetch counts of students who have fully paid, have a balance, and have not paid
$sqlFullyPaidCount = "SELECT COUNT(DISTINCT student_id) AS fully_paid_count FROM payments WHERE amount_paid >= 120";
$sqlBalanceCount = "SELECT COUNT(DISTINCT student_id) AS balance_count FROM payments WHERE amount_paid < 120 AND amount_paid > 0";
// $sqlNotPaidCount = "SELECT COUNT(DISTINCT student_id) AS not_paid_count FROM payments WHERE amount_paid = 0 OR amount_paid IS NULL";
$sqlNotPaidCount = "SELECT COUNT(DISTINCT clients.id) AS not_paid_count FROM clients LEFT JOIN payments ON clients.id = payments.student_id WHERE payments.student_id IS NULL OR (payments.amount_paid IS NULL OR payments.amount_paid = 0)";


$resultFullyPaidCount = $connection->query($sqlFullyPaidCount);
$resultBalanceCount = $connection->query($sqlBalanceCount);
$resultNotPaidCount = $connection->query($sqlNotPaidCount);

$fullyPaidCount = $resultFullyPaidCount->fetch_assoc()['fully_paid_count'];
$balanceCount = $resultBalanceCount->fetch_assoc()['balance_count'];
$notPaidCount = $resultNotPaidCount->fetch_assoc()['not_paid_count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Payment Status Pie Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .bilog{
            height: 260px;
            padding-left: 80px;
            width: 400px;
        }
    </style>
</head>
<body>
<h2>Student Payment Status</h2>
    <div class="bilog">
    <canvas id="paymentPieChart" width="100" height="100"></canvas>
    </div>
    <script>
        var ctx = document.getElementById('paymentPieChart').getContext('2d');
        var paymentPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Fully Paid', 'Have Balance', 'Not Paid'],
                datasets: [{
                    data: [<?php echo $fullyPaidCount; ?>, <?php echo $balanceCount; ?>, <?php echo $notPaidCount; ?>],
                    backgroundColor: ['#36a2eb', '#4caf50', '#ff6384'],
                }]
            }
        });
    </script>
</body>
</html>

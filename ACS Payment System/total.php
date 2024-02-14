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

// Query to get the sum of all payments per year
$sql = "SELECT YEAR(payments.payment_date) AS payment_year, SUM(payments.amount_paid) AS totalSum
        FROM clients
        INNER JOIN payments ON clients.id = payments.student_id
        WHERE payments.amount_paid > 0
        GROUP BY payment_year
        ORDER BY payment_year";

$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Fetch data for the chart
$chartData = [];
while ($row = $result->fetch_assoc()) {
    $chartData[] = [
        'year' => $row['payment_year'],
        'totalSum' => $row['totalSum'],
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Payments per Year</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .chart-container1{
            max-height: 300px;
            max-width: 100%;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <h2>Total Payments per Year</h2>
    <div class="chart-container1">
            <canvas id="paymentChart"></canvas>
    </div>
    <script>
        // JavaScript code for creating the chart
        var ctx = document.getElementById('paymentChart').getContext('2d');
        var chartData = <?php echo json_encode($chartData); ?>;

        var years = chartData.map(function (data) {
            return data.year;
        });

        var totalSums = chartData.map(function (data) {
            return data.totalSum;
        });

        var paymentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: years,
                datasets: [{
                    label: 'Total Payments',
                    data: totalSums,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>

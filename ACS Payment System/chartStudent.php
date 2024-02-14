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

// Fetch the count of students for each year and section
$sqlGetData = "SELECT yearandsection, COUNT(*) as student_count FROM clients GROUP BY yearandsection";
$result = $connection->query($sqlGetData);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

// Initialize arrays to store labels and data for the chart
$labels = [];
$data = [];

// Fetch the data for the chart
while ($row = $result->fetch_assoc()) {
    $labels[] = $row['yearandsection'];
    $data[] = $row['student_count'];
}

// Convert arrays to JSON for JavaScript consumption
$labels_json = json_encode($labels);
$data_json = json_encode($data);

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .chart-content {
            width: 1090px;
            max-width: 1090px;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-left: 10px;
            max-height: 236px;
            height: 236px;
            border-radius: 10px;
            border-left-style: solid;
            border-color: darkred;
        }

        .titles {
            text-align: center;
            margin-bottom: 10px;
            
        }

        .chart-container {
            max-width: 100%;
            max-height: 190px;
        }
    </style>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="chart-content">
        <div class="titles">
            <h2>Students Chart</h2>
        </div>
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script>
        // Add a new script section to initialize the Chart.js chart
        var data = <?php echo $data_json; ?>;
        var labels = <?php echo $labels_json; ?>;

        // Get the canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

        // Create the bar chart
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Student Count',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

<?php
include 'index.php';
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

// Modify the SQL query based on the search input and pagination
$search = isset($_GET['search']) ? $_GET['search'] : '';
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if (!empty($search)) {
    $sql = "SELECT payments.id, payments.amount_paid, payments.payment_date, clients.Student_Num, clients.name 
            FROM payments
            INNER JOIN clients ON payments.student_id = clients.id
            WHERE clients.name LIKE '%$search%' OR clients.Student_Num LIKE '%$search%'
            LIMIT " . (($currentPage - 1) * 10) . ", 10";
} else {
    $sql = "SELECT payments.id, payments.amount_paid, payments.payment_date, clients.Student_Num, clients.name 
            FROM payments
            INNER JOIN clients ON payments.student_id = clients.id
            LIMIT " . (($currentPage - 1) * 10) . ", 10";
}

$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}
?>

<link rel="stylesheet" type="text/css" href="contentpage.css">
<link rel="stylesheet" type="text/css" href="style/payment.css">
<link rel="stylesheet" type="text/css" href="style/add_payment.css">

<div class="page-content">
    <div class="titles">
        <h2>Payments</h2>
    </div>
    <div id="PAYMENT" class="tabcontent">
        <div class="payment_list">
            <div class="row">
                <div class="col-md-12">
                    <div class="container_my-5">
                        <br>
                        <!-- Button to open the Add Payment Modal -->
                        <div class="btn-payment2">
                            <div class="btn-payment">
                            <form method="get" action="" id="searchForm" class="formsearch">
                                <label for="search">Search:</label>
                                <input type="text" id="search" name="search" placeholder="Enter student name or number">
                            </form>
                            </div>
                            <div class="btn-payment1">
                            <a class="btn add" onclick="openModal()" role="button">Add</a>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student Number</th>
                                    <th>Student Name</th>
                                    <th>Balance</th>
                                    <th>Amount Paid</th>
                                    <th>Payment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Output payment information in reverse order
                                    $payments = array();
                                    while ($row = $result->fetch_assoc()) {
                                        $payments[] = $row;
                                    }

                                    // Reverse the array to display the latest payment first
                                    $payments = array_reverse($payments);

                                    foreach ($payments as $row) {
                                        echo "
                                        <tr>
                                            <td>{$row['Student_Num']}</td>
                                            <td>{$row['name']}</td>
                                            <td> ₱" . calculateBalance($row['amount_paid']) . "</td>
                                            <td>₱{$row['amount_paid']}</td>
                                            <td>{$row['payment_date']}</td>
                                            <td>
                                                <a class='btn btn-primary btn-sm' href='edit_payment.php?id={$row['id']}'><i class='bx bxs-edit-alt'></i></a>
                                                <a class='btn btn-danger btn-sm' href='delete_payment.php?id={$row['id']}'><i class='bx bx-trash'></i></a>
                                                <a class='btn btn-info btn-sm' href='receipt.php?id={$row['id']}'><i class='bx bxs-receipt' ></i></a>
                                            </td>
                                        </tr>
                                        ";
                                    }

                                    // Function to calculate balance
                                    function calculateBalance($amountPaid) {
                                        // Implement your logic to calculate balance here
                                        // For example, deducting the paid amount from the total balance
                                        $totalBalance = 120; // Replace with the actual total balance
                                        $balance = $totalBalance - $amountPaid;
                                        return $balance;
                                    }
                                     ?>

                            </tbody>
                        </table>

                        <div class="pagination">
                            <?php
                            if ($result->num_rows > 0) {
                                $totalPages = ceil($result->num_rows / 9); // Assuming 10 records per page, adjust as needed

                                if ($currentPage > 1) {
                                    echo "<a class='btn btn-primary btn-sm' href='?page=" . ($currentPage - 1) . "&search=$search'>Previous</a>";
                                }

                                if ($currentPage < $totalPages) {
                                    echo "<a class='btn btn-primary btn-sm' href='?page=" . ($currentPage + 1) . "&search=$search'>Next</a>";
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>      
</div>

<!-- Add Payment Modal Content -->
<div id="addPaymentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-container">
            <h2>Add Payment</h2>
            <form action="process_payment.php" method="post">
                <label for="student_id">Student Name:</label>
                <select name="student_id" required>
                    <?php
                    // Fetch students who do not have a payment entry
                    $sql = "SELECT clients.id, clients.name FROM clients
                            LEFT JOIN payments ON clients.id = payments.student_id
                            WHERE payments.id IS NULL";

                    $result = $connection->query($sql);

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
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addPaymentModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('addPaymentModal').style.display = 'none';
    }

    // Automatically submit the search form on Enter key press
    document.getElementById('search').addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            document.getElementById('searchForm').submit();
        }
    });

    window.onclick = function (event) {
        var modal = document.getElementById('addPaymentModal');
        if (event.target == modal) {
            closeModal();
        }
    };
</script>
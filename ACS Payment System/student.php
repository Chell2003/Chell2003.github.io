<?php include 'index.php'?>
<link rel="stylesheet" type="text/css" href="contentpage.css">
<link rel="stylesheet" type="text/css" href="style/tableStudent.css">

<div class="page-content">
    <div class="titles">
        <h2>Students List</h2>
    </div>
    <div id="STUDENT" class="tabcontent">
        <div class="student_list">
            <div class="row">
                <div class="col-md-12">
                    <div class="container_my-5">
                        <div class="year-section-list">
                            <br>
                            <div class="search-container">
                                <form method="get" action="" id="searchForm" class="formsearch">
                                    <label for="search">Search:</label>
                                    <input type="text" id="search" name="search" placeholder="Enter student name, number, or year">
                                </form>
                                <a class="btn add" href="create.php" role="button">+ Add Student</a>
                            </div>

                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "acs_db";

                            $connection = new mysqli($servername, $username, $password, $database);

                            if ($connection->connect_error) {
                                die("Connection failed: " . $connection->connect_error);
                            }

                            // Check if the search form is submitted
                            if (isset($_GET['search'])) {
                                $search = '%' . $_GET['search'] . '%';

                                $stmt = $connection->prepare("SELECT DISTINCT yearandsection FROM clients
                                                                WHERE name LIKE ?
                                                                OR Student_Num LIKE ?
                                                                OR yearandsection LIKE ?");
                                $stmt->bind_param("sss", $search, $search, $search);
                            } else {
                                // Modify the query to order by yearandsection in ascending order
                                $stmt = $connection->prepare("SELECT DISTINCT yearandsection FROM clients
                                                                ORDER BY yearandsection ASC");
                            }

                            $stmt->execute();
                            $result = $stmt->get_result();
                            ?>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Year and Section</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo "
                                        <tr>
                                            <td>{$row['yearandsection']}</td>
                                            <td>
                                                <a class='btn btn-primary btn-sm' href='?yearsection={$row['yearandsection']}'>View</a>
                                            </td>
                                        </tr>
                                        ";
                                    }

                                    $stmt->close();
                                    $connection->close();
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="student-list">
                            <?php
                            if (isset($_GET['yearsection'])) {
                                $selectedYearSection = $_GET['yearsection'];

                                $connection = new mysqli($servername, $username, $password, $database);

                                if ($connection->connect_error) {
                                    die("Connection failed: " . $connection->connect_error);
                                }

                                $stmt = $connection->prepare("SELECT * FROM clients WHERE yearandsection = ?");
                                $stmt->bind_param("s", $selectedYearSection);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Student Number</th>
                                            <th>Student Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Year and Section</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($row = $result->fetch_assoc()) {
                                            echo "
                                            <tr>
                                                <td>{$row['Student_Num']}</td>
                                                <td>{$row['name']}</td>
                                                <td>{$row['email']}</td>
                                                <td>{$row['phone']}</td>
                                                <td>{$row['yearandsection']}</td>
                                                
                                                <td>
                                                    <a class='btn btn-primary btn-sm' href='edit_student.php?id={$row['id']}'>Edit</a>
                                                    <a class='btn btn-primary btn-sm' href='delete.php?id={$row['id']}'>Delete</a>
                                                </td>
                                            </tr>
                                            ";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var searchInput = document.getElementById('search');
    var searchForm = document.getElementById('searchForm');

    searchInput.addEventListener('input', function(event) {
        if (event.key === 'Enter') {
            searchForm.submit();
        }
    });
</script>

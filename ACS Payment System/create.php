<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $database = "acs_db";

 // Create connection
$connection = new mysqli($servername, $username, $password, $database);


$Student_Num = "";
$name = "";
$email = "";
$phone = "";
$yearandsection = "";

$errorMessage = "";
$successMessage = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $Student_Num = $_POST["Student_Num"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $yearandsection = $_POST["yearandsection"];

   // ...

    do {
        if(empty($Student_Num) ||empty($name) || empty($email) || empty($phone) || empty($yearandsection)){
            $errorMessage = "All fields are required";
            break;
        }


            $sql = "INSERT INTO clients (Student_Num, name, email, phone, yearandsection) " .
                    "VALUES ('$Student_Num', '$name', '$email', '$phone', '$yearandsection')";
            $result = $connection->query($sql);



        if(!$result){
            $errorMessage = "Invalid query: " . $connection ->error;
            break;

        }

        $Student_Num = "";
        $name = "";
        $email = "";
        $phone = "";
        $yearandsection = "";
        $successMessage = "Client added correctly";

        header("location: student.php");
        exit;

    } while(false);

    // ...

}



?>
<?php include 'index.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <link rel="stylesheet" href="create.css">
    
</head>
<body>
    <div class="container my-5">
        <h2>Student</h2>
       
        <?php
            if (!empty($errorMessage)) {
                echo "               
                <div class='alert alert-warning alert-dismissible fade show' role='alert'> 
                    <strong>$errorMessage</strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>        
                </div>
                ";
            }    
        ?>
        
        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Student Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Student_Num" autocomplete="off" value="<?php echo $Student_Num;?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" autocomplete="off" value="<?php echo $name;?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" autocomplete="off" value="<?php echo $email;?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone;?>">
                </div>
            </div>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Year and Section</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="yearandsection" value="<?php echo $yearandsection;?>">
                </div>
            </div>

            <?php
            
            if (!empty($successMessage)) {

                echo "
                
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>               
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>    
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>              
                        </div>               
                    </div>               
                </div>
                ";
            }
            ?>

            <div class="row mb-2">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="student.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Message</title>
    <style>
        /* Add your styles for the pop-up here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .popup {
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .close-btn {
            cursor: pointer;
            color: #4287f5;
            font-size: 20px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .home-btn {
            display: block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4287f5;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'index.php'?>
    <div class="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Payment added successfully.</h2>
        <a href="payment.php" class="home-btn">OK</a>
    </div>

    <script>
        function closePopup() {
            // Redirect to home page or perform any other action
            window.location.href = 'payment.php';
        }
    </script>
</body>

</html>

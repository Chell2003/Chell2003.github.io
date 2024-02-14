<?php include 'index.php'?>
<link rel="stylesheet" type="text/css" href="contentpage.css">
<style>
    .section-container{
        margin-left: 20px;
        
        font-size: 10px;
        margin-left: 20px;
    }
    .section-container1{
        width: 60%;
    }
    .dashboard-2h{
            max-width: 100%;
            padding: 5px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 5px;
    }
    .content-dash{
        display: flex;

    }
    
    .pay-total-percent{
        display: flex;
        width: 1100px;
        margin-left:10px;
        margin-top:10px;
    }
    .total-pay{
        width: 70%;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        border-left-style: solid;
        border-color: darkred;
    }
    .paid-percent{
        width: 40%;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        margin-left: 10px;
        margin-right: 10px;
        height: 340px;
        padding-bottom: 30px;
        border-left-style: solid;
        border-color: darkred;
    }
</style>
<div class="page-content">
    <div class="dashboard-container">
        <div class="dashboard-2h">
            <h2>Dashboard</h2>
        </div>
        <div class="content-dash">
            <div class="section-container">
                <?php include 'account.php'; ?>
                <?php include 'latest_student.php'; ?>
                <?php include 'count_students.php'; ?>
            </div>
            <div class="section-container1">
                <?php include 'chartStudent.php'; ?>
                <div class="pay-total-percent">
                    <div class="total-pay">
                        <?php include 'total.php'; ?>
                    </div>
                    <div class="paid-percent">
                        <?php include 'percent-pay.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


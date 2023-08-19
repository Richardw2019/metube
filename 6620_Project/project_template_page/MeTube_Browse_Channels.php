<?php 
    session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="template_style.css">
    <style>
        {
            box-sizing: border-box;
        }
        /* Set additional styling options for the columns*/
        .column {
        float: left;
        width: 50%;
        }

        .main:after {
        content: "";
        display: table;
        clear: both;
        }

        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <div class="left">
            <img src='logo-5.png'></a>
            <a href="index.php">Home</a>
            <a href="MeTube_Channel.php">Channel</a>
            <a href="MeTube_Browse.php">Browse</a>
            <a class ='active' href="MeTube_Browse_Channels.php">Find Channels</a>
            <a href="MeTube_upload.php">Upload File</a>
        </div>
        <!-- Add User profile picture on the right header -->
        <div class="right">
            <img src="loginIcon.png"></a>
            <a href="MeTube_Login.php">Login</a>
            <a href="MeTube_SignUp.php">Sign Up </a>
            <a href="../php_scripts/logout.php"> Log Out </a>
            <a href="MeTube_AccDets.php"> Profile Details </a>
        </div>

    </div>
    <div class="main">
    <?php
        include "../php_scripts/browse_channels.php";

    ?>

    </div>
    
</body>
</html>
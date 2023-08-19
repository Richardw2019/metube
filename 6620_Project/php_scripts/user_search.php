<?php

    include 'db_connect.php';


    if($_SERVER["REQUEST_METHOD"] == "POST") {

        //read in form input
        $searched_username = mysqli_real_escape_string($conn, $_POST['searched_user']);
        //check users table to see if user exists
        $query = "SELECT user_id, first_name, last_name, id FROM Users WHERE user_id = '$searched_username'";
        $res = mysqli_query($conn, $query);
        $check = mysqli_num_rows($res);
        $results = $res->fetch_assoc();    

        $_SESSION['recipient_id'] = $results['id'];


        if ($check == 0)
        {
            $_SESSION['failed'] = ' User not found, try again';
        }
    }
    
    $conn->close();
?>
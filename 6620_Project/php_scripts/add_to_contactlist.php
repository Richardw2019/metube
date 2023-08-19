<?php

    session_start();
    include 'db_connect.php';

    if(isset($_POST['contactlist'])) {


    
        //might potentially change variable names hahaha
        $zero =  $_SESSION['added_user'];
        $one =  $_SESSION['added_first_name']; 
        $two = $_SESSION['added_last_name'] ;
        $three =  $_SESSION['added_id'];
        $four = $_SESSION['logged_in_id'];
        $contact_category = $_POST['contact_category'];

        // prevent duplicate users check
        $sql = "SELECT * FROM Contact_List WHERE contact_id='$three' and user_id = '$four'";
        $result = mysqli_query($conn, $sql);
        $contact_id_duplicates = mysqli_num_rows($result);


        if($contact_id_duplicates == 1)
        {
            echo "<br>";
            echo "User is already in your contact list, please go back and find a new user";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_AccDets.php';\"000);</script>";

        }

        else 
        {
            $sql = "INSERT INTO Contact_List (user_id, contact_id, contact_user_id, contact_firstname, contact_lastname, contact_category) 
            VALUES ('$four', '$three', '$zero', '$one', '$two', '$contact_category')";

            $results = mysqli_query($conn, $sql);
            echo "<br>";
            echo "successful";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_AccDets.php';\",3000);</script>";

        }


    }

    $conn->close();

?>
<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connect.php';


        $msg =  $_POST['new_message'];
        $from = $_SESSION['username'];
        $to =  $_SESSION['from_id'];


        $user_numeric_id=$_SESSION['logged_in_id'];
        
        $sql = "INSERT INTO User_Messages  (message, sent_by, sent_to) VALUES ('$msg','$user_numeric_id', '$to')";
        
        if(mysqli_query($conn, $sql)) {
            $last_id = mysqli_insert_id($conn);
        }
        
        $sql_2 = "SELECT * FROM User_Messages WHERE id='$last_id'";

        $results = mysqli_query($conn, $sql_2);
        $re =  mysqli_num_rows($results);

       


            $row = mysqli_fetch_assoc($results);
            echo "<br>";
            echo "Successfully sent message, please go back";
        
            $_SESSION['posted_message'] = $row['message'];
            $_SESSION['pm_time'] = $row['sent_date'];
      
    

        $conn->close();
    }

?>
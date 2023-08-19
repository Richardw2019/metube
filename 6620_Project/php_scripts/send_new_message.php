<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connect.php';


        $msg =  $_POST['new_message'];
        $from = $_SESSION['username'];
        $to =  $_SESSION['recipient_id'];
        echo $to;


        $user_numeric_id=$_SESSION['logged_in_id'];
        $sql_query_blocked = "SELECT block_status FROM Contact_List WHERE user_id=$user_numeric_id AND contact_id=$to";
        $sql_query_blocked_2 = "SELECT block_status FROM Contact_List WHERE contact_id=$user_numeric_id AND user_id=$to";
        echo "<br> $sql_query_blocked";
        $blocked_results = mysqli_query($conn, $sql_query_blocked);
        $blocked_results_2 = mysqli_query($conn, $sql_query_blocked_2);
        if((mysqli_fetch_assoc($blocked_results)['block_status']=='Yes') or (mysqli_fetch_assoc($blocked_results_2)['block_status']=='Yes')){
            Echo "<h3> You can not send a message to this user, You have blocked them or they have blocked you. Please return to your messages <h3>";
        } else {
            $sql = "INSERT INTO User_Messages  (message, sent_by, sent_to) VALUES ('$msg','$user_numeric_id', '$to')";
            
            if(mysqli_query($conn, $sql)) {
                $last_id = mysqli_insert_id($conn);
            }

            //echo $last_id;
            $out = 'out';


            $sql_2 = "INSERT INTO User_Mailboxes (user_id, mailbox_type, message_id) VALUES ('$user_numeric_id', '$out', '$last_id')";


            header('Location: ../project_template_page/MeTube_Messaging_Dashboard.php');
            

        }
        $conn->close();
    }

?>
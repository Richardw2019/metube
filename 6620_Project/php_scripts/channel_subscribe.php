<?php
    session_start();
    include 'db_connect.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $logged_in_id = $_SESSION['logged_in_id'];
        $channel_id = $_POST['channel_id'];

        if ($logged_in_id == $channel_id)
        {
            echo "You cannot subscribe to yourself";
        }

        else 
        {

            $sql = "SELECT * FROM Channel_Subscriptions WHERE user_id='$logged_in_id' AND channel_id='$channel_id'";
            $results = mysqli_query($conn, $sql);
            $check = mysqli_num_rows($results);
            
            

            if ($check == 1)
            {
                echo "Already subscribed to this channel, please go back";
            }

            else 
            {
                $sql_1 = "INSERT INTO Channel_Subscriptions (user_id, channel_id) VALUES ('$logged_in_id', '$channel_id')";
                $results_1 = mysqli_query($conn, $sql_1);

                echo "You have subscribed to this channel, please go back";

            }
        }

    }

    $conn->close();
?>
<?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $curr_playlist_id =  $_POST['curr_playlist_id'];
        $new_playlist_name =  $_POST['new_playlist_name'];
        $curr_user_id = $_SESSION['logged_in_id'];
      

        $sql = "DELETE FROM Playlist_Tracker  WHERE 
                playlist_id='$curr_playlist_id' AND user_id='$curr_user_id'";

        //delete playlist videos as well from other table

        $results = mysqli_query($conn, $sql);
      
        echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Playlists.php';\",0000);</script>";


       

    }
?>
<?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
       

        $curr_playlist_id =  $_POST['curr_playlist_id'];
        $new_playlist_name =  $_POST['new_playlist_name'];
        $curr_user_id = $_SESSION['logged_in_id'];

        $sql_1 = "SELECT * FROM Playlist_Tracker WHERE user_id='$curr_user_id' AND playlist_id <> '$curr_playlist_id'";

        $results = mysqli_query($conn, $sql_1);
        
        $row = mysqli_fetch_array($results);

     
        if ($new_playlist_name == $row['playlist_name'])
        {
            echo "You already have a playlist with this name, enter a unique name";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Playlists.php';\",4000);</script>";

        }
 

        else {

            $sql = "UPDATE Playlist_Tracker SET playlist_name='$new_playlist_name' WHERE 
                playlist_id='$curr_playlist_id' AND user_id='$curr_user_id'";

            $results = mysqli_query($conn, $sql);
            echo "Successfully renamed your playlist";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Playlists.php';\",0000);</script>";


       }

    }
?>
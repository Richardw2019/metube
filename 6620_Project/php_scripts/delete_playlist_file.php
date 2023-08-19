<?php
    session_start();
    include 'db_connect.php';



    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        
        $playlist_id = $_POST['playlist_id'];
        $video_id = $_POST['video_id'];

      
        $logged_in_user = $_SESSION['logged_in_id'];

        $sql = "DELETE FROM File_Playlist WHERE playlist_id='$playlist_id' AND video_id='$video_id'";

        $results = mysqli_query($conn, $sql);

        echo "Video removed successfully, please go back to see your playlist";


    }

    $conn->close();
?>
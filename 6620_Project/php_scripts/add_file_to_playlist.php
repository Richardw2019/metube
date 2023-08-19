<?php
    session_start();
    include 'db_connect.php';



    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $user_id = $_SESSION['logged_in_id'];
        $playlist_name = $_POST['playlist_name'];
        $extension = $_POST['extension'];
        $file_id = $_POST['file_id'];
    
        $sql = "SELECT * FROM Playlist_Tracker WHERE user_id='$user_id' AND playlist_name='$playlist_name'";

        $results = mysqli_query($conn, $sql);
        $matched_playlist = mysqli_num_rows($results);

        //if playlist search is a match then add file to playlist
        if ($matched_playlist == 1)
        {
            
            $row = $results->fetch_assoc();
            echo "Playlist found <br>";
            $id = $row['playlist_id'];
            // echo $row['playlist_id'];

            $sql_1 = "SELECT * FROM File_Playlist WHERE playlist_id='$id' AND video_id='$file_id'";

            $results_1 = mysqli_query($conn, $sql_1);

            $duplicates = mysqli_num_rows($results_1);

            if ($duplicates > 0)
            {
                echo "File already in playlist, no duplicate files allowed";
                echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Browse.php';\",4000);</script>";

            }
            
            else 
            {
                $id = $row['playlist_id'];
                $sql_2 = "INSERT INTO File_Playlist (playlist_id, video_id, extension) VALUES ('$id', '$file_id', '$extension')";
                $results_2 = mysqli_query($conn, $sql_2);
                Echo "<br> Video added to playlist";
                echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Browse.php';\",2000);</script>";

            }
        }


        else 
        {
            echo "Playlist not found, please try again";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Browse.php';\",4000);</script>";

        }
    }

    $conn->close();
?>
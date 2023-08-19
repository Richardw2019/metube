<?php
    session_start();
    include 'db_connect.php';



    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        $file_name =  $_POST['file_name'];
        $file_id = $_POST['file_id'];
        $extension = $_POST['extension'];
        $file_path = $_POST['file_path'];

        $logged_in_user = $_SESSION['logged_in_id'];

        $sql = "SELECT * FROM Favorites_List WHERE user_numeric_id='$logged_in_user' AND 
               file_name ='$file_name'";

        $results = mysqli_query($conn, $sql);
        $favorites_duplicates = mysqli_num_rows($results);

        if ($favorites_duplicates > 0)
        {
            echo "You already have this file stored in your favorites list";
            
        }

        else
        {
            $sql_2 = "INSERT INTO Favorites_List (video_id, user_numeric_id, file_name, file_extension, file_path) VALUES
                      ('$file_id', '$logged_in_user', '$file_name', '$extension', '$file_path')";
            $results_2 = mysqli_query($conn, $sql_2);
            echo "Added file to favorites list (your favorites list is located in account details)";
            echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_Browse.php';\",4000);</script>";

        }

    }

    $conn->close();
?>
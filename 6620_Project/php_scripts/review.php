<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include "db_connect.php";
    session_start();
    if (isset($_POST['star1'])) {
        $rating = 1;
    }
    elseif (isset($_POST['star2'])) {
        $rating = 2;
    }
    elseif (isset($_POST['star3'])) {
        $rating = 3;
    }
    elseif (isset($_POST['star4'])) {
        $rating = 4;
    }
    elseif (isset($_POST['star5'])) {
        $rating = 5;
    }
    else {
        $rating = 0;
    }

    $file_id = $_POST['file_id'];
    $user_id = $_SESSION['logged_in_id'];

    //$review = "UPDATE Media_Ratings SET rating=$rating WHERE user_id=$user_id AND video_id=$file_id; IF SELECT ROW_COUNT() = 0 INSERT INTO Media_Ratings (user_id, video_id, rating) VALUES ('$user_id', '$file_id', '$rating')";
    $check_review = "SELECT rating FROM Media_Ratings WHERE user_id=$user_id AND video_id=$file_id;";
    $update_review = "UPDATE Media_Ratings SET rating=$rating WHERE user_id=$user_id AND video_id=$file_id;";
    $add_review = "INSERT INTO Media_Ratings (user_id, video_id, rating) VALUES ('$user_id', '$file_id', '$rating');";

    $result = mysqli_query($conn, $check_review);
    if (mysqli_num_rows($result)>0) {
        mysqli_query($conn, $update_review);
    }
    else {
        mysqli_query($conn, $add_review);
    }

    header('Location: ../project_template_page/MeTube_Media.php?id='.$file_id);
    $conn->close();
}


?>
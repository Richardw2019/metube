<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include './db_connect.php';
    $id =  $_POST['file_id'];
    header("Location: ../project_template_page/MeTube_Media.php?id=$id");
    $query_for_views = "SELECT view_count from Multimedia_Files WHERE id=$id";
    $sql_results = mysqli_query($conn, $query_for_views);
    $row = mysqli_fetch_all($sql_results);
    $row[0][0] = $row[0][0] + 1;
    $new_view_count = $row[0][0];
    $update_views_query = "UPDATE Multimedia_Files SET view_count=$new_view_count WHERE id=$id";
    $sql_update = mysqli_query($conn, $update_views_query);
    $conn->close();
}



?>
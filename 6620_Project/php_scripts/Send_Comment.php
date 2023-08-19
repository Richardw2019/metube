<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';
    session_start();
    $file_id = $_POST['file_id'];
    $parent = $_POST['parent'];
    $level = $_POST['level'];
    $comment = $_POST['comment'];
    $username = $_SESSION['username'];

    $id_query = "SELECT comment_id FROM Commenting ORDER BY comment_id DESC LIMIT 1;";
    $results = mysqli_query($conn, $id_query);
    $query = mysqli_fetch_assoc($results);
    $comment_id = $query['comment_id'] + 1;

    if ($parent == 0) {
        $parent = $comment_id;
    }

    $comment_query = "INSERT INTO Commenting (user_id, file_id, comment, comment_id, parent_id, comment_level) VALUES ('$username', '$file_id', '$comment', '$comment_id', '$parent', '$level');";
    echo $comment_query;
    mysqli_query($conn, $comment_query);
    header('Location: ../project_template_page/MeTube_Media.php?id='.$file_id);
    $conn->close();
}
?>
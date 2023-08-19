<?php

include "db_connect.php";
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {

    //read in form input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);




    //check users table to see if user exists
    $query = "SELECT * FROM Users WHERE user_id = '$username' AND user_password ='$password'";
    $results = mysqli_query($conn, $query);
    $info = $results->fetch_assoc();    


    //if user exists log them in
    if (mysqli_num_rows($results) == 1) {
        $_SESSION['username'] = $username;
        $_SESSION['logged_in_id'] = $info['id'];

        $_SESSION['success'] = "you are now logged in";
        // header("location: ../project_template_page/index.php");
        header("location: ../project_template_page/MeTube_AccDets.php"); // temporary
        exit();
    }



    else {
        echo "<br>";
        echo "Your user name or password is invalid, go back and try again";
    }
}

$conn->close();

?>
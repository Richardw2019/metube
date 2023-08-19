<?php

// include 'db_connect.php';

// $sql = "SELECT * FROM Users";
// $results = $conn->query($sql); 

// echo mysqli_num_rows($results);
// 6620_Students
// $conn->close();

// Loop for the connectinon
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword =$_POST["confirmpassword"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];

    

    // check for user id duplicate users
    $sql = "SELECT * from Users where user_id='$username'";
    $results = mysqli_query($conn, $sql);
    $user_id_duplicates = mysqli_num_rows($results); //gets the user id duplicates from the table

     // check for email duplicate users
     $sql = "SELECT * from Users where email ='$email'";
     $results = mysqli_query($conn, $sql);
     $email_duplicates = mysqli_num_rows($results); 

    //email line validation
    if (strpos($email, "@") == false or strpos($email, ".edu") == false or strpos($email, ".com"))
    {
        echo "<br>";
        echo "Email is not in the correct format<br>";
        echo "Email is either missing '@' or '.com' or '.edu'";
    }

    //if email duplicates exist
    else if ($email_duplicates>0)
    {
        echo "<br>";
        echo "Email already exists, sign in with that email or create an account with a unique email";
    }

    //if user id duplicates exist
    else if($user_id_duplicates>0){
        echo "<br>";
        $exists="Username already exists, go back and create a unique username";
        echo $exists;
    }

    //if passwords don't match
    else if ($password != $confirmpassword)
    {
        echo "<br>";
        echo "Passwords do not match, go back and try again";
    }

    //if user left sign up fields empty
    else if(empty($email) or empty($username) or empty($password) or empty($firstname) or empty($lastname))
    {
        echo "<br>";
        echo "There is an empty field(s), please go back and fill it out";
    }

    //if no duplicates found, no empty fields, and passwords match then add to the database
    else 
    {
        // sql query for table assuming that we are dumb dumb and not hashing
        $sql = "INSERT INTO Users (user_id, last_name, first_name, user_password, email) VALUES ('$username', '$lastname', '$firstname', '$password', '$email')";

        $results = mysqli_query($conn, $sql);
        echo "<br>";
        echo "Successfully registered user: " . $username;

        // redirect user to acount details page
        echo "<script>setTimeout(\"location.href = '../project_template_page/MeTube_AccDets.php';\",3000);</script>";

        // header('Location: ../project_template_page/MeTube_AccDets.php');
    }

    $conn->close();
}

?>

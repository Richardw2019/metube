<?php

    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connect.php';
    
        $updated_email = $_POST["email"];
        $updated_username = $_POST["username"];
        $updated_password = $_POST["password"];
        $updated_confirmpassword =$_POST["confirmpassword"];
        $updated_firstname = $_POST["firstname"];
        $updated_lastname = $_POST["lastname"];

        $logged_in_id = $_SESSION['logged_in_id'];

        //actual $_SESSION['id'] is not working, idk why, using username instead for this
        $id = $_SESSION['username'];
        // debug
        //print_r($_SESSION['username']);


    

        $select_user = "SELECT * FROM Users where user_id='$id'";
        $sql = mysqli_query($conn, $select_user);
        $row = mysqli_fetch_assoc($sql);

        $res = $row['user_id'];

        if($res === $id)
        {
    
            // check for user id duplicate users
            $sql = "SELECT * from Users where user_id='$updated_username'";
            $results = mysqli_query($conn, $sql);
            $user_id_duplicates = mysqli_num_rows($results); //gets the user id duplicates from the table
        
            // check for email duplicate users
            $sql = "SELECT * from Users where email ='$updated_email' AND id <> '$logged_in_id'";
            $results = mysqli_query($conn, $sql);
            $email_duplicates = mysqli_num_rows($results); 
        
            //email line validation
            if (strpos($updated_email, "@") == false or strpos($updated_email, ".edu") == false or strpos($updated_email, ".com"))
            {
                echo "<br>";
                echo "Email is not in the correct format<br>";
                echo "Email is either missing '@' or '.com' or '.edu'";
            }
        
            //if email duplicates exist
            else if ($email_duplicates>0)
            {
                echo "<br>";
                echo "Email already exists, sign in with that email or use a unique email";
            }
        
            //if user id duplicates exist
            else if($user_id_duplicates>0){
                echo "<br>";
                $exists="Username already exists, go back and create a unique username";
                echo $exists;
            }
        
            //if passwords don't match
            else if ($updated_password != $updated_confirmpassword)
            {
                echo "<br>";
                echo "Passwords do not match, go back and try again";
            }
        
            //if user left sign up fields empty
            else if(empty($updated_email) or empty($updated_username) or empty($updated_password) or empty($updated_firstname) or empty($updated_lastname))
            {
                echo "<br>";
                echo "There is an empty field(s), please go back and fill it out";
            }
        
            //if no duplicates found, no empty fields, and passwords match then add to the database
            else 
            {
                $update = "UPDATE Users SET user_id = '$updated_username', last_name = '$updated_lastname', first_name = '$updated_firstname', user_password = '$updated_password', email = '$updated_email' WHERE user_id = '$id'";
                $sql2 = mysqli_query($conn, $update);
                echo "<br>";
                echo "successfully updated profile please sign in again to reflect update";
            }


                //header('location:../project_template_page/index.php');
            
        
            $conn->close();
        }
    }
    
?>
<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    // Get file info from form post
    // $video_name = $_FILES['file']['name'];
    $local_name = $_FILES['userfile']['name'];
    $desired_name = $_POST['video_name'];
    // $tgt_dir = "http://webapp.computing.clemson.edu/~sethi/MeTube_6620_Repository/uploaded_files/".basename($local_name);
    $mov_dir = "../uploaded_files/";
    $tgt_file = $mov_dir . basename($local_name);
    $file_description = $_POST['file_description'];
    $file_type = $_POST['filetype'];
    $category = $_POST['category'];
    $sharing_mode = $_POST['sharingmode'];
    $tags = $_POST['video_tags'];


    $file_owner = $_SESSION['username'];
    
    //get the file size in bytes
    $size=$_FILES['userfile']['size'];
    


    //convert file size to MB
    $file_size = round($size / 1024 / 1024,4) . 'MB';
    // echo '<br>';
    // echo $file_size;

    //check for duplicate file names 
    $sql = "SELECT * from Multimedia_Files WHERE file_title='$desired_name'";
    $results = mysqli_query($conn, $sql);
    $file_name_duplicates = mysqli_num_rows($results);

    //check for duplicate file paths
    $sql_2 = "SELECT * from Multimedia_Files WHERE file_path='$tgt_file'";
    $results_2 = mysqli_query($conn, $sql_2);
    $file_path_duplicates = mysqli_num_rows($results_2);

    //if file name duplicates exist
    if($file_name_duplicates>0){
        echo "<br>";
        $exists="File name already exists, go back and create a unique file name";
        echo $exists;

    //if file path duplicates exists
    } elseif($file_path_duplicates>0){
        echo "<br>";
        $exists="File path already exists, upload a file with a different name or with a different extension";
        echo $exists;
    }
    
    else {

        // Upload to database
        // Use the move upload file function
        $up_results = move_uploaded_file($_FILES['userfile']['tmp_name'], $tgt_file);
        // If succesful add entry to databasese
        if($up_results){
            //$query = "INSERT INTO Multimedia_Files(file_title,file_path,keywords) VALUES ('$desired_name', '$tgt_file', '$tags')";
            $query = "INSERT INTO Multimedia_Files (file_title, file_type, keywords, category, description, sharing_mode, file_path, size, file_owner) VALUES ('$desired_name', '$file_type', '$tags', '$category', '$file_description', '$sharing_mode', '$tgt_file', '$file_size', '$file_owner')";

            $sql_results = mysqli_query($conn,$query);
            echo "<br> File has been uploaded: " . $tgt_file;
            echo "<br> File Owner: " . $file_owner;
        
        } else {
            echo "<br> File has not been uploaded: " . $tgt_file;
        }
    }

    $conn->close();

}
 

?>
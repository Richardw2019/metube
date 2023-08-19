<?php
include "prevent_blocked_view.php";

function displayMiniMedia($extension, $path) {
    $height = 160;
    $audio_height = 30;
    $width = 200;
    if (strcasecmp($extension, "mp4") == 0) {
        $type = "video";
    }
    elseif (strcasecmp($extension, "mov") == 0) {
        $type = "video";
    }
    elseif (strcasecmp($extension, "mp3") == 0) {
        $type = "audio";
    }
    elseif (strcasecmp($extension, "wav") == 0) {
        $type = "audio";
    }
    elseif (strcasecmp($extension, "m4a") == 0) {
        $type = "audio";
    }
    elseif (strcasecmp($extension, "jpg") == 0) {
        $type = "image";
    }
    elseif (strcasecmp($extension, "png") == 0) {
        $type = "image";
    }
    else {
        $type = "image";
    }

    if (strcasecmp($type, "video") == 0) {
        echo "<video controls height=\"".$height."\" width=\"".$width."\">";
        echo "\n<source src=\"".$path."\">";
        echo "\nSorry, your browser doesn't support embedded videos.";
        echo "\n</video>\n";
    }

    elseif (strcasecmp($type, "audio") == 0) {
        echo "<video controls height=\"".$audio_height."\" width=\"".$width."\">";
        echo "\n<source src=\"".$path."\">";
        echo "\nSorry, your browser doesn't support embedded videos.";
        echo "\n</video>\n";
    }
    
    else {
        echo "<img src=\"".$path."\" height=\"".$height."\" width=\"".$width."\">";
    }

}

function generate_recommended($file_id, $user_id, $category, $conn){
    $get_media = "SELECT file_title, file_path, id FROM Multimedia_Files WHERE category='$category' AND id!=$file_id AND sharing_mode='public'";
        if(!empty($user_id)){
            $get_media = prevent_blocked_view($get_media,True,$user_id, $conn);
            // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $get_media";
        }
    $sql_query = mysqli_query($conn, $get_media);
    $rows = mysqli_fetch_all($sql_query);
    // echo "<br>";
    // print_r($rows);
    if(mysqli_num_rows($sql_query)>0){
        foreach($rows as $row);
            $file_title = $row[0];
            $file_path = $row[1];
            $file_id = $row[2];
            $extension_arr = explode(".", $file_path);
            $extension = $extension_arr[count($extension_arr) - 1];
            echo "<h3> Name of vid: $file_title </h3>";
            displayMiniMedia($extension, $file_path);
            echo "<br> <br>";
            echo "<form method='post' action = '../php_scripts/goto_media.php'>
            <input type='hidden' name='file_id' value='$file_id' r/>
            <input type='submit' value='Go to media page'/> </form>";
    }



}


// // demo
// include "db_connect.php";
// generate_recommended(3,6,'nature',$conn);
?>
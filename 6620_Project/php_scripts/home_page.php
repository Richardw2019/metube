<?php
include "prevent_blocked_view.php";
function displayMedia($extension, $path) {
    $height = 480;
    $audio_height = 30;
    $width = 560;
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

// Show most viewed file on home screen
function show_most_viewed($conn, $num_vids){
    $get_media = "SELECT file_title, file_path, file_owner, view_count, id FROM Multimedia_Files WHERE sharing_mode='public'";
    if(!empty($_SESSION['logged_in_id'])){
        $get_media = prevent_blocked_view($get_media,True,$_SESSION['logged_in_id'], $conn);
        // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $base_statement";
    }
    $get_media = $get_media .  " ORDER BY view_count DESC";
    // echo "<br> FINAL SQL STATEMENT: $get_media";
    $sql_results = mysqli_query($conn, $get_media);
    $rows = mysqli_fetch_all($sql_results);
    echo "<h1> Most Viewed Media: </h1>";
    $i = -1;
    // echo "<br> num rows: " .  mysqli_num_rows($sql_results);
    while (($i++ <= $num_vids) && ($i <mysqli_num_rows($sql_results))){
        $file_title = $rows[$i][0];
        $file_path = $rows[$i][1];
        $file_owner = $rows[$i][2];
        $view_count = $rows[$i][3];
        $file_id = $rows[$i][4];
        $extension_arr = explode(".", $file_path);
        $extension = $extension_arr[count($extension_arr) - 1];
        echo "<b> ----------------------------------------------------- </b>";
        echo "<h2> $file_title </h2>";
        echo "<h3> Creator: $file_owner </h3>";
        echo "<h3> View Count: $view_count </h3>";
        displayMedia($extension, $file_path);
        echo "<br>";
        echo "<br>";
        echo "<form method='post' action = '../php_scripts/goto_media.php'>
        <input type='hidden' name='file_id' value='$file_id' r/>
        <input type='submit' value='Go to media page'/> </form>";
    }
}

// Show most recently uploaded on home screen
function show_most_recent($conn, $num_vids){
    $get_media = "SELECT file_title, file_path, file_owner, upload_date, id FROM Multimedia_Files WHERE sharing_mode='public'";
    if(!empty($_SESSION['logged_in_id'])){
        $get_media = prevent_blocked_view($get_media,TRUE,$_SESSION['logged_in_id'], $conn);
        // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $base_statement";
    }
    $get_media = $get_media .  " ORDER BY upload_date DESC";
    $sql_results = mysqli_query($conn, $get_media);
    $rows = mysqli_fetch_all($sql_results);
    echo "<h1> Most Recent Media: </h1>";
    $i = -1;
    while (($i++ <= $num_vids) && ($i <mysqli_num_rows($sql_results))){
        $file_title = $rows[$i][0];
        $file_path = $rows[$i][1];
        $file_owner = $rows[$i][2];
        $upload_date = $rows[$i][3];
        $file_id = $rows[$i][4];
        $extension_arr = explode(".", $file_path);
        $extension = $extension_arr[count($extension_arr) - 1];
        echo "<b> ----------------------------------------------------- </b>";
        echo "<h2> $file_title </h2>";
        echo "<h3> Creator: $file_owner </h3>";
        echo "<h3> Upload Date: $upload_date </h3>";
        displayMedia($extension, $file_path);
        echo "<br>";
        echo "<br>";
        echo "<form method='post' action = '../php_scripts/goto_media.php'>
        <input type='hidden' name='file_id' value='$file_id' r/>
        <input type='submit' value='Go to media page'/> </form>";
    }
}

// Show latest video from subscribed
function show_recent_subscribed($conn, $num_vids){
    if (!empty($_SESSION['username'])){
        echo "###########################";
        echo "<h1> Latest videos from subscribed </h1>";

    } else{
        echo "<h1> Log in to view subscribed content </h1>";
    }
}



?>
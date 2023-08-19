<?php

include "../php_scripts/db_connect.php";
include "../php_scripts/prevent_blocked_view.php";
// $user_name = $_SESSION['username'];
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$url_components = parse_url($url);
parse_str($url_components['query'], $params);
$channel_username = $params['username'];
$get_video = "SELECT file_path, file_title, id FROM Multimedia_Files WHERE file_owner = '$channel_username' AND sharing_mode='public'";
if(!empty($_SESSION['logged_in_id'])){
    $get_video = prevent_blocked_view($get_video,True,$_SESSION['logged_in_id'], $conn);
    // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $get_video";
}
$sql_results = mysqli_query($conn, $get_video);
$rows = mysqli_fetch_all($sql_results);

if(!$channel_username){
    if(!empty($_SESSION['username'])){
        header("Location: ./MeTube_Channel.php?username=" . $_SESSION['username']);
    } else{
        header("Location: ./MeTube_Login.php");
    }

}



function displayMedia($extension, $path) {
    $height = 600;
    $audio_height = 30;
    $width = 1024;
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

if(mysqli_num_rows($sql_results) > 0){
    // Channel info
    echo "<h1> Welcome to $channel_username 's channel";
    

    $sql = "SELECT id FROM Users WHERE user_id='$channel_username'";


    $result = mysqli_query($conn, $sql);
    $res = $result->fetch_assoc();

    $id =  $res['id'];
    if (!empty($_SESSION['logged_in_id'])){
        $logged_in_id = $_SESSION['logged_in_id'];
    

    $sql_1 = "SELECT * FROM Channel_Subscriptions WHERE user_id='$logged_in_id' AND channel_id='$id'";

    $result_1 = mysqli_query($conn, $sql_1);
    $check = mysqli_num_rows($result_1);
            
    if ($check == 1)
    {
        echo "<br>";
        echo "Subscribed";
    }
    else
    {
        echo "<br>";
        echo "Not subscribed";
    }


    echo "<form method='post' action = '../php_scripts/channel_subscribe.php'>
    <input type='hidden' name='channel_id' value='$id'/>
    <input type='submit' value='Subscribe'/>  </form> ";

    echo "<form method='post' action = '../php_scripts/channel_unsubscribe.php'>
    <input type='hidden' name='channel_id' value='$id'/>
    <input type='submit' value='Unsubscribe'/>  </form> ";

    }

    foreach ($rows as &$file_info){
        $extension_arr = explode(".", $file_info[0]);
        $extension = $extension_arr[count($extension_arr) - 1];
        echo "<h2> $file_info[1] </h2>";
        displayMedia($extension, $file_info[0]);
        echo "<br>";
        echo "<br>";
        echo "<form method='post' action = '../php_scripts/goto_media.php'>
        <input type='hidden' name='file_id' value='$file_info[2]' r/>
        <input type='submit' value='Go to media page'/> </form>";
    }
} else {
    echo "<h1> Either no user named $channel_username found or $channel_username has no files uploaded therefore this is not a channel! </h1>";
    echo "<h3> There is a possibility that the user has blocked you... sorry :(";

}




$conn->close();
?>
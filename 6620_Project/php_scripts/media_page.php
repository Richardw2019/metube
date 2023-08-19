<?php
        include "db_connect.php";
        session_start();
        //$file_info is an array containing the following:
        //      [0]: video name
        //      [1]: video title
    
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        $file_id = $params['id'];
        $get_video = "SELECT * FROM Multimedia_Files WHERE id='$file_id'";
        $sql_results = mysqli_query($conn, $get_video);
        $query = mysqli_fetch_assoc($sql_results);
        $path = $query["file_path"];
        $name = $query["file_title"];
        $username = $_SESSION['username'];
        $category = $query["category"];
        $extension_arr = explode(".", $path);
        $extension = $extension_arr[count($extension_arr) - 1];
        $filename_arr = explode("/", $path);
        $filename = $filename_arr[count($filename_arr) - 1];

        $stars = array();
        $user_id = $_SESSION['logged_in_id'];
        $get_ratings = "SELECT rating FROM Media_Ratings WHERE video_id=$file_id AND user_id=$user_id;";
        $ratings_results = mysqli_query($conn, $get_ratings);

        if (mysqli_num_rows($ratings_results)>0) {
            $ratings_query = mysqli_fetch_assoc($ratings_results);
            $rating = $ratings_query["rating"];
        }

        for ($x = 1; $x <= 5; $x++) {
            if (mysqli_num_rows($ratings_results)==0) {
                array_push($stars, 'black');
            }
            elseif ($x <= $rating) {
                array_push($stars, 'goldenrod');
            }
            else {
                array_push($stars, 'black');
            }
        }
        
        $total_ratings = 0;
        $get_all_ratings = "SELECT rating FROM Media_Ratings WHERE video_id=$file_id";
        $all_ratings_results = mysqli_query($conn, $get_all_ratings);

        while ($row = mysqli_fetch_array($all_ratings_results, MYSQLI_ASSOC)) {
            $total_ratings = $total_ratings + $row['rating'];
        }

        if (mysqli_num_rows($all_ratings_results) > 0) {
            $average_rating = $total_ratings/mysqli_num_rows($all_ratings_results);
        }
        else {
            $average_rating = 0;
        }

        $average_stars = array();
        for ($x = 1; $x <= 5; $x++) {
            if (mysqli_num_rows($all_ratings_results)==0) {
                array_push($average_stars, 'black');
            }
            elseif ($x <= $average_rating) {
                array_push($average_stars, 'goldenrod');
            }
            else {
                array_push($average_stars, 'black');
            }
        }

        function getComments($file_id) {
            include "db_connect.php";
            $comment_query = "SELECT * FROM Commenting WHERE file_id='$file_id' ORDER BY comment_id ASC";
            $result = mysqli_query($conn, $comment_query);
            $comment_array = array();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
                $row_array = array(0 => $row['user_id'], 1 => $row['file_id'], 2 => $row['comment'], 3 => $row['comment_id'], 4 => $row['parent_id'], 5 => $row['comment_level']);
                if (count($comment_array) == 0) {
                    array_push($comment_array, $row_array);
                    continue;
                }
                for ($x = 0; $x < count($comment_array); $x++) {
                    $current_array = $comment_array[$x];
                    if ($x == count($comment_array)-1) {
                        array_push($comment_array, $row_array);
                        break;
                    }
                    elseif ($row_array[4] == $current_array[3]) {
                        $new_comment_array = array();
                        for ($y = 0; $y < count($comment_array); $y++) {
                            array_push($new_comment_array, $comment_array[$y]);
                            if ($y == $x) {
                                array_push($new_comment_array, $row_array);
                            }
                        }
                        $comment_array = $new_comment_array;
                        break;
                    }
                }
            }
           
            echo "\n<div style=\"float:left\">";
            for ($x = 0; $x < count($comment_array); $x++) {
                $row = $comment_array[$x];
                echo "\n<div>";
                echo "\n<div class=\"comment\" style=\"float:left\">".$row[0].": ".$row[2]."\t(Comment-Level: ".$row[5].")</div>";
                echo "\n</div>";
                echo "<form action=\"../php_scripts/Send_Comment.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"file_id\" value=\"$file_id\"/>";
                $newparent = $row[3];
                $newlevel = intval($row[5]) + 1;
                echo "<input type=\"hidden\" name=\"parent\" value=\"$newparent\"/>";
                echo "<input type=\"hidden\" name=\"level\" value=\"$newlevel\"/>";
                echo "<textarea class=\"replybox\" name=\"comment\" rows=\"2\" cols=\"10\" wrap=\"hard\" placeholder=\"Add a Reply!\" required></textarea>";
                echo "\n<button class=\"reply\" type=\"submit\" value=\"Submit\" style=\"float:left\">Reply</button>";
                echo "</form>";
            }
            echo "\n</div>";
            
        }

        function getData($query) {
            $title = $query["file_title"];
            $owner = $query["file_owner"];
            $views = $query["view_count"];
            $type = $query["file_type"];
            $category = $query["category"];
            $keywords = $query["keywords"];
            $upload = $query["upload_date"];
            $size = $query["size"];
            echo "<div class=\"reveal\">";
            echo "\n    <div>Title: ".$title."</div>";
            echo "\n    <div>Owner: ".$owner."</div>";
            echo "\n    <div>View Count: ".$views."</div>";
            echo "\n    <div>File Type: ".$type."</div>";
            echo "\n    <div>Category: ".$category."</div>";
            echo "\n    <div>Keywords: ".$keywords."</div>";
            echo "\n    <div>Upload Date: ".$upload."</div>";
            echo "\n    <div>File Size: ".$size."</div>";
            echo "\n</div>";
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
        //echo ", '$video_path', '$video_name'";

        //$row = mysqli_fetch_all($sql_results);
        //return $row[0];

    //function display_comments($file_id, $conn, $num_comments){
        // idea here is to pass the id of the file to get the comments
        // Display could be limited by variable "num_comments" but haven't implemented it here                  
    //}
?>
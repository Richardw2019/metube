<?php
// function for stopping blocked people from viewing content
include 'prevent_blocked_view.php';
// grab a single video from database -- deprecated
function one_video($file_path, $width, $height){
    echo "<video width='$width' height='$height' controls>
            <source src='$file_path'>
            </video>";
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

// function to create video_grid for user viewing
function video_grid($conn){

    //if user searches for a specific category
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        echo "<br> Showing results for the category: ";
        $category = $_POST['category'];
        $file_type = $_POST['filetype'];
        $media_size = $_POST['file_size'];
        $search_string = $_POST['search_string'];
        $SortBy = $_POST['SortBy'];
        $SortOrder = $_POST['SortOrder'];
        echo "<h3> Debug! </h3>";
        echo "<br> Search string used: " . $search_string;
        echo "<br> category used: " . $category;
        echo "<br> file_type used: " . $file_type;
        echo "<br> max size wanted: " . $media_size;
        // Create a sql statement based on user selected params
        $base_statement = "SELECT file_path, file_title, id FROM Multimedia_Files WHERE size <= $media_size AND sharing_mode='public'";
        // Prevent the user from seeing blocked content
        if(!empty($_SESSION['logged_in_id'])){
            $base_statement = prevent_blocked_view($base_statement,True,$_SESSION['logged_in_id'], $conn);
            // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $base_statement";
        }
        if ($category!='all' AND $file_type='all'){
            $get_videos = "$base_statement AND category='$category'";
            if (!empty($search_string)){
                $get_videos = $get_videos . " AND ";
            }

        } elseif ($category='all' AND $file_type!='all'){
            $get_videos = "$base_statement AND file_type='$file_type'";
            if (!empty($search_string)){
                $get_videos = $get_videos . " AND ";
            }

        } elseif ($category!='all' AND $file_type!='all'){
            $get_videos = "$base_statement AND category='$category' AND file_type='$file_type'";
            if (!empty($search_string)){
                $get_videos = $get_videos . " AND ";
            }

        } elseif ($category='all' and $file_type='all'){
            $get_videos = "$base_statement";
            // Tac on WHERE if we plan on searching by words
            if (!empty($search_string)){
                $get_videos = $get_videos . " AND ";
            }
        }

        // Tac on the search by keyword part
        if (!empty($search_string)){
            // ########################
            // // Explode on commas
            // $search_array = explode(",", $search_string);
            // // Explode again on spaces
            // $search_array = explode(" ", $search_array);
            // ########################

            // Method to explode string first by commas and then by spaces
            $search_array = array_map(function($input_string) {
                return explode(",", $input_string);
            }, explode(" ", $search_string));
            print_r($search_array);
            // Trim the search array so they colon is not on it
            $get_videos = rtrim($get_videos, ";");
            echo "<br> Start of get_videos statement: " . $get_videos;
            // Counter for adding AND
            $i = 0;
            foreach ($search_array as $word){
                // 
                $word = $word[0];
                echo "<br> Word for searching: $word";
                if ($i == 0){
                    $get_videos = $get_videos . "(file_title RLIKE '$word' OR keywords RLIKE '$word' OR description RLIKE '$word'";
                    echo "<br> get_videos has been updated to: " . $get_videos;
                    $i++;
                } else {
                    $get_videos = $get_videos . " OR file_title RLIKE '$word' OR keywords RLIKE '$word' OR description RLIKE '$word'";
                    echo "<br> get_videos has been updated to: " . $get_videos;
                }
            }
            // Add final paranethesis and semi-colon
            $get_videos =  $get_videos . ")";
        }
        // Add sorting mechanism order
        $get_videos = $get_videos . " ORDER BY $SortBy $SortOrder";

        // Perform the query
        echo "<br> Final SQL Statement: $get_videos";
        $sql_results = mysqli_query($conn, $get_videos);

        if(mysqli_num_rows($sql_results) > 0){
            $row = mysqli_fetch_all($sql_results);
            foreach ($row as &$file_info){
                $extension_arr = explode(".", $file_info[0]);
                $extension = $extension_arr[count($extension_arr) - 1];
                echo "<h2> $file_info[1] </h2>";
                echo "This is the file of interest: $file_info[0]";
                echo "This is the file id: $file_info[2]";
                echo "<br>";

                echo "<form method='post' action = '../php_scripts/add_file_to_favorites.php'>
                <input type='hidden' name='extension' value='$extension'r/>
                <input type='hidden' name='file_path' value='$file_info[0]'r/>
                <input type='hidden' name='file_name' value='$file_info[1]'r/>
                <input type='hidden' name='file_id' value='$file_info[2]'r/>
                <input type='submit' value='Add to favorites'/>  </form> ";

                echo "<br>";
                echo "<form method='post' action = '../php_scripts/add_file_to_playlist.php'>
                <label for ='new_playlist'><b> Search for one of your created playlists to add this file to it: </b>
                <input type='text' placeholder='Playlist Name' name='playlist_name' required/>
                <input type='hidden' name='file_id' value='$file_info[2]'r/>
                <input type='hidden' name='extension' value='$extension'r/>
                <input type='submit' value='Add to Playlist'/>  </form>";

                echo "<br>";
                displayMedia($extension, $file_info[0]);

                echo "<br>";
                echo "<form method='post' action = '../php_scripts/goto_media.php'>
                <input type='hidden' name='file_id' value='$file_info[2]' r/>
                <input type='submit' value='Go to media page'/> </form>";

            }
        } else {
            echo "<h2> No videos found </h2>";
            echo "SQL Statement used: " . $get_videos;
        }


        // if ($_POST['filetype'] != "")
        // {
        //     echo "<br> Showing results for the file type: ";
        //     echo $_POST['filetype'];
        //     $category = $_POST['category'];
        //     $file_type = $_POST['filetype'];
        //     $get_videos = "SELECT file_path, file_title, id FROM Multimedia_Files WHERE category='$category'";
        //     $sql_results = mysqli_query($conn, $get_videos);
        //     $row = mysqli_fetch_all($sql_results);
        //     foreach ($row as &$file_info){
        //     $extension_arr = explode(".", $file_info[0]);
        //     $extension = $extension_arr[count($extension_arr) - 1];
        //     echo "<h2> $file_info[1] </h2>";
        //     echo "This is the file of interest: $file_info[0]";
        //     displayMedia($extension, $file_info[0]);
        //     echo "<br>";

        //     }
        // }
    }


    //else if user doesn't search for any category
    else 
    {
        $get_videos = "SELECT file_path, file_title, id FROM Multimedia_Files WHERE sharing_mode = 'public'";
        if(!empty($_SESSION['logged_in_id'])){
            $get_videos = prevent_blocked_view($get_videos,True,$_SESSION['logged_in_id'], $conn);
            // echo "<br> STATEMENT WITH THE BLOCKED CONTENT: $base_statement";
        }
        $sql_results = mysqli_query($conn, $get_videos);
        $row = mysqli_fetch_all($sql_results);
        foreach ($row as &$file_info){
            $extension_arr = explode(".", $file_info[0]);
            $extension = $extension_arr[count($extension_arr) - 1];
            echo "<h2> $file_info[1] </h2>";
            echo "This is the file of interest: $file_info[0]";
            echo "<br> This is the file id: $file_info[2]";
            
            echo "<br>";
            echo "<form method='post' action = '../php_scripts/add_file_to_favorites.php'>
            <input type='hidden' name='extension' value='$extension'r/>
            <input type='hidden' name='file_path' value='$file_info[0]'r/>
            <input type='hidden' name='file_name' value='$file_info[1]'r/>
            <input type='hidden' name='file_id' value='$file_info[2]'r/>
            <input type='submit' value='Add to favorites'/>  </form> ";
            
            echo "<br>";
            echo "<form method='post' action = '../php_scripts/add_file_to_playlist.php'>
            <label for ='new_playlist'><b> Search for one of your created playlists to add this file to it: </b>
            <input type='text' placeholder='Playlist Name' name='playlist_name' required/>
            <input type='hidden' name='file_id' value='$file_info[2]'r/>
            <input type='hidden' name='extension' value='$extension'r/>
            <input type='submit' value='Add to Playlist'/>  </form>";

            echo "<br>";
            displayMedia($extension, $file_info[0]);
        
            echo "<br>";
            echo "<form method='post' action = '../php_scripts/goto_media.php'>
            <input type='hidden' name='file_id' value='$file_info[2]' r/>
            <input type='submit' value='Go to media page'/> </form>";
        }
    }
}

?>
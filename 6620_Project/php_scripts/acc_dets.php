<?php
function displayMedia($extension, $path) {
    $height = 480;
    $audio_height = 30;
    $width = 775;
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
?>
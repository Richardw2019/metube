<?php

function prevent_blocked_view($base_sql_statement, $has_AND, $id_viewer, $conn){
    $get_blocked_ids = "SELECT user_id FROM Contact_List WHERE contact_id=$id_viewer AND block_status='Yes'";
    $get_blocked_usernames = "SELECT user_id FROM Users WHERE id IN";
    // echo $get_blocked_ids;
    // echo "<br>";
    $sql_results = mysqli_query($conn, $get_blocked_ids);
    if(mysqli_num_rows($sql_results)>0){
        $rows = mysqli_fetch_all($sql_results);
        // print_r($rows);
        if($has_AND==False){
            $base = $base_sql_statement . " WHERE file_owner NOT IN";
        } elseif($has_AND==TRUE) {
            $base = $base_sql_statement . " AND file_owner NOT IN ";
        }
        $id_cant_view = "(";
        foreach($rows as $row){
            $id_cant_view = $id_cant_view . "$row[0],";
        }
        $id_cant_view = rtrim($id_cant_view, ",");
        $id_cant_view = $id_cant_view . ")";
        $get_blocked_usernames = $get_blocked_usernames . $id_cant_view;
        // echo "<br> $get_blocked_usernames";

        // query to find usernames
        $sql_results_usernames = mysqli_query($conn, $get_blocked_usernames);
        $username_rows = mysqli_fetch_all($sql_results_usernames);
        // echo "<br>";
        // print_r($username_rows);

        // query for files
        $usernames_cant_view = "(";
        foreach($username_rows as $row){
            // print_r($row);
            $usernames_cant_view = $usernames_cant_view . "'$row[0]',";
        }
        $usernames_cant_view = rtrim($usernames_cant_view, ",");
        $usernames_cant_view .= ")";
        $final_query = $base . $usernames_cant_view;
        // echo "<br> $final_query";
    } else{
        $final_query = $base_sql_statement;
    }

    return($final_query);
    
}
    
// include '../php_scripts/db_connect.php';
// $base = "SELECT * FROM Multimedia_Files";
// $debug_query = prevent_blocked_view($base,False,8,$conn);
// echo "<br> DEBUG QUERY: $debug_query";
?>
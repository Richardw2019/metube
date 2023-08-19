<?php
function display_table($data) {
    $output = '<table>';
    $output = $output .  "<th> ID </th>";
    $output = $output . "<th> Username </th>";
    $output = $output . "<th> link to channel </th>";

    foreach($data as $key => $var) {
        $output = $output . '<tr>';
        foreach($var as $k => $v) {
            if ($key === 0) {
                continue;
            } else {
                $output = $output . '<td>' . $v . '</td>';
            }
        }
        $output = $output . '</tr>';
    }
    $output = $output . '</table>';
    echo $output;
}

include "../php_scripts/db_connect.php";
$get_users = "SELECT id, user_id FROM Users";
$sql_results = mysqli_query($conn, $get_users);
$rows = mysqli_fetch_all($sql_results);
$i=0;
foreach($rows as $row){
    $rows[$i][2] = "<a href=" . "../project_template_page/MeTube_Channel.php?username=" . $row[1] . "> Link to channel </a>";
    $i++;
}

display_table($rows);
$conn->close();


?>
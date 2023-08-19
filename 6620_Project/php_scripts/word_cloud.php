<?php

function WordCloud($conn){
    $sql_query_1 = "SELECT file_title FROM Multimedia_Files";
    $sql_query_2 = "SELECT REPLACE(keywords,',',' ') FROM Multimedia_Files";
    $results_1 = mysqli_query($conn, $sql_query_1);
    $results_2 = mysqli_query($conn, $sql_query_2);
    $rows_1 = mysqli_fetch_all($results_1);
    $rows_2 = mysqli_fetch_all($results_2);
    $all_words_1 = [];
    $all_words_2 = [];
    foreach($rows_1 as $row){
        foreach($row as $innerrow){
            $exp_step = explode(" ", $innerrow);
            foreach($exp_step as $word){
                $word = rtrim($word, ")");
                $all_words_1 = array_merge($all_words_1, $exp_step);
            }
            // echo implode(" ",$exp_step);
            $all_words_1 = array_merge($all_words_1, $exp_step);
        }
    }
    print_r($all_words_1);
    echo "<br>";
    // foreach($rows_2 as $row){
    //     echo "<br>";
    //     // print_r($row);
    //     echo "<br>";
    //     // $exp_step = explode(" ", $row[0]);
    //     // print_r($row);
    //     foreach($row as $words){
    //         $exp_step = explode(" ", $words);
    //         // print_r($exp_step);
    //         foreach($exp_step as $word){
    //             echo $word;
    //             $all_words_2 = array_merge($all_words_2, $word);
    //         }
    //         // $all_words_2 = array_merge($all_words_2, $exp_step);
    //     }
    //         // // echo implode(" ",$exp_step);
    //         // $all_words_2 = array_merge($all_words_2, $exp_step);
    // }
    // print_r($all_words_2);

print_r(count($all_words_1));
echo "<p>";
	for($i=0;$i<count($all_words_1);$i=$i+2){
		$count=$all_words_1[$i+1];
		echo "<br>";
        echo $all_words_1[$i];
		echo $count;

	}
	echo "</p>";
}



?>
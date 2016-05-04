<?php
header('Content-type: text/xml');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

echo '<xml>';
include "resources/php/functions.php";
connect_db();
$string = "select * from movies ORDER BY dateAdded desc";
$result = $connection->query($string);

if ($result->num_rows > 0)
    $array["movieCount"]  = $result->num_rows;
    while($row = $result->fetch_row()){

//
        echo "<movie>
                <title>" . htmlentities($row[0]) ."</title>
              <genre>" . htmlentities($row[3]) ."</genre>
              <plot>" . htmlentities($row[4]) ."</plot>
              <actors>" . htmlentities($row[5]) ."</actors>
              <imdbScore>" . htmlentities($row[6]) ."</imdbScore>
              <youtube>" . htmlentities($row[11]) ."</youtube>";
        //        get comments for specific movie
        $query = "select commentText from comments where title='$row[0]'";
        $comments = $connection->query($query);
        $commentsStr = "";
        while($comment = $comments->fetch_row()){
            $commentsStr = $commentsStr . $comment[0] . "-,-";
        }
        echo "<comments>" . $commentsStr . "</comments>";
              echo "</movie>";
    }

echo '</xml>';
?>
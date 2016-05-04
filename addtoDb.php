<?php
include "resources/php/functions.php";
connect_db();
if(!isUserAdmin($_COOKIE["username"])){
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    die();
}
//$_POST = urldecode($_POST);
extract($_POST);
extract($values);
$Title = trim($values[0]);
$RunTime = trim($values[1]);
$Genre = trim($values[2]);
$Plot = trim($values[3]);
$Actors = trim($values[4]);
$imdbRating = trim($values[5]);
$imdbID = trim($values[6]);
$Poster = trim($values[7]);
$Trailer = trim($values[8]);

if(sizeof($Title)!=0){
    global $connection;
    $Plot = str_replace("'","-",$Plot);
    $Title = str_replace("&","and",$Title);
    $videoID = str_replace("https://www.youtube.com/watch?v=","",$Trailer);
    $Trailer = str_replace("watch?v=","embed/",$Trailer);
    $Trailer = $Trailer . "?autoplay=1&controls=0&iv_load_policy=3&showinfo=0&rel=0&loop=1&playlist=" . $videoID;
    //basicly autoplay, disable controls which are annoying, disable annotions, disable video suggestions at the end,and loop because why not?,playlist trick
//    in order to get loop working.
    $str = "INSERT INTO movies (Title, Year, Runtime, Genre, Plot, Actors, imdbRating, Metascore, Poster, imdbID, Trailer)
VALUES('$Title','$Year','$Runtime','$Genre','$Plot','$Actors','$imdbRating','$Metascore','$Poster','$imdbID','$Trailer');";
    $result = $connection->query($str);
//  download actor images
    $Actors2 = split(",",$Actors);
//  delete if directory exist
    if (!file_exists("resources/img/Stars/")) {
        mkdir("resources/img/Stars/");
    }

    for($i=0;$i<count($Actors2);$i++){
        if(!file_exists("resources/img/Stars/" . $Actors2[$i])){
            file_put_contents("resources/img/Stars/" .$Actors2[$i] . ".jpg", file_get_contents(getProfilePic($Actors2[$i])));
        }
    }
//  get movie wallpaper
    $wall_url = getWallpaper($Title);
    file_put_contents("resources/img/$Title/wall.jpg",file_get_contents($wall_url));
// ticket implementation, disabled.
    if(false){
        $i = 1;
        do{
            $str = "INSERT INTO tickets(imdbID, seatNumber, boughtBy, isEmpty)
VALUES('$imdbID','$i',null,TRUE);";
            $i = $i +1;//somehow ++ not worked
            $connection->query($str);
        }while($i<=48);
    }

    echo "<meta http-equiv='refresh' content='0;url=details.php?movie=" . trim($values[0]) ."''>";
}else{
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
}
?>
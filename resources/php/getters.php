<?php

//todo simpfly all those get methods
function getTitle(){
    global $current_movie;
    echo $current_movie[0];
}

function getTitleStr(){
    global $current_movie;
    return $current_movie[0];
}

function getImage(){
    global $current_movie;
    echo $current_movie[8];
}

function getPlot(){
    global $current_movie;
    echo $current_movie[4];
}

function getPlotStr(){
    global $current_movie;
    return $current_movie[4];
}

function getYear(){
    global $current_movie;
    return $current_movie[1];
}
function getRunTime(){
    global $current_movie;
    echo $current_movie[2];
}
function getGenre(){
    global $current_movie;
    return $current_movie[3];
}
function getActors(){
    global $current_movie;
    return $current_movie[5];
}
function getImdbRating(){
    global $current_movie;
    echo $current_movie[6];
}

function getImdbRatingStr(){
    global $current_movie;
    return $current_movie[6];
}
function getMetaScore(){
    global $current_movie;
    return $current_movie[7];
}

function getTrailer(){
    global $current_movie;
    echo $current_movie[11];
}

function getImdbID(){
    global $current_movie;
    return $current_movie[9];
}

function getBoxStr($isEmpty,$id){
    if(!$isEmpty){
        $flag  = "checked disabled readonly";
    }else{
        $flag = "";
    }
    $str =
        "<label class=\"mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect\">
            <input type='checkbox' id='seatNo". $id."' class=\"mdl-checkbox__input\"". $flag .">
         </label>";
    return $str;
}

function getInputStr($type,$name,$value){
    echo "<div class=\"mdl-textfield mdl-js-textfield mdl-textfield--floating-label\">
     <input class=\"mdl-textfield__input\" type=\"$type\" name=\"$name\" value=\"$value\">
     <label class=\"mdl-textfield__label\" for=\"$name\">$name</label>
     </div>";
}

function getYoutube(){
    require_once 'includes/Google/autoload.php';
    require_once 'includes/Google/Client.php';
    require_once 'includes/Google/Service/YouTube.php';
    global $youtube_api_key;
    $client = new Google_Client();
    $client->setDeveloperKey($youtube_api_key);
    $youtube = new Google_Service_YouTube($client);
    $dummy = "Title";
    global $imdb;
    $title = $imdb->$dummy;
    $str =   $title . " Official Trailer";
    $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $str,
        'maxResults' => 1));
    $videos = '';
    foreach ($searchResponse['items'] as $searchResult) {
        switch ($searchResult['id']['kind']) {
            case 'youtube#video':
                $videos .= ($searchResult['id']['videoId']);
                break;
        }
    }
    echo $videos;
}

function getMovie(){
    global $current_movie;
    global $movies;
    if($current_movie = $movies->fetch_row())
        return true;
    else
        return false;
}

function getPoster(){
    global $imdb;
    $poster = "Poster";
    $poster = $imdb->$poster;
    $title = "Title";
    $title = $imdb->$title;
    $folder_name  = "resources/img/" . $title;
    mkdir($folder_name, 0777, true);
    file_put_contents($folder_name . "/poster.jpg", file_get_contents($poster));
    echo $folder_name . "/poster.jpg";
}
?>
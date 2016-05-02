<?php

include "config.php";
include "variables.php";
include "getters.php";

    function connect_db(){
        global $username;
        global $password;
        global $server;
        global $database;
        global $connection;
        global $movies;
        $connection = new mysqli($server, $username, $password,$database);
        if ($connection->connect_error){
            return false;
        }
        $query = "select * from movies ORDER by dateAdded DESC ;";
        $movies = $connection->query($query);
    }

    function moviesOf($actor){
        global $connection;
        $str = "";
        $query = "SELECT Title FROM movies WHERE Actors LIKE '%$actor%';";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_row()){
                $str .= $row[0] . "<br>";
            }
        }
        return $str;
    }

    function deleteMovie($title){
        global $connection;
        $str = "select imdbID from movies where Title='$title'";
        $result = $connection->query($str);
        $dummy = $result->fetch_row();
        $imdb_id = $dummy[0];
        $delete_movies = "DELETE FROM movies WHERE Title='$title';";
        $connection->query($delete_movies);
        $delete_tickets = "DELETE FROM tickets WHERE imdbID='$imdb_id';";
        $connection->query($delete_tickets);
        array_map('unlink', glob("resources/img/$title/*.*"));
        rmdir("resources/img/$title/");
        unlink("json/" . $title . ".json");

    }

    function getActorDetails($name){
        global $moviedb_api_key;
        $name = str_replace(" ","+",$name);
        $string = file_get_contents("http://api.themoviedb.org/3/search/person?api_key=". $moviedb_api_key.  "&query=" . $name);
        $string = json_decode($string);
        $string = $string->results[0]->id;
        $name = str_replace("+", "-", $name);
        $name  = strtolower($name);
        $url = "https://www.themoviedb.org/person/" . $string . "-" . $name;
        $doc = new DomDocument();
        $doc->loadHTMLFile($url);
        $thediv = $doc->getElementById('biography');

        $res  = $thediv->textContent;
        $res = str_replace("'","&lsquo;",$res);
        $res = substr($res,0,700);
        $res = $res . "...";
        $res = $res . "<br><a href='$url' target='_blank'>Click Here to read more</a>";
        return $res;
    }

    function getProfilePic($name){
        global $moviedb_api_key;
        $name = str_replace(" ","+",$name);
        $string = file_get_contents("http://api.themoviedb.org/3/search/person?api_key=". $moviedb_api_key.  "&query=" . $name);
        $string = json_decode($string);
        $string = $string->results[0]->profile_path;
        $string = str_replace("/","",$string);
        return "http://image.tmdb.org/t/p/w185/$string";
    }

    function getWallpaper($name){
        global $moviedb_api_key;
        $name = str_replace(" ","%20",$name);
        $string = file_get_contents("http://api.themoviedb.org/3/search/movie?api_key=". $moviedb_api_key.  "&query=" . $name);
        $string = json_decode($string);
        $string = $string->results[0]->backdrop_path;
        return "https://image.tmdb.org/t/p/w780$string";
    }

    function loadImdb($title){
        global $imdb;
        $title = str_replace(' ', '%20', $title);
        if($title[0]=='t' and $title[1]=='t'){
            $json=file_get_contents("http://www.omdbapi.com/?i=" . $title);
        }else{
            $json=file_get_contents("http://www.omdbapi.com/?t=" . $title);
        }
        $imdb=json_decode($json);
    }

    function displayDetailImdb($detailName=null){
        global $imdb;
        if($detailName==null){
            print_r($imdb);
        }else
        echo $imdb->$detailName;
    }

    function check_user($username,$password){
        global $connection;
        $sql = "SELECT username,password,name,surname FROM users
                WHERE username = '".$username."' AND password = '". $password  ."';";
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_row()){
                global $current_user;
                $current_user[1] = $username;
                $current_user[2] = $password;
                $current_user[3] = $row[2];
                $current_user[4] = $row[3];
            }
            return true;
        }
        return false;
    }

    function addCookie($username,$password){
        setcookie("username",$username,time()+300);
        setcookie("password",md5($password),time()+300);
    }

    function deleteCookies(){
        setcookie("user", "", time() - 3600);
    }

    function isMovieFound(){
        global $imdb;
        $str = "Title";
        if(strlen($imdb->$str)>0){
            return true;
        }else{
            return false;
        }
    }

    function addUser($username,$password,$name,$surname){
        global $connection;
//      check if username exists
        $query = "select username,password from users where username='" . $username . "';";
        $result = $connection->query($query);
        if($result->num_rows > 0){
            return false;
        }
//      normal user add
        $password = md5($password);
        $query = "INSERT INTO users (username,password,name,surname,type)
        VALUES ('$username','$password','$name','$surname',1)";
        $connection->query($query);
        return true;
    }

    function isUserAdmin($username){
        global $connection;
        if(isset($_COOKIE['username'])){
            $query = "select * from users where username='" . $username . "' and type=2";
            $result = $connection->query($query);
            if($result->num_rows >0){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    function selectMovie($movieName){
        global $current_movie;
        global $movies;
        if (strcmp($current_movie[0],$movieName)==0)
            return true;
        else{
            do{
                $temp = $movies->fetch_row();
                if(strcmp($temp[0],$movieName)==0){
                    $current_movie = $temp;
                    return true;
                }
                if($temp == false){
                    return false;
                }

            }while(strcmp($current_movie[0],$movieName));
        }
        return false;
    }

    function changePW($username,$newPassword){
        global $connection;
        $newPassword = md5($newPassword);
        $query = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
        $connection->query($query);
        setcookie("username","");
        setcookie("password","");
    }

    function consoleLog($str){
        echo "<script>console.log('$str')</script>";
    }

    function getComments($title){
        global $connection;
        $str = "";
        $query = "SELECT * from comments WHERE title='$title' and published=1";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_row()){
                if(isUserAdmin($_COOKIE["username"])){
                    $str .= "<tr><td><h5>$row[1]</h5>$row[2]</td><td style='text-align: right'>$row[3]</td><td style='padding-left: 10px'><input type='button' name='deleteComment' value='X' onclick='deleteComment($row[4])'/></td></tr>";
                }else{
                    $str .= "<tr><td><h5>$row[1]</h5>$row[2]</td><td style='text-align: right'>$row[3]</td></tr>";
                }
            }
        }else{
            $str = "<tr><td>No comments</td></tr>";
        }
        return $str;
    }

    function deleteComment($commentId){
        global $connection;
        $str = "delete from comments WHERE id=" . $commentId;
        $connection->query($str);
    }

    function addComment($movie,$title,$comment){
        global $connection;
        $ip = $_SERVER['REMOTE_ADDR'];
        $str = "insert into comments(title, commentName, commentText,ip) VALUES('$movie','$title','$comment','$ip')";
        $connection->query($str);

    }

    function getApprovalList(){
        global $connection;
        $query = "select * from comments";
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_row()){
                if($row[5])
                    $type = "no";
                else
                    $type = "yes";
                echo "<tr><td>$row[0]</td><td>$row[1]</td><td style='width: 200px'>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>" .
                    "<input type='button' value='$type' name='$type' onclick=''/>"
                    . "</td><td>-</td><td>$row[6]</td></tr>";
            }
        }
    }

    function publishComment($flag = true, $commentId){
        global $connection;
        if($flag){
            $str  = "UPDATE comments SET  published =  '1' WHERE id =$commentId";
        }else{
            $str  = "UPDATE comments SET  published =  '0' WHERE id =$commentId";
        }
        $connection->query($str);
    }

?>
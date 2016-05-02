<?php
ob_start();
 if(isset($_POST["writeFile"])){
     $res = "
     <?php
      \$username = \"{$_POST["username"]}\";\n
      \$password = \"{$_POST["password"]}\";\n
      \$database = \"{$_POST["databaseName"]}\";\n
      \$server = \"{$_POST["databaseServer"]}\";\n
      \$youtube_api_key = \"{$_POST["googleApiKey"]}\";\n
      \$moviedb_api_key = \"{$_POST["themovieDBApi"]}\";\n
      \$cookieTimeout = \"{$_POST["cookieTimeOut"]}\";\n
     ?>
     ";
  file_put_contents("../resources/php/config.php",$res);

  include "../resources/php/functions.php";
  connect_db();

//  drop tables if exist, in case of corruption. Seperate in case of any of them available.
  $sql = "drop table movies";
  $connection->query($sql);
  $sql = "drop table users";
  $connection->query($sql);
  $sql = "drop table comments";
  $connection->query($sql);
  //  creating tables
  $comments_table = "CREATE TABLE IF NOT EXISTS `comments` (
  `title` varchar(3000) DEFAULT NULL,
  `commentName` varchar(200) DEFAULT NULL,
  `commentText` varchar(3000) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `published` int(11) DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;";
  $connection->query($comments_table);
  $movies_table = "CREATE TABLE IF NOT EXISTS `movies` (
  `Title` varchar(100) DEFAULT NULL,
  `Year` varchar(20) DEFAULT NULL,
  `Runtime` varchar(15) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `Plot` varchar(500) DEFAULT NULL,
  `Actors` varchar(300) DEFAULT NULL,
  `imdbRating` varchar(20) DEFAULT NULL,
  `Metascore` varchar(20) DEFAULT NULL,
  `Poster` varchar(100) DEFAULT NULL,
  `imdbID` varchar(15) NOT NULL,
  `dateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Trailer` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`imdbID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
  $connection->query($movies_table);
  $users_table = "CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `type` int(11) DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
  ";
  $connection->query($users_table);
//  table creation done, now adding admin account
  $default_user = "INSERT INTO `users` (`user_id`, `username`, `password`, `name`, `surname`, `type`) VALUES
  (1, '". $_POST["adminUsername"] ."', '". md5($_POST["adminPassword"]) . "', 'admin', 'admin', 2)";
  $connection->query($default_user);

// random movie(best one), shawshank redemption
  $best_movie = "INSERT INTO `movies` (`Title`, `Year`, `Runtime`, `Genre`, `Plot`, `Actors`, `imdbRating`, `Metascore`, `Poster`, `imdbID`, `dateAdded`, `Trailer`) VALUES
('The Shawshank Redemption', '', '', 'Crime, Drama', 'Two imprisoned men bond over a number of years, " .
      "finding solace and eventual redemption through acts of common decency.', 'Tim Robbins, Morgan Freeman, Bob Gunton, William Sadler', '9.3', '',".
      " 'resources/img/The Shawshank Redemption/poster.jpg', 'tt0111161', '2016-04-16 12:52:10',".
      " 'https://www.youtube.com/embed/NmzuHjWmXOc?autoplay=1&controls=0&iv_load_policy=3&showinfo=0&rel=0&loop=1&playlist=NmzuHjWmXOc')";
  $connection->query($best_movie);
//  logging in admin, setting cookies
  setcookie("username",$_POST["adminUsername"],time()+300);
  setcookie("password",md5($_POST["adminPassword"]),time()+300);
  //  permissions...
  chmod("resources/img/", 700);
  chmod("resources/img/Stars", 700);
  chmod("setup/index.php", 700);
  chmod("resources/php/functions.php", 700);
// end of permisions
  echo "<meta http-equiv='refresh' content='0;url=done.html'>";
  file_put_contents("index.php","There' some error in tables.You can't use setup to recreate tables. Setup meant to be run only once for security, fix database issues yourself.
  <br>Ps: You can still download this file from source and re-use setup. Just don't forget it will wipe ALL data");
  die();
 }
?>

<html>
<head>
  <title>Cinema Project Setup</title>
 <style>
  th{
   text-align: center;
  }
 </style>
 <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
 <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,400italic,700,700italic' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="//storage.googleapis.com/code.getmdl.io/1.0.1/material.teal-red.min.css" />
 <script src="//storage.googleapis.com/code.getmdl.io/1.0.1/material.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
</head>
<body>
<center>
 <h2>Welcome to setup</h2>
 <h4>You need to give proper information in order to set system.</h4>
 <h4>Every data is mandatory!</h4>
 <form method="post" action="index.php">
 <table>
  <th colspan="2">Connection settings</th>

  <tr><td>Database username : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="username" />
     <label class="mdl-textfield__label" for="username"></label>
    </div>
   </td></tr>
  <tr><td>Database password : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="password" name="password" />
     <label class="mdl-textfield__label" for="password"></label>
    </div>
   </td></tr>
  <tr><td>Database name : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="databaseName" />
     <label class="mdl-textfield__label" for="databaseName"></label>
    </div>
   </td></tr>
  <tr><td>Database server : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="databaseServer" value="localhost"/>
     <label class="mdl-textfield__label" for="databaseServer"></label>
    </div>
   </td></tr>
  <th colspan="2">Admin User</th>
   <tr><td>Admin username : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="adminUsername"/>
     <label class="mdl-textfield__label" for="adminUsername"></label>
   </div>
   </td></tr>
  <tr><td>Admin password : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="password" name="adminPassword" />
     <label class="mdl-textfield__label" for="adminPassword"></label>
    </div>
   </td></tr>
  <th colspan="2">API Settings</th>
  <tr><td>Google API Key : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="googleApiKey"/>
     <label class="mdl-textfield__label" for="googleApiKey"></label>
    </div>
   </td><td><a href="https://developers.google.com/youtube/v3/getting-started#intro" target="_blank">?</a></td></tr>
  <tr><td>TheMovieDB.org API Key : </td><td>
    <div class="mdl-textfield mdl-js-textfield">
     <input class="mdl-textfield__input" type="text" name="themovieDBApi"/>
     <label class="mdl-textfield__label" for="themovieDBApi"></label>
    </div>
   </td><td><a href="https://www.themoviedb.org/documentation/api" target="_blank">?</a> </td></tr>
  <tr><td colspan="2" style="border:1px solid black">
    <button class="mdl-button mdl-js-button mdl-js-ripple-effect" type="submit" name="writeFile" style="width: 100%">
     Save Changes
    </button>
   </td></tr>
 </table>
 </form>
 <h4>This will wipe all data in users,movies,comments tables in selected database</h4>
</center>
<?php
//todo
?>
</body>
</html>

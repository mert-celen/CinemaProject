<?php

$flag = false;
include "resources/php/functions.php";
ob_start();
$isConnected = connect_db();
if($isConnected){
    echo "<meta http-equiv='refresh' content='0;url=setup/index.php'>";
    die();
}
//Check if db is correct or not
$result = $connection->query("show tables;");
if($result->num_rows==0){
    echo "<meta http-equiv='refresh' content='0;url=setup/index.php'>";
    die();
}
//end of check, if success continue
    if(isset($_COOKIE["username"],$_COOKIE["password"])){
        if(check_user($_COOKIE["username"],$_COOKIE["password"])){
            global $flag;
            $flag= true;
        }else{
            unset($_COOKIE['username']);
            unset($_COOKIE['password']);
        }
    }
?>
<html>
<head>
    <title>MertCinemas Online Ticket System</title>
    <meta charset="ISO-8859-1">
    <link rel="stylesheet" href="includes/cssreset.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,500,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//storage.googleapis.com/code.getmdl.io/1.0.1/material.teal-red.min.css" />
    <script src="//storage.googleapis.com/code.getmdl.io/1.0.1/material.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">

    <link rel="stylesheet" href="resources/css/style.css">
    <script src="resources/js/scripts.js"></script>

</head>
<body>
<div id="header">
    <a href="index.php">
        <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
            Home
        </button>
    </a>
    <?php if(!$flag) :?>
        <a href="register.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Register
            </button>
        </a>
        <a href="login.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Login
            </button>
        </a>
    <?php else : ?>
        <a href="account.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                My Account
            </button>
        </a>
        <a href="logout.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Logout
            </button>
        </a>
    <?php endif;?>

    <?php if(isUserAdmin($_COOKIE["username"])): ?>
        <a href="add.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Add Movie
            </button>
        </a>
        <a href="edit.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Edit Movie
            </button>
        </a>
        <a href="comments.php">
            <button class="mdl-button mdl-js-button mdl-js-ripple-effect">
                Comments
            </button>
        </a>
    <?php endif;?>
<!--    <div id="search">-->
<!--        <form action="people.php" method="get">-->
<!--        <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">-->
<!--            <label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">-->
<!--                <i class="material-icons">search</i>-->
<!--            </label>-->
<!--            <div class="mdl-textfield__expandable-holder">-->
<!--                <input class="mdl-textfield__input" type="text" id="sample6" name="keyword">-->
<!--            </div>-->
<!--        </div>-->
<!--        </form>-->
<!--    </div>-->
</div>
<?php
if(isset($_POST["username"],$_POST["password"])){
    setcookie("username",$_POST["username"],time()+86000);
    setcookie("password",md5($_POST["password"]),time()+86000);
}
include "header.php"; ?>

<?php
    if(isset($_POST["username"])){
        if(check_user($_POST["username"],md5($_POST["password"]))){
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }else{
            echo "<center><span style='border: 1px solid red;background: red'>login failed!</span> </center>";
        }
    }
?>
    <center>
    <form action="login.php" method="post">
        <br>
        <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-textfield__input" type="text" name="username" />
            <label class="mdl-textfield__label" for="username">Username</label>
        </div>
        <br>
        <div class="mdl-textfield mdl-js-textfield">
            <input class="mdl-textfield__input" type="password" name="password"/>
            <label class="mdl-textfield__label" for="userpass">Password</label>
        </div>
        <div class="mdl-card__actions mdl-card--border">
            <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Log in</button>
        </div>
    </form>
    </center>
<?php  include "footer.php"; ?>
<?php
include "header.php";
ob_start();
?>
<div id="account">

<h3>Change Password</h3><br><br>
    <?php
    if(isset($_POST["oldPass"]) and isset($_POST["newPass"])){
        if(check_user($_COOKIE["username"],md5($_POST["oldPass"]))){
            changePW($_COOKIE["username"],$_POST["newPass"]);
            echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        }else{
            echo "Wrong password!";
        }
    }
    ?>
<form action="account.php" method="post" id="pwChange">
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label left">
        <input class="mdl-textfield__input" type="password" name="oldPass">
        <label class="mdl-textfield__label" for="oldPass">Old password</label>
    </div><br>
    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label left">
        <input class="mdl-textfield__input" type="password" name="newPass"">
        <label class="mdl-textfield__label" for="newPass">New password</label>
    </div>
    <div class="mdl-card__actions left">
        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Change Password</button>
    </div>
</form>
</div>
<?php  include "footer.php"; ?>

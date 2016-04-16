<?php  include "header.php"; ?>
<center>
    <?php if(isset($_POST["usernameReg"])){
        if(addUser($_POST["usernameReg"],$_POST["passwordReg"],$_POST["name"],$_POST["surname"])){
            echo "User successfully added!";
        }else{
            echo "Username exist!";
        }
    }

    ?>
<form action="register.php" method="post">
    <br>
    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" name="usernameReg" />
        <label class="mdl-textfield__label" for="username">Username</label>
    </div>
    <br>
    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="password" name="passwordReg"/>
        <label class="mdl-textfield__label" for="password">Password</label>
    </div>
    <br>
    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" name="name"/>
        <label class="mdl-textfield__label" for="name">Name</label>
    </div>
    <br>
    <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" name="surname"/>
        <label class="mdl-textfield__label" for="surname">Surname</label>
    </div>
    <br>
    <div class="mdl-card__actions mdl-card--border">
        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Register</button>
    </div>
</form>
</center>
<?php  include "footer.php"; ?>

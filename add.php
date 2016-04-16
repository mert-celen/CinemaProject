<?php
    include "header.php";
    connect_db();
    if(!isUserAdmin($_COOKIE["username"])){
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        die();
    }

    if(isset($_POST['name'])){
        loadImdb($_POST['name']);
    }
?>

<script>
$(function(){
    $("#addMovie").click(function(){
        $("#loading").css("visibility","visible");
        $("#addMovieFrame").css("margin","0px").css("padding","0px");
        $("#setBlur").addClass("loadingBlur").css("visibility","visible");

        var values = [$("#Title").val(),
        $("#RunTime").val(), $("#Genre").val(), $("#Plot").val(), $("#Actors").val(),
            $("#imdbRating").val(), $("#imdbID").val(),$("#Poster").val(), $("#Trailer").val()];
        $.ajax({
                type: "POST",
                url: "addtoDb.php",
                data: { values:values }
            })
            .done(function( msg ) {
                $("#loading").css("visibility","hidden");
                $("#setBlur").removeClass("loadingBlur").css("visibility","hidden");
                $("#loading").html(msg);
            });
    });
});

</script>
<div id="addMovieFrame">
    <div id="setBlur" style="visibility: hidden">
       <div id="loading" class="mdl-spinner mdl-js-spinner is-active"></div>
        <center><h1>Adding movie...</h1></center>
    </div>
<form action="add.php" method="post">
    <table><tr><td>
    <div class="mdl-textfield mdl-js-textfield left">
        <input class="mdl-textfield__input" type="text" name="name" value="<?php
        if(isset($_POST['name']) and isMovieFound()) {
            displayDetailImdb("Title");
        }
        ?>"/>
        <label class="mdl-textfield__label" for="name">Movie Title or IMDB ID</label>
    </div></td><td>
    <div class="mdl-card__actions left">
        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Fetch from IMDB</button>
    </div></td></tr>
    </table>
</form>
    <?php if(isset($_POST['name']) and isMovieFound()): ?>
        <table>
            <tr>
                <td>
                    <img src="<?php getPoster() ?>" />
                </td>
                <td style="vertical-align: top;padding-left: 30px">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="Title" id="Title" value="<?php displayDetailImdb("Title")?>">
                            <label class="mdl-textfield__label" for="Title">Title</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="Runtime" id="RunTime" value="<?php displayDetailImdb("Runtime")?>">
                            <label class="mdl-textfield__label" for="Runtime">Runtime</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="Genre" id="Genre" value="<?php displayDetailImdb("Genre")?>">
                            <label class="mdl-textfield__label" for="Genre">Genre</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 150px">
                            <input class="mdl-textfield__input" type="text" name="imdbRating" id="imdbRating" value="<?php displayDetailImdb("imdbRating")?>">
                            <label class="mdl-textfield__label" for="imdbRating">Imdb Rating</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 150px">
                            <input class="mdl-textfield__input" type="text" name="Metascore" id="Metascore" value="<?php displayDetailImdb("Metascore")?>">
                            <label class="mdl-textfield__label" for="Metascore">Metascore</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 600px">
                            <input class="mdl-textfield__input" type="text" name="Plot" id="Plot" value="<?php displayDetailImdb("Plot")?>">
                            <label class="mdl-textfield__label" for="Plot">Plot</label>
                        </div>
                        <br>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 600px">
                            <input class="mdl-textfield__input" type="text" name="Actors" id="Actors" value="<?php displayDetailImdb("Actors")?>">
                            <label class="mdl-textfield__label" for="Actors">Actors</label>
                        </div>
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" name="Trailer" id="Trailer" value="https://www.youtube.com/watch?v=<?php getYoutube()?>" style="width: 600px">
                            <label class="mdl-textfield__label" for="Trailer">Trailer url</label>
                        </div>
                        <br>

                        <input type="hidden" name="imdbID" id="imdbID" value="<?php displayDetailImdb("imdbID")?>"><br>
                        <input type="hidden" name="Poster" id="Poster" value="<?php getPoster()?>">
                        <div class="mdl-card__actions left">
                            <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="button" id="addMovie">Add This Movie</button>
                        </div>
                </td>
            </tr>
        </table>
    <?php elseif (isset($error)) : ?>
        Movie not found, sorry.
    <?php endif;?>
</div>




<?php
    include "footer.php";
?>

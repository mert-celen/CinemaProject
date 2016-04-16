<?php
include "header.php";
?>
    <?php if(!selectMovie($_GET['movie'])) : ?>
        <meta http-equiv='refresh' content='0;url=index.php'>
    <?php else : ?>
<?php

    if(isUserAdmin($_COOKIE["username"])){
        echo "
        <script>
        function deleteComment(commentId){
           $.ajax({
                type: \"POST\",
                url: \"comments.php\",
                data: { deleteComment:commentId }
           })
           .done(function( msg ) {
                alert(\"Comment deleted!\");
           });
        };
</script>
        ";
    }

?>
<script>
    function addComment(){
        title = $("#addCommentTitle").val();
        text =  $("#addCommentText").val();
        movie_name = $("#movieName").html();
        console.log(title + "," + text + "," + movie_name);
        $.ajax({
                type: "POST",
                url: "comments.php",
                data: { addComment:"true", title:title,comment:text,movie:movie_name}
            })
            .done(function( msg ) {
                alert("Your comment will be published after approval!");
            });
    };
</script>
    <div id="trailer">
        <span style="visibility: hidden" id="youtubeUrl"><?php getTrailer(true);?></span>
    </div>
    <div id="movie">
            <div id="movieInformation" style="height: 600px;">
                <div>
                    <table>
                        <tr>
                            <td width="400px" style="vertical-align: top">
                                <h2 id="movieName"><?php getTitle()?></h2>
                                <h5><?php getRunTime()?></h5>
                                <div id="imdbRating">
                                    <?php getImdbRating()?>
                                </div>

                                <div style="width: 600px; font-family: 'Roboto'">
                                    <h4><?php getPlot()?></h4>
                                </div>
                            </td>
                            <td onclick="displayTrailer(true)" class="trailerBox">
                                <i class="material-icons" style="color: white;position: absolute;font-size: 150px;top: 240px;left: 950px">play_circle_filled</i>
                                <img src="resources/img/<?php getTitle()?>/wall.jpg">
                            </td>
                        </tr>
                    </table>
                </div>
                <table>
                    <?php
                    $actors = getActors();
                    $actors = explode(",",$actors);
                    for($i=0;$i<4;$i++){
                        echo "<td style='text-align: center;font-weight: bold'>$actors[$i]</td>";
                    }
                    ?></tr>
                    <tr>
                        <?php
                        $actors = getActors();
                        $actors = explode(",",$actors);
                        for($i=0;$i<4;$i++){
                            echo "<td id='actors'><a href='people.php?name=$actors[$i]'> <img src='resources/img/Stars/" . $actors[$i] . ".jpg' /></a></td>";
                        }
                        ?>
                    </tr>
                </table>
                <table>
                        <th><h2>Comments</h2></th>
                        <tr><td>Title : </td><td><input id="addCommentTitle" type="text" name="title"></td></tr>
                        <tr><td>Comment : </td><td><input id="addCommentText" type="text" name="comment"></td></tr>
                        <tr><td rowspan="2" style="text-align: center"><input type="button" name="addComment" value="Add Comment" onclick="addComment()"></td></tr>
                    <?php
                        echo getComments($_GET['movie']);
                    ?>
                </table>
                <br><br>
            </div>
    </div>

    <div id="trailer" style="visibility: hidden">
        <button id="closeButton" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored closeButton" onclick="displayTrailer(false)">
            <i class="material-icons">close</i>
        </button>
        <iframe id="trailerFrame" width="640" height="360" src="" frameborder="0" allowfullscreen style="visibility: hidden">
        </iframe>
    </div>
    <?php endif; ?>
<?php  include "footer.php"; ?>

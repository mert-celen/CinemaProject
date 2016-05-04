<?php include "header.php";
if(!isUserAdmin($_COOKIE["username"])){
    echo "<meta http-equiv='refresh' content='0;url=index.php'>";
    die();
}
?>
<script>
    function updateMovie(){
//       todo
    }
</script>
<div class="wrapper" style="margin: 30px;">
    <?php
    if(isset($_POST["action"]) && strcmp($_POST["action"],"Delete")==0){
        deleteMovie($_POST["title"]);
        echo "<h2>" . $_POST["title"] . " deleted!</h2>";
        connect_db();
    }
    ?>

    <?php if(isset($_POST["action"]) && strcmp($_POST["action"],"Edit")==0){ ?>
        <?php echo "<h3>". $_POST["title"] . "</h3><br>";?>
        <form action="edit.php" method="get">
        <table>
            <tr>
                <td>
                    <img src="resources/img/<?php $title = $_POST["title"]; echo $title;?>/poster.jpg" onclick="previewFile()"/>
                </td>
                <td style="vertical-align: top;padding-left: 20px">
                    <table>
                        <tr><td>
                                <?php
                                selectMovie($_POST["title"]);
                                getInputStr("text","Title",$_POST["title"]);
                                ?>
                            </td></tr>
                        <tr><td>
                            <?php getInputStr("text","IMDB Score",getImdbRatingStr()); ?>
                            </td></tr>
                        <tr><td>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <textarea class="mdl-textfield__input" type="text" rows= "10" id="sample5" ><?php getPlot()?></textarea>
                                    <label class="mdl-textfield__label" for="sample5">Plot</label>
                                </div>
                            </td></tr>
                        <tr><td>
                                <?php getInputStr("text","Genre",getGenre()) ?>
                            </td></tr>
                    </table>
                </td>
            </tr>
        </table><br>
        <table>
            <td style="padding-right: 10px"><a href="edit.php" <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" style="background: #4CAF50;">
                    Go Back
                </button></a></td>
            <td>
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit" style="background: #4CAF50;" name="action" value="Save" onclick="updateMovie()">
                    Save Changes
                </button>
            </td>
        </table>
        </form>

    <?php }else{ ?>
        <h3>List of movies</h3>
        <?php if(getMovie()) : ?>
            <table>
            <?php do {?>
                <form action="edit.php" method="post">
                    <tr><td><?php getTitle()?></td><td style="padding: 20px;padding-top: 0px">
                    <input type="hidden" name="title" value="<?php getTitle()?>">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                                    type="submit" style="background: #4CAF50;" name="action" value="Edit">
                                Edit
                            </button>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                                    type="submit" style="background: #4CAF50;" name="action" value="Delete">
                                Delete
                            </button>
                    </td></tr>
                </form>
            <?php } while (getMovie()); ?>

            </table>
        <?php else : ?>
            Not a single movie found!
        <?php endif;?>
    <?php }?>
</div>
<?php include "footer.php";?>

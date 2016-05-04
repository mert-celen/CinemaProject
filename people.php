<?php include "header.php"; ?>
<div id="peopleDetails">
<h2>
<?php echo $_GET["name"] . " movies" . "<br><br>"; ?></h2>
    <table>
        <tr>
            <td width="278" height="185"><img src="<?php echo getProfilePic($_GET["name"] )?>"/> </td>
            <td width="400" height="185" style="vertical-align: top"><?php echo getActorDetails($_GET["name"]) . "<br>";?></td>
        </tr>

        <tr><td colspan="2">
                
            <?php echo moviesOf($_GET["name"]); ?>
            </td></tr>
    </table>

</div>
<?php include "footer.php"; ?>

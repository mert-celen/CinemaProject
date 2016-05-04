<?php include "header.php"; ?>
<?php
if(isset($_POST["addComment"])){
    addComment($_POST["movie"],$_POST["title"],$_POST["comment"]);
    echo "<meta http-equiv='refresh' content='0;url=details.php?movie={$_POST["movie"]}'>";
    die();
}
if(isset($_POST["publishComment"])){
    publishComment($_POST["publishComment"],$_POST["commentID"]);
    echo "Done!";
    die();
}
?>
<?php
    if(!isUserAdmin($_COOKIE["username"])){
        echo "<meta http-equiv='refresh' content='0;url=index.php'>";
        die();
    }
    if(isset($_POST["deleteComment"])){
        deleteComment($_POST["deleteComment"]);
        die();
    }
?>

<script>
    function publishComment(commentId){
        console.log(commentId);
        $.ajax({
                type: "POST",
                url: "comments.php",
                data: { publishComment:"yes", commentID:commentId }
            })
            .done(function( msg ) {
//                alert("Action done!");
                if($("#button" + commentId).attr('value') == "yes"){
                    $("#button" + commentId).attr('value','no');
                }else{
                    $("#button" + commentId).attr('value','yes');
                }
            });
    };

    function deleteComment(commentId){
        $.ajax({
                type: "POST",
                url: "comments.php",
                data: { deleteComment:commentId }
            })
            .done(function( msg ) {
                alert("Comment deleted!");
                $(".movie" + commentId).fadeOut();
            });
    };
</script>

<div style="margin: 30px;">
    <table id="comments" style="padding: 10px">
        <tr class="first"><td>Movie Name</td><td>Comment Title</td><td>Comment Text</td><td>Comment Time</td><td>Comment ID</td><td>Publish</td><td>Delete</td><td>Ip Adress</td></tr>
        <?php
            getApprovalList();
        ?>
    </table>

</div>

<?php include "footer.php" ?>

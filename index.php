<?php

    include "header.php";
    $i = 0;
?>
<div id="mainFrame">
<!--    <h2>On Theaters Now</h2>-->
    <?php if(getMovie()) : ?>
    <?php do { global $i; $i++;?>
        <div id="movieInformation">
            <div id="imdbRating" style="position: relative ; left: -15px;top: 30px">
                <?php getImdbRating()?>
            </div>
            <a href="details.php?movie=<?php getTitle()?>">
            <img src="resources/img/<?php getTitle()?>/poster.jpg" width="250" height="370"></a>
        </div>
    <?php } while (getMovie()); ?>
    <?php else : ?>
        Not a single movie found!
    <?php endif;?>

</div>

<?php  include "footer.php"; ?>

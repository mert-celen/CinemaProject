<?php
include "header.php";
?>
<div id="mainFrame">
    <h2>All Movies</h2>
    <?php if(getMovie()) : ?>
        <?php do {?>
            <div id="movieInformation">
                <a href="details.php?movie=<?php getTitle()?>">
                    <img src="<?php getImage()?>" width="250" height="370"></a>
            </div>
        <?php } while (getMovie()); ?>
    <?php else : ?>
        Not a single movie found!
    <?php endif;?>
</div>
<?php  include "footer.php"; ?>

<?php
setcookie("username","",time()-300);
setcookie("password","",time()-300);
echo "<meta http-equiv='refresh' content='0;url=index.php'>";
?>
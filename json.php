<?php
extract($_GET);
include "resources/php/functions.php";
connect_db();
$result = $connection->query("SELECT * from movies where Title='$title'");
$row = $result->fetch_row();
echo json_encode($row);
?>
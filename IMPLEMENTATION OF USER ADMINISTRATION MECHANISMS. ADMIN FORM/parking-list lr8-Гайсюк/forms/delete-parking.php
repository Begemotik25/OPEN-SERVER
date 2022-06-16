<?php
include(__DIR__ . "/../auth/check-auth.php");
if(!CheckRight('parking', 'delete')) {
    die('Ви не маєте прав на виконання даної операції !');
}
$dirName = "../data/". $_GET['parking'];
$conts = scandir($dirName);
$i = 0;
foreach ($conts as $node) {
    @unlink($dirName . "/" . $node);
}
@rmdir($dirName);
header('Location: ../index.php');
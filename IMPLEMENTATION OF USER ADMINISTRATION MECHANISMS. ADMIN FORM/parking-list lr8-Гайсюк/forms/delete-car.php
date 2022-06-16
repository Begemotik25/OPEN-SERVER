<?php
include(__DIR__ . "/../auth/check-auth.php");
if(!CheckRight('car', 'delete')) {
    die('Ви не маєте прав на виконання даної операції !');
}
unlink(__DIR__ . "/../data/" . $_GET['parking'] . "/" . $_GET['file']);
header('Location: ../index.php?parking=' . $_GET['parking']);
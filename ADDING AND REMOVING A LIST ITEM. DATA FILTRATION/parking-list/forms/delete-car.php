<?php
unlink(__DIR__."/../data/cars/". $_GET['file']);
header('Location: ../index.php');
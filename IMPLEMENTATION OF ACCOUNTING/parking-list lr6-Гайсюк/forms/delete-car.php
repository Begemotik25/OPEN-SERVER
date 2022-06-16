<?php
unlink(__DIR__ . "/../data/" . $_GET['parking'] . "/" . $_GET['file']);
header('Location: ../index.php?parking=' . $_GET['parking']);
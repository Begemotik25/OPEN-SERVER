<?php
session_start();
if (!$_SESSION['user']) {
    header('Location: /auth/login.php');
}

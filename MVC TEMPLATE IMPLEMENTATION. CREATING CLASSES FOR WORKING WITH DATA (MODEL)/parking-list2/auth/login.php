<?php
if ($_POST) {
    require_once '../model/autorun.php';
    $myModel = Model\Data::makeModel(Model\Data::FILE);
    if($user = $myModel->readUser($_POST['username'])) {
        if ($user -> checkPassword($_POST['password'])) {
            session_start();
            $_SESSION['user'] = $user->getUserName();
            header('Location: ../index.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login-style.css">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <p>
    <input type="text" name="username" placeholder="username">
    </p>
    <p>
    <input type="password" name="password" placeholder="password">
    </p>
    <p>
    <input type="submit" value="login">
    </p>
    </form>
</body>
</html>
<?php
if($_POST){
    $f = fopen("../data/" . $_GET['parking'] . "/parking.txt", "w");
    $grArr = array($_POST['adress'], $_POST['director'],);
    $grStr = implode(";", $grArr);
    fwrite($f,$grStr);
    fclose($f);
    header('Location: ../index.php?parking=' . $_GET['parking']);
}
$parkingFolder = $_GET['parking'];
require('../data/declare-parking.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування автостоянки</title>
    <link rel="stylesheet" href="../css/edit-parking-form-style.css">
</head>
<body>
    <a href="../index.php">На головну</a>
    <form name="edit-parking" method="post">
        <div>
            <label for="adress">Адреса: </label>
            <input type="text" name="adress" value="<?php echo $data['parking']['adress']; ?>">
        </div>
        <div>
            <label for="director">Директор: </label>
            <input type="text" name="director" value="<?php echo $data['parking']['director']; ?>">
        </div>
        <div>
            <input type="submit" name="ok" value="Змінити">
        </div>
    </form>
</body>
</html>
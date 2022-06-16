<?php
if($_POST){
    $f = fopen("../data/parking.txt",'w');
    $grArr = array($_POST ['adress' ],$_POST['director'], );
    $grStr =  implode(";",$grArr);
    fwrite($f,$grStr);
    fclose($f);
    header('Location: ../index.php');
}
require('../data/declar-info.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редагування стоянки</title>
    <link rel="stylesheet" type="text/css" href="../css/edit-car-form-style.css">
</head>
<body>
    <a href ="../index.php">На головну</a>
    <form name="edit_cars" method="post">
    <div>
    <label for = "adress">Адреса :</label>
    <input type="text" name="adress" value="<?php echo $data['info']['adress']; ?>">
    </div>
    <div>
    <label for = "director">Директор :</label>
    <input type="text" name="director" value="<?php echo $data['info']['director']; ?>">
    </div>
    <div>
    <input type="submit" name="ok" value="Змінити">
    </div>
    </form>
</body>
</html>

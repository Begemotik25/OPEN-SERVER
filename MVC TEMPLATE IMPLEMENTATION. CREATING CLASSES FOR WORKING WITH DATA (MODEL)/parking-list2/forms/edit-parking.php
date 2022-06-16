<?php
include(__DIR__ . "/../auth/check-auth.php");

require_once '../model/autorun.php';
$myModel = Model\Data::makeModel(Model\Data::FILE);
$myModel->setCurrentUser($_SESSION['user']);

if($_POST){
    if (!$myModel->writeParking((new \Model\Parking())
    ->setId($_GET['parking'])
    ->setAdress($_POST['adress'])
    ->setDirector($_POST['director'])
    )) {
        die($myModel->getError());
    } else {
        header('Location: ../index.php?parking=' . $_GET['parking']);
    } 
}
if (!$data['parking'] = $myModel->readParking($_GET['parking'])) {
    die($myModel->getError());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Редагування автостоянки</title>
    <link rel="stylesheet" href="../css/edit-parking-form-style.css">
</head>
<body>
    <a href="../index.php?parking=<?php echo $_GET['parking'];?>">На головну</a>
    <form name="edit-parking" method="post">
        <div>
            <label for="adress">Адреса: </label>
            <input type="text" name="adress" value="<?php echo $data['parking']->getAdress(); ?>">
        </div>
        <div>
            <label for="director">Директор: </label>
            <input type="text" name="director" value="<?php echo $data['parking']->getDirector(); ?>">
        </div>
        <div>
            <input type="submit" name="ok" value="Змінити">
        </div>
    </form>
</body>
</html>
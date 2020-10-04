<?php
    require_once('db.php');
    require_once('controller.php');
    $controller = new Controller($db);
    $airtemp = $_POST['airtemp'];
    $ppm = $_POST['ppm'];
    $waterph = $_POST['waterph'];
    $watertemp = $_POST['watertemp'];
    $uno = $controller->process($airtemp,$ppm,$waterph,$watertemp);
    $controller->postData($airtemp,$ppm,$waterph,$watertemp);
    $date = new DateTime();
    echo json_encode(array('success' => true, 'uno' => $uno, 'min' => $date->format('i')));
?>
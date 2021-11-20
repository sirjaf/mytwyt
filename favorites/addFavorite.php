<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
$twytConnection = new  Connection; 
$twytController = new TwytController($twytConnection->getConnection());
$twytController->addFavorite($_POST['twytId'],$_POST['twytText'],$_POST['twytUserScreenName'], $_POST['twytUrl'],$_POST['twytCreatedAt'],$_POST['twytProfileImage']);
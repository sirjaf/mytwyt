<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// $twytConnection = new  Connection; 
$twytController = new TwytController(new DbService(), new TwytService(new DbService()),new Connection());
$twytController->addFavorite($_POST['twytId'],$_POST['twytText'],$_POST['twytUserScreenName'], $_POST['twytUrl'],$_POST['twytCreatedAt'],$_POST['twytProfileImage']);

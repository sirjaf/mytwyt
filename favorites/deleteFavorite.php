<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// $twytConnection = new  Connection;
$twytController = new TwytController(new DbService(), new TwytService(new DbService()),new Connection());
$twytController->deleteFavorite($_POST['twytId']);

<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// $twytConnection = new  Connection; 
$twytService = new TwytService(new DbService());
$twytController = new TwytController(new DbService(), new TwytService(new DbService()),new Connection());
// var_dump($_POST);
// return;
$favoritesArray=file_get_contents('php://input');
//var_dump($favoritesArray);
$favoritesObjects = json_decode($favoritesArray,true);
$twytController->addFavoritesSelected($favoritesObjects);
$twytService->createFavoritesJson();
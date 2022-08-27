<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// $twytConnection = new  Connection;
$twytService = new TwytService(new DbService());
$twytController = new TwytController(new DbService(), new TwytService(new DbService()),new Connection());
$favoritesArray=file_get_contents('php://input');
$favoritesObjects = json_decode($favoritesArray,true);
$twytController->deleteFavoritesSelected($favoritesObjects);
$twytService->createFavoritesJson();
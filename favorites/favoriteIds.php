<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// $twytConnection = new  Connection;
$dbService = new DbService();
echo $dbService->getFavoritesTwytIdsJson();

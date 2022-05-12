<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/views/twytViews.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
try {
    $twytController = new TwytController(new DbService(), new TwytService(new DbService()), new Connection());
    echo $twytController->getUserTimelineTwytsJson($_POST['screenName']);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
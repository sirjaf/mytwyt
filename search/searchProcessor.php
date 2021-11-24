<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/views/twytViews.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
$twytConnection = new  Connection; 
$twytView = new TwytView($twytConnection);
echo $twytView->viewSearch($_POST['screenName']);
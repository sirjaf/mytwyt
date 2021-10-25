<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/header.inc.php';?>
<?php 
date_default_timezone_set("Africa/Lagos");
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/views/twytViews.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/services/twytService.php';
try {
    $connection = new Connection;
    $twytService = new TwytService();
    $twytView = new TwytView($connection);
    $twytService->fetchListStatusJson(203356824,'technology');
    echo $twytView->view($twytService->getTechnologyJsonPath());
} catch (\Throwable $e) {
    echo "Sorry";
}

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
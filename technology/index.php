<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"",
    "web-dev"=>"",
    "flutter"=>"",
    "technology"=>"class='active'",
    "android-news"=>"",
    "football"=>"",
    "favorites"=>"",
    "search" => ""
);?>
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
    if ($twytService->createListStatusJson(203356824,'technology')!=null)$twytService->createListStatusJson(203356824,'technology');
    echo $twytView->view($twytService->getTechnologyJsonPath(),false);
} catch (\Throwable $e) {
    echo "Sorry";
}

?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
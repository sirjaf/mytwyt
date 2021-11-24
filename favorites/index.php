<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"",
    "web-dev"=>"",
    "flutter"=>"",
    "technology"=>"",
    "android-news"=>"",
    "football"=>"",
    "favorites"=>"class='active'",
    "search" => ""
);?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/header.inc.php';?>
<?php 
date_default_timezone_set("Africa/Lagos");
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/views/twytViews.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/services/twytService.php';
//require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/controllers/twytControllers.php';

$connection = new Connection;
$twytService = new TwytService();
$twytView = new TwytView($connection);
//if ($twytService->createFavoritesJson()!==null)$twytService->createFavoritesJson();
$twytService->createFavoritesJson();
echo $twytView->view($twytService->getFavoritesJsonPath(),true);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
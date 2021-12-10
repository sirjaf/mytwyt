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
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/controllers/twytController.php';

$twytService = new TwytService(new DbService());
$twytController = new TwytController(new DbService(), new TwytService(new DbService()),new Connection());
$twytView = new TwytView($twytController);
if ($twytService->createFavoritesJson()!==null)$twytService->createFavoritesJson();
//$twytService->createFavoritesJson();
echo $twytView->view($twytController->getFavoritesJson(),true);
//echo $twytView->view($twytController->getFavoritesJsonPath(),true);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
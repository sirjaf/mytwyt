<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"",
    "web-dev"=>"",
    "flutter"=>"",
    "technology"=>"",
    "android-news"=>"class='active'",
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

$connection = new Connection;
$twytService = new TwytService();
$twytView = new TwytView($connection);
if ($twytService->createListStatusJson(203355522,'my-android-list')!==null)$twytService->createListStatusJson(203355522,'my-android-list');
echo $twytView->view($twytService->getMyAndroidListJsonPath(),false);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
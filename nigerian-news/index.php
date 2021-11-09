<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"class='active'",
    "web-dev"=>"",
    "flutter"=>"",
    "technology"=>"",
    "android-news"=>"",
    "football"=>"",
    "favorites"=>""
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
if($twytService->createListStatusJson(203356054,'nigerian-news')!=null)$twytService->createListStatusJson(203356054,'nigerian-news');
echo $twytView->view($twytService->getNigerianNewsJsonPath(),false);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
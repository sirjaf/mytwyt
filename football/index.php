<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"",
    "web-dev"=>"",
    "flutter"=>"",
    "technology"=>"",
    "android-news"=>"",
    "football"=>"class='active'",
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
if ($twytService->createListStatusJson(203356338,'football')!=null)$twytService->createListStatusJson(203356338,'football');
echo $twytView->view($twytService->getFootballJsonPath(),false);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
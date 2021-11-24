<?php $activeArray = array(
    "home"=>"",
    "nigerian-news"=>"",
    "web-dev"=>"class='active'",
    "flutter"=>"",
    "technology"=>"",
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

$connection = new Connection;
$twytService = new TwytService();
$twytView = new TwytView($connection);
if ($twytService->createListStatusJson(12751959157756846084,'web-dev')!=null)$twytService->createListStatusJson(12751959157756846084,'web-dev');
echo $twytView->view($twytService->getWebDevJsonPath(),false);
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/includes/footer.inc.php';?>
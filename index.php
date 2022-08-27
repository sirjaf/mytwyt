<?php 
 
$activeArray = array(
    "home" => "class='active'",
    "nigerian-news" => "",
    "web-dev" => "",
    "flutter" => "",
    "technology" => "",
    "android-news" => "",
    "football" => "",
    "favorites" => "",
    "search" => ""
);
$page = "home";
include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/header.inc.php'; 

try {
    date_default_timezone_set("Africa/Lagos");
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/views/twytViews.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
    $twytService = new TwytService(new DbService());
    $twytController = new TwytController(new DbService(), new TwytService(new DbService()), new Connection());
    $twytView = new TwytView($twytController);
   // if ($twytService->createHomeTimelineJson() !== null) $twytService->createHomeTimelineJson();
    //echo $twytView->homeTimelimeView();
    echo $twytView->view($twytController->getHomeTimelineJson(), false);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/footer.inc.php'; ?>
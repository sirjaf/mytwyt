<?php $activeArray = array(
    "home" => "",
    "nigerian-news" => "class='active'",
    "web-dev" => "",
    "flutter" => "",
    "technology" => "",
    "android-news" => "",
    "football" => "",
    "favorites" => "",
    "search" => ""
); 
$page = "nigerian-news";
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/header.inc.php'; ?>
<?php
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
    //if ($twytService->createListStatusJson(203356054, 'nigerian-news') != null) $twytService->createListStatusJson(203356054, 'nigerian-news');
    echo $twytView->view($twytController->getNigerianNewsJson(), false);
} catch (\Throwable $e) {
    echo $e->getMessage();
}
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/footer.inc.php'; ?>
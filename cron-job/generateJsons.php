<?php
try {
    date_default_timezone_set("Africa/Lagos");
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
  
    $twytService = new TwytService(new DbService());
    $twytService->createHomeTimelineJson();
    $twytService->createListStatusJson(203356054, 'nigerian-news');
    $twytService->createListStatusJson(12751959157756846084, 'web-dev');
    $twytService->createListStatusJson(1275198258265174018, 'flutter');
    $twytService->createListStatusJson(203356824, 'technology');
    $twytService->createListStatusJson(203356338, 'football');
   
} catch (\Throwable $e) {
    echo $e->getMessage();
}
?>
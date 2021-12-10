<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/models/twytModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';


class TwytController
{

    private $dbService;
    private $twytService;
    private $connection;

    public function __construct($dbService, $twytService, $connection)
    {
        $this->dbService =  $dbService;
        $this->twytService = $twytService;
        $this->connection = $connection;
    }

    public function getFavorites()
    {
        return $this->dbService->getFavoritesFromDB();
    }

    public function getUserTimelineTwyts($screenName)
    {
        $userTimelineTwyts = $this->twytService->fetUserTimelineTwyts($screenName);
        return $this->createTwytObjects($userTimelineTwyts);
    }

    public function isTwytInDb($twytId)
    {
        $favoriteTwytList = $this->dbService->getFavoritesTwytIds();
        $twytStatus = false;
        foreach ($favoriteTwytList as $twytIdItem) {

            if ($twytIdItem['twytId'] == $twytId) {
                $twytStatus = true;
            }
        }
        return $twytStatus;
    }

    public function addFavorite(string $twytId, string $twytText, string $twytUserScreenName, string $twytUserUrl, string $twytCreatedAt, string $twytProfileImage)
    {
        $this->dbService->addFavoriteToDb($twytId, $twytText, $twytUserScreenName, $twytUserUrl, $twytCreatedAt, $twytProfileImage);
    }

    public function deleteFavorite(string $favoriteId)
    {
        $this->dbService->deleteFavoriteFromDb($favoriteId);
    }

    public static function getValidUrl($testItem)
    {

        $testUrl = $testItem['entities']['urls'][0] ?? null;
        if (is_null($testUrl)) {
            return  array("href" => null, "value" => "No Link");
        } else {
            return array("href" => $testItem['entities']['urls'][0]['expanded_url'], "value" => $testItem['entities']['urls'][0]['expanded_url']);
        }
    }

    public function fetchTwytObjects($jsonFile)
    {

        $response = file_get_contents($jsonFile);
        return $this->createTwytObjects($response);
    }

    public function fetchFavoriteTwytObjects($jsonFile)
    {

        $response = file_get_contents($jsonFile);
        $jsonToAssocArray = json_decode($response, true);
        $listOfTwytObjs = array();
        foreach ($jsonToAssocArray as $item) {

            $twytObj = new TwytModel(
                $item['twytId'],
                $item['twytText'],
                $item['twytUserScreenName'],
                $item['twytUserUrl'] ?? '',
                $item['twytCreatedAt'],
                $item['twytProfileImage']

            );
            array_push($listOfTwytObjs, $twytObj);
        }
        return $listOfTwytObjs;
    }

    private function createTwytObjects($json)
    {

        $jsonToAssocArray = json_decode($json, true);
        $listOfTwytObjs = array();
        foreach ($jsonToAssocArray as $item) {
            $myDate = strtotime("{$item['created_at']}");
            $twytDate = date("g:i a, F j, Y ", $myDate);
            $twytObj = new TwytModel(
                $item['id'],
                $item['full_text'],
                $item['user']['screen_name'],
                $item['entities']['urls'][0]['expanded_url'] ?? '',
                $twytDate,
                $item['user']['profile_image_url_https']
            );
            array_push($listOfTwytObjs, $twytObj);
        }
        return $listOfTwytObjs;
    }

    public function getFavoritesJson()
    {
        return $this->twytService->getFavoritesJsonPath();
    }

    public function getHomeTimelineJson()
    {
        return $this->twytService->getHomeTimelineJsonPath();
    }

    public function getNigerianNewsJson()
    {
        return $this->twytService->getNigerianNewsJsonPath();
    }

    public function getWebDevJson()
    {
        return $this->twytService->getWebDevJsonPath();
    }

    public function getFlutterJson()
    {

        return $this->twytService->getFlutterJsonPath();
    }

    public function getFootballJson()
    {
        return $this->twytService->getFootballJsonPath();
    }

    public function getTechnologyJson()
    {
        return $this->twytService->getTechnologyJsonPath();
    }

    public function getMyAndroidListJson()
    {
        return $this->twytService->getMyAndroidListJsonPath();
    }

    public function getPDOConnection()
    {
        $this->connection->getConnection();
    }

    public function getMsqliConnection()
    {
        return $this->connection->getMsqliConnection();
    }

    public function getDBService()
    {
        return $this->dbService;
    }

    public function getTwytService()
    {
        return $this->twytService;
    }
}

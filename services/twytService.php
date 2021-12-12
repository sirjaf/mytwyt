<?php
require $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/dbService.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class TwytService
{
    //private $myURL ='https://api.twitter.com/1.1/statuses/home_timeline.json';

    const USER_TIMELINE = "statuses/user_timeline";
    const HOME_TIMELINE = "statuses/home_timeline";
    const LIST_STATUSES = "lists/statuses";

    private $connection;
    private $dbService;
    private $homeTimelineJsonFile = "/mytwyt/jsons/homeTimeline.json";
    private $flutterJsonFile = "/mytwyt/jsons/flutterTimeline.json";
    private $footballJsonFile = "/mytwyt/jsons/footballTimeline.json";
    private $myAndroidListJsonFile = "/mytwyt/jsons/my-android-listTimeline.json";
    private $nigerianNewsJsonFile = "/mytwyt/jsons/nigerian-newsTimeline.json";
    private $webDevJsonFile = "/mytwyt/jsons/web-devTimeline.json";
    private $technologyJsonFile = "/mytwyt/jsons/technologyTimeline.json";
    private $favoritesJsonFile = "/mytwyt/jsons/favorites.json";


    public function __construct($dbService)
    {
        \Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']."/mytwyt")->load();
        
        $this->connection = new TwitterOAuth(
            $_ENV['TWITTER_API_KEY'],
            $_ENV['TWITTER_API_SECRET_KEY'],
            $_ENV['TWITTER_ACCESS_TOKEN'],
            $_ENV['TWITTER_ACCESS_TOKEN_SECRET']
        );
        $this->dbService = $dbService;
        // );
        //\Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']."/mytwyt")->load();
        //var_dump($_ENV);
    }

    public function createHomeTimelineJson()
    {
        try {
            $result = $this->connection->get(self::HOME_TIMELINE, ["count" => 100, "exclude_replies" => false,"tweet_mode"=>"extended"]);
            //echo $result;
            $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
            $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/homeTimeline.json";
            $fp = fopen($myFile, 'w');
            fwrite($fp, $myResult);
            return $myResult;
        } catch (\Throwable $e) {
            //$e->getMessage();
            return null;
        }
    }

    public function createListStatusJson($listId, $slug)
    {
        try {
            //$content = $connection->get("account/verify_credentials"); 
            $result = $this->connection->get(
                self::LIST_STATUSES,
                [
                    "count" => 50,
                    "exclude_replies" => false,
                    "list_id" => $listId,
                    "slug" => $slug,
                    "owner_screen_name" => "jaafarhabu",
                    "tweet_mode"=>"extended"
                ]
            );
            $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
            $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/" . $slug . "Timeline.json";
            $fp = fopen($myFile, 'w');
            fwrite($fp, $myResult);
            return $myResult;
        } catch (\Throwable $e) {
            $e->getMessage();
            return null;
        }
    }

    public function createFavoritesJson(){
        try {
            
            $favoriteList = $this->dbService->getFavoritesFromDB();
            $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/favorites.json";
            $fp = fopen($myFile, 'w');
            fwrite($fp, $favoriteList);
        } catch (\Throwable $e) {
            echo "error thrown by  CREATEfAVORITESJSON";
        }
        
    }

    public function createUserTimelineJson($screenName)
    {
        //$content = $connection->get("account/verify_credentials"); 
        $result = $this->connection->get(self::USER_TIMELINE, ["count" => 50, "exclude_replies" => false, "screen_name" => "{$screenName}","tweet_mode"=>"extended"]);
        $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/" . $screenName . "Timeline.json";
        $fp = fopen($myFile, 'w');
        fwrite($fp, $myResult);
        return $myResult;
    }



    public function fetUserTimelineTwyts($screenName){
        $result = $this->connection->get(self::USER_TIMELINE, ["count" => 50, "exclude_replies" => false, "screen_name" => "{$screenName}","tweet_mode"=>"extended"]);
        $userTimelineTwyts = json_encode($result, JSON_UNESCAPED_SLASHES);
        return $userTimelineTwyts;
    }

    public function fetchTwyt($url, $file)
    {
        $reqPrefs['http']['method'] = 'GET';
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/{$file}";
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($url, false, $stream_context);
        $fp = fopen($myFile, 'w');
        fwrite($fp, $response);
    }

    public function fetchFavarites(){
       $this->createFavoritesJson();
       
    }

    public function getFavoritesJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->favoritesJsonFile;
    }

    public function getHomeTimelineJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->homeTimelineJsonFile;
    }

    public function getFlutterJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->flutterJsonFile;
    }

    public function getFootballJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->footballJsonFile;
    }

    public function getMyAndroidListJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->myAndroidListJsonFile;
    }

    public function getNigerianNewsJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->nigerianNewsJsonFile;
    }

    public function getWebDevJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->webDevJsonFile;
    }

    public function getTechnologyJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->technologyJsonFile;
    }

    public function fetchTwytImages($jsonFile){
        $response = file_get_contents($jsonFile);
        $jsonToAssocArray = json_decode($response,true);
        foreach ($jsonToAssocArray as $item) {
           $this->fetchImage($item['user']['id'],$item['user']['profile_image_url_https']);
        }

    }

    private function fetchImage($twyUsertId,$userProfileImageUrl){
        
        $uri = $userProfileImageUrl;
        $reqPrefs['http']['method'] = 'GET';
        $myImageFile = $_SERVER['DOCUMENT_ROOT']."/mytwyt/images/".$twyUsertId.".jpeg";
        $stream_context = stream_context_create($reqPrefs);
        $response = file_get_contents($uri, false, $stream_context);
        $fp = fopen($myImageFile, 'w');
        fwrite($fp, $response);

    }
}

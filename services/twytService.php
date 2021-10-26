<?php
//require $_SERVER['DOCUMENT_ROOT'].'/mytwyt/vendor/src/TwitterOAuth.php';
require $_SERVER['DOCUMENT_ROOT']."/mytwyt/vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class TwytService
{
    //private $myURL ='https://api.twitter.com/1.1/statuses/home_timeline.json';
    const NOCODEAPIHOMETIMELINE = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI?type=home_timeline&api_key=tPITQSNuQxywUlCNY&count=100";
    const NIGERIANNEWS = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI/listStatuses?slug=nigerian-news&owner_screen_name=jaafarhabu&api_key=tPITQSNuQxywUlCNY&count=100";
    const WEBDEV = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI/listStatuses?slug=web-dev&owner_screen_name=jaafarhabu&api_key=tPITQSNuQxywUlCNY&count=100";
    const FLUTTER = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI/listStatuses?slug=flutter&owner_screen_name=jaafarhabu&api_key=tPITQSNuQxywUlCNY&count=100";
    const TECHNOLOGY  = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI/listStatuses?slug=technology&owner_screen_name=jaafarhabu&api_key=tPITQSNuQxywUlCNY&count=100";

    const USER_TIMELINE = "statuses/user_timeline";
    const HOME_TIMELINE = "statuses/home_timeline";
    const LIST_STATUSES = "lists/statuses";

    private $connection;
    private $homeTimelineJsonFile = "/mytwyt/jsons/homeTimeline.json";
    private $dailyTrustJsonFile = "/mytwyt/jsons/daily_trustTimeline.json";
    private $leadershipJsonFile = "/mytwyt/jsons/LeadershipNGATimeline.json";
    private $premiumTimesJsonFile = "/mytwyt/jsons/PremiumTimesngTimeline.json";
    private $flutterJsonFile = "/mytwyt/jsons/flutterTimeline.json";
    private $footballJsonFile = "/mytwyt/jsons/footballTimeline.json";
    private $myAndroidListJsonFile = "/mytwyt/jsons/my-android-listTimeline.json";
    private $nigerianNewsJsonFile = "/mytwyt/jsons/nigerian-newsTimeline.json";
    private $webDevJsonFile = "/mytwyt/jsons/web-devTimeline.json";
    private $technologyJsonFile = "/mytwyt/jsons/technologyTimeline.json";


    public function __construct()
    {
        $this->connection = new TwitterOAuth(
            'Dsmr86yGxNH3ujPIkQl4cpcKx',
            'Y0D3gmsytruhyvbJUk5MxOQeH6V6TyEhZ8WICaSTEM4m39HXgn',
            '391616463-rCR7R6tj9EQ9VJtqdbCYqPizFZpjN4d1YY8pdUGn',
            'rd95Vfu0x2RQvamQPbHBCU530Rc5PsshS26JMffco1lC0'
        );
    }

    public function fetchHomeTimelineJson()
    {
        $result = $this->connection->get(self::HOME_TIMELINE, ["count" => 100, "exclude_replies" => false]);
        echo $result;
        $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/homeTimeline.json";
        $fp = fopen($myFile, 'w');
        fwrite($fp, $myResult);
        return $myResult;
    }

    public function fetchUserTimelineJson($screenName)
    {
        //$content = $connection->get("account/verify_credentials"); 
        $result = $this->connection->get(self::USER_TIMELINE, ["count" => 100, "exclude_replies" => false, "screen_name" => "{$screenName}"]);
        $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/" . $screenName . "Timeline.json";
        $fp = fopen($myFile, 'w');
        fwrite($fp, $myResult);
        return $myResult;
    }

    public function fetchListStatusJson($listId,$slug)
    {
        //$content = $connection->get("account/verify_credentials"); 
        $result = $this->connection->get(
                    self::LIST_STATUSES, 
                    [
                        "count" => 100, 
                        "exclude_replies" => false, 
                        "list_id" => $listId,
                        "slug" => $slug,
                        "owner_screen_name" => "jaafarhabu"
                    ]
                );
        $myResult = json_encode($result, JSON_UNESCAPED_SLASHES);
        $myFile = $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/jsons/" . $slug . "Timeline.json";
        $fp = fopen($myFile, 'w');
        fwrite($fp, $myResult);
        return $myResult;
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

    public function getHomeTimelineJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->homeTimelineJsonFile;
    }

    public function getDailyTrustTimelineJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->dailyTrustJsonFile;
    }

    public function getLeadershipTimelineJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->leadershipJsonFile;
    }

    public function getPremiumTimesTimelineJsonPath(): string
    {
        return $_SERVER['DOCUMENT_ROOT'] . $this->premiumTimesJsonFile;

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

    // public function getMyAndroidJsonPath(): string
    // {
    //     return $_SERVER['DOCUMENT_ROOT'] . $this->myAndroidJsonFile;
    // }

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
    
}

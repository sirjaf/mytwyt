<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/models/twytModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';
class TwytController{
    private $pdo;
    private $service=null;

    public function __construct($pdo,$service){
        $this->pdo = $pdo;
        $this->service = ($service==null)?null:$service;      
    }
    public function getFavoritesFromDB()
    {
        try {
            $sql = "SELECT * FROM tblfavorites";
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $stmt =$this->pdo->prepare($sql);
            $stmt->execute();
            $favoritesList = $stmt->fetchAll();
            return json_encode($favoritesList);
        } catch (\Throwable $e) {
            echo $e->getMessage();
            return null;
        }
       
    }

    private function getFavoritesTwytIds()
    {
        try {
            $sql = "SELECT twytId FROM tblfavorites";
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $stmt =$this->pdo->prepare($sql);
            $stmt->execute();
            $favoritesList = $stmt->fetchAll();
            return $favoritesList;
            
        } catch (\Throwable $e) {
            echo $e->getMessage();
            return null;
        }
       
    }

    public function getUserTimelineTwyts($screenName){
        $userTimelineTwyts = $this->service->fetUserTimelineTwyts($screenName);
        return $this->createTwytObjects($userTimelineTwyts);
    }

    public function isTwytInDb($twytId) {
        $favoriteTwytList = $this->getFavoritesTwytIds();
        $twytStatus = false;
        foreach ($favoriteTwytList as $twytIdItem) {
            
           if ($twytIdItem['twytId']==$twytId) {
               $twytStatus=true;
              
           }
        }
        return $twytStatus;
    }

    public function addFavorite(string $twytId, string $twytText, string $twytUserScreenName,string $twytUserUrl,string $twytCreatedAt,string $twytProfileImage)
    {
        try {
            $sql = "INSERT INTO tblfavorites(twytId,twytText,twytUserScreenName,twytUserUrl,twytCreatedAt,twytProfileImage)VALUES(:twytId,:twytText,:twytUserScreenName,:twytUserUrl,:twytCreatedAt,:twytProfileImage)";
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                    'twytId'=>$twytId,
                    'twytText'=>$twytText,
                    'twytUserScreenName'=>$twytUserScreenName,
                    'twytUserUrl'=>$twytUserUrl,
                    'twytCreatedAt'=>$twytCreatedAt,
                    'twytProfileImage'=>$twytProfileImage]);
    
           $data = array("added"=>true);
           echo json_encode($data);
        } catch (\Throwable $e) {
            $e->getMessage();
            $data = array("added"=>false);
            echo json_encode($data);
        }
       
    }

    public function deleteFavorite(string $favoriteId)
    {
        try {
            $sql = "DELETE FROM tblfavorites WHERE twytId=:twytId";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['twytId'=>$favoriteId]);
            $data = array("removed"=>true);
            echo json_encode($data);
        } catch (\Throwable $e) {
            $e->getMessage();
            $data = array("removed"=>false);
            echo json_encode($data);
        }
       
        
    }
    
    public static function getValidUrl($testItem){

        $testUrl = $testItem['entities']['urls'][0]??null;
        if (is_null($testUrl)){ 
            return  array("href"=>null,"value"=>"No Link");
        }else {
            return array("href"=>$testItem['entities']['urls'][0]['expanded_url'],"value"=>$testItem['entities']['urls'][0]['expanded_url']);
        }
       
    }

    public function fetchTwytObjects($jsonFile){

        $response = file_get_contents($jsonFile);
        return $this->createTwytObjects($response);
       
    }

    public function fetchFavoriteTwytObjects($jsonFile){

        $response = file_get_contents($jsonFile);
        $jsonToAssocArray = json_decode($response,true);
        $listOfTwytObjs = array();
        foreach ($jsonToAssocArray as $item) {
           
            $twytObj = new TwytModel(
                $item['twytId'],
                $item['twytText'],
                $item['twytUserScreenName'],
                $item['twytUserUrl']??'',
                $item['twytCreatedAt'],
                $item['twytProfileImage']
                
            );
            array_push($listOfTwytObjs,$twytObj);
        }
        return $listOfTwytObjs;
    }

    private function createTwytObjects($json){

        $jsonToAssocArray = json_decode($json,true);
        $listOfTwytObjs = array();
        foreach ($jsonToAssocArray as $item) {
            $myDate = strtotime("{$item['created_at']}");
            $twytDate = date("g:i a, F j, Y ",$myDate);
            $twytObj = new TwytModel(
                $item['id'],
                $item['full_text'],
                $item['user']['screen_name'],
                $item['entities']['urls'][0]['expanded_url']??'',
                $twytDate,
                $item['user']['profile_image_url_https']
            );
            array_push($listOfTwytObjs,$twytObj);
        }
        return $listOfTwytObjs;
    }
}
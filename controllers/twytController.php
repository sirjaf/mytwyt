<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/models/twytModel.php';
class TwytController{
    private $conn;
    public function __construct($conn){
        $this->conn = $conn;      
    }
    public function getFavorites()
    {
        $sql = "SELECT * FROM tblFavorites";
        $stmt =$this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAddFavorite(string $twytId, string $twytText, string $twytUserScreenName,string $twytUserUrl,string $twytCreatedAt)
    {

        $sql = "INSERT INTO tblFavorite(twytId,twytText,twytUserScreenName,twytUserUrl,twytCreatedAt)VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$twytId,$twytText,$twytUserScreenName,$twytUserUrl,$twytCreatedAt]);

        return "Favarite Added";
    }

    public function deleteFavorite(int $favoriteId)
    {
        $sql = "DELETE FROM tblfavorites WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$favoriteId]);
        return "Favarite Removed";
    }
    
    public static function getValidUrl($testItem){

        $testUrl = $testItem['entities']['urls'][0]??null;
        if (is_null($testUrl)){ 
            return  array("href"=>null,"value"=>"No Link");
        }else {
            return array("href"=>$testItem['entities']['urls'][0]['expanded_url'],"value"=>$testItem['entities']['urls'][0]['expanded_url']);
        }
       
    }

    public function fetchTwytObject($jsonFile){

        $response = file_get_contents($jsonFile);
        $jsonToAssocArray = json_decode($response,true);
        $listOfTwytObjs = array();
        foreach ($jsonToAssocArray as $item) {
            $myDate = strtotime("{$item['created_at']}");
            $twytDate = date("g:i a, F j, Y ",$myDate);
            $twytObj = new TwytModel(
                $item['id'],
                $item['text'],
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
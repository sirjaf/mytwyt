<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
class DbService
{
    private $pdo;
    
    public function __construct(){
        $connection = new Connection();
        $this->pdo = $connection->getConnection();
    }

    public function getFavoritesFromDB()
    {
        try {
            $sql = "SELECT * FROM tblfavorites ORDER BY DESC";
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

    public function getFavoritesTwytIds()
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

    public function addFavoriteToDb(string $twytId, string $twytText, string $twytUserScreenName,string $twytUserUrl,string $twytCreatedAt,string $twytProfileImage)
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

    public function deleteFavoriteFromDb(string $favoriteId)
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

}
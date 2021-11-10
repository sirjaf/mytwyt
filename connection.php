<?php
//declare(strict_types=1);

class Connection{
    // const BASE_URL = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI";
    const HOST = "localhost";
    const USER = "jafsoftc_mytwytUser";
    const PASSWORD = "Sir982172Habu";
    const DB_NAME = "jafsoft_db";
    

    public static function getConnection(){
       try {
        $connectionString ="mysql:host=".self::HOST.";dbname=".self::DB_NAME;
        $pdo = new PDO($connectionString,self::USER,self::PASSWORD);
        // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;

       } catch (\Throwable $e) {
        //var_dump($pdo);
           echo $e->getMessage();
       }
        
    }
    

    public static function getMsqliConnection() {
        try {
            $conn = mysqli_connect(self::HOST, self::USER, self::PASSWORD, self::DB_NAME);
            return $conn;
        } catch (\Throwable $th) {
            $th->getMessage();
        }
        $conn = mysqli_connect(self::HOST, self::USER, self::PASSWORD, self::DB_NAME);
    }

    public static function closeConnection($pdo){
        $pdo = null;
    }
    
}
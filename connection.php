<?php
declare(strict_types=1);

class Connection{
    // const BASE_URL = "https://v1.nocodeapi.com/sirjaf1980/twitter/miAMXflKOGlNFBaI";
    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "sir982172";
    const DB_NAME = "jaftsoft_db";

    public static function getConnection(){
       try {
        $connectionString ="mysql:host='".self::HOST."';dbname='".self::DB_NAME."'";
        $pdo = new PDO($connectionString,self::USER,self::PASSWORD);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        return $pdo;

       } catch (\Throwable $e) {
           $e->getMessage();
       }
        
    }
    
}
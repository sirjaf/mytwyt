<?php
//declare(strict_types=1);
require $_SERVER['DOCUMENT_ROOT'] . "/mytwyt/vendor/autoload.php";
class Connection{
    
    private $host;
    private $user;
    private $password;
    private $dbName;
    

    public function __construct(){
        \Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']."/mytwyt")->load();
        $this->host = $_ENV['HOST'];
        $this->user = $_ENV['USER'];
        $this->password = $_ENV['PASSWORD'];
        $this->dbName = $_ENV['DB_NAME'];
    }

    public function getConnection(){
       try {
        $connectionString ="mysql:host=".$this->host.";dbname=".$this->dbName;
        $pdo = new PDO($connectionString,$this->user,$this->password);
        return $pdo;

       } catch (\Throwable $e) {
           echo $e->getMessage();
       }
        
    }
    
    public function getMsqliConnection() {
        try {
            $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbName);
            //var_dump($this->dbName);
            return $conn;
        } catch (\Throwable $th) {
            $th->getMessage();
        }
        // $conn = mysqli_connect($this->host, $this->user, $this->password, $this->dbName);
    }

    public static function closeConnection($pdo){
        $pdo = null;
    }
    
}
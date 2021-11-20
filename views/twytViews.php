<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/models/twytModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';

class TwytView
{
    private $twytConnection;
    private $twytController;
    private $disabled = "";
    private $btnText;

    public function __construct($twytConnection)
    {
        $this->twytConnection = $twytConnection;
        $this->twytController = new TwytController($this->twytConnection->getConnection());
        
    }

    private function getTwytList($jsonFile, $isFavarite)
    {
        if ($isFavarite == true){
            $twytList = $this->twytController->fetchFavoriteTwytObjects($jsonFile);
            return $twytList;
        }else{
            $twytList = $this->twytController->fetchTwytObjects($jsonFile);
            return $twytList;
        }   
    }

    public function homeTimelimeView()
    {
        try {

            $twytService = new TwytService();
            $homeTwytList = $this->getTwytList($twytService->getHomeTimelineJsonPath(),false);
            $this->btnText = "Add to Favorite";
            $viewString = "";
            foreach ($homeTwytList as $item) {
                $mySqliConnection = $this->twytConnection->getMsqliConnection();
                $link = $item->getTwytUserUrl();
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank'>{$link}</a>";

                $twytId = mysqli_real_escape_string($mySqliConnection,$item->getTwytId());
                $twytText = mysqli_real_escape_string($mySqliConnection,$item->getTwytText());
                // $twytId = $item->getTwytId();
                // $twytText = $item->getTwytText();

                $twytTextSanitized = htmlspecialchars($twytText);

                if ($this->twytController->isTwytInDb($twytId)==true){
                    $this->disabled ="disabled";
                    //$this->btnText = "Add to Favorite";
                }else{
                    $this->disabled ="";
                    //$this->btnText = "Add to Favorite";
                } 

                $viewString = $viewString . "
                    <div class='tywt-wrapper' id='div-{$item->getTwytId()}'>
                        <div class='tywt-content'>
                            <p>" . $item->getTwytText() . "</p>
                        </div>
                        <div class='twyt-url'>
                            <span>{$newLink} </span>
                        </div>
                        <br><br>
                        <div class='tywyt-user'>
                            <p>Posted by: " . $item->getTwytUserScreenName() . "<span>@" . $item->getTwytCreatedAt() . "</span></p>
                            <button type='submit' id='btn-{$twytId}' {$this->disabled} onclick=\"addToFavorite(
                                '$twytId',
                                '$twytTextSanitized',
                                '{$item->getTwytUserScreenName()}',
                                '{$link}',
                                '{$item->getTwytCreatedAt()}',
                                '{$item->getTwytProfileImage()}')\">".
                                $this->btnText.
                        "</button>
                        </div>
                    </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry " . $e->getMessage();
        }
    }

    public function view($jsonPath,$isFavorite)
    {
        
        try {
            $twytList = $this->getTwytList($jsonPath,$isFavorite);
            $this->btnText = ($isFavorite)?"Remove":"Add to Favorite";
            $viewString = "";
            // $disabled = "";
            foreach ($twytList as $item) {
                $mySqliConnection = $this->twytConnection->getMsqliConnection();
                $link = $item->getTwytUserUrl();
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank'>{$link}</a>";
               
                $twytId = mysqli_real_escape_string($mySqliConnection,$item->getTwytId());
                $twytText = mysqli_real_escape_string($mySqliConnection,$item->getTwytText());
                $twytTextSanitized = htmlspecialchars($twytText);
                if (($this->twytController->isTwytInDb($twytId)==true) && ($isFavorite==false)){
                    $this->disabled ="disabled";
                    $this->btnText = "Add to Favorite";
                }else{
                    $this->disabled ="";
                    //$this->btnText = "Add to Favorite";
                } 
                $viewString = $viewString . "
                        <div class='tywt-wrapper' id='{$item->getTwytId()}'>
                            <div class='tywt-content'>
                                <p>" . $item->getTwytText() . "</p>
                            </div>
                            <div class='twyt-url'>
                                <span>{$newLink} </span>
                            </div>
                            <br><br>
                            <div class='tywyt-user'>
                                <p>Posted by: " . $item->getTwytUserScreenName() . "<span>@" . $item->getTwytCreatedAt() . "</span></p>
                                <button type=button  id='btn-{$item->getTwytId()}' {$this->disabled} onclick=\"addToFavorite(
                                        '$twytId',
                                        '$twytTextSanitized',
                                        '{$item->getTwytUserScreenName()}',
                                        '{$link}',
                                        '{$item->getTwytCreatedAt()}',
                                        '{$item->getTwytProfileImage()}')\">".
                                     $this->btnText.
                                "</button>
                            </div>
        
                        </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry". $e->getMessage();
        }
    }
}

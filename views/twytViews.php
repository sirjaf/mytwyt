<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
// include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/models/twytModel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';

class TwytView
{
    private $twytConnection;
    private $twytController;

    public function __construct($twytConnection)
    {
        $this->twytConnection = $twytConnection;
        $this->twytController = new TwytController($this->twytConnection->getConnection());
    }

    private function getTwytList($jsonFile)
    {
        $twytList = $this->twytController->fetchTwytObject($jsonFile);
        return $twytList;
    }

    public function homeTimelimeView()
    {
        try {
            $twytService = new TwytService();
            $homeTwytList = $this->getTwytList($twytService->getHomeTimelineJsonPath());
            $viewString = "";
            foreach ($homeTwytList as $item) {
                $link = $item->getTwytUserUrl();
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank'>{$link}</a>";
                $viewString = $viewString . "
                    <div class='tywt-wrapper'>
                        <div class='tywt-content'>
                            <img src='" . $item->getTwytProfileImage() . "' height='100' width='100'>
                            <p>" . $item->getTwytText() . "</p>
                        </div>
                        <div class='twyt-url'>
                            <span>{$newLink} </span>
                        </div>
                        <br><br>
                        <div class='tywyt-user'>
                            <p>Posted by: " . $item->getTwytUserScreenName() . "<span>@" . $item->getTwytCreatedAt() . "</span></p>
                            <button type='button' disabled>Add to Favorite</button>
                        </div>
                    </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry " . $e->getMessage();
        }
    }

    public function view($jsonPath)
    {
        
        try {
            $twytList = $this->getTwytList($jsonPath);
            $viewString = "";
            foreach ($twytList as $item) {
                $link = $item->getTwytUserUrl();
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank'>{$link}</a>";
                $viewString = $viewString . "
                        <div class='tywt-wrapper'>
                            <div class='tywt-content'>
                                <img src='" . $item->getTwytProfileImage() . "' height='100' width='100'>
                                <p>" . $item->getTwytText() . "</p>
                            </div>
                            <div class='twyt-url'>
                                <span>{$newLink} </span>
                            </div>
                            <br><br>
                            <div class='tywyt-user'>
                                <p>Posted by: " . $item->getTwytUserScreenName() . "<span>@" . $item->getTwytCreatedAt() . "</span></p>
                                <button type='button' disabled>Add to Favorite</button>
                            </div>
        
                        </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry";
        }
    }
}

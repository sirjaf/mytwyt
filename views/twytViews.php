<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/controllers/twytController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/services/twytService.php';

class TwytView
{
    private $twytController;
    private $disabled = "";
    private $btnText;
    private $imagesPath;
    const BASE_URL = "https://jafsoft.com.ng";
    
    public function __construct($twytController)
    {
        $this->twytController = $twytController;
        $this->imagesPath = '/mytwyt/images'; //self::BASE_URL .
    }

    private function getTwytList($jsonFile, $isFavarite)
    {
        if ($isFavarite == true) {
            $twytList = $this->twytController->fetchFavoriteTwytObjects($jsonFile);
            return $twytList;
        } else {
            $twytList = $this->twytController->fetchTwytObjects($jsonFile);
            return $twytList;
        }
    }

    // public function homeTimelimeView()
    // {
    //     try {

    //         $homeTwytList = $this->getTwytList($this->twytController->getHomeTimelineJson(), false);
    //         $this->btnText = "Add to Favorite";
    //         $viewString = "<div class='twyt-list-wrapper'>";
    //         $mySqliConnection = $this->twytController->getMsqliConnection();
    //         foreach ($homeTwytList as $item) {

    //             $link = $item->getTwytUserUrl();
    //             $twytLink = "https://twitter.com/{$item->getTwytUserScreenName()}/status/{$item->getTwytId()}";
    //             $shareLink = ($link == "") ? $twytLink : $link;
    //             $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank'>{$link}</a>";

    //             $twytId = mysqli_real_escape_string($mySqliConnection, $item->getTwytId());
    //             $twytText = mysqli_real_escape_string($mySqliConnection, $item->getTwytText());
    //             $twytTextSanitized = htmlspecialchars($twytText);

    //             if ($this->twytController->isTwytInDb($twytId) == true) {
    //                 $this->disabled = "disabled";
    //             } else {
    //                 $this->disabled = "";
    //             }

    //             $viewString = $viewString . "
                
    //                 <div class='tywt-wrapper' id='div-{$item->getTwytId()}'>
    //                     <div class='tywt-content'>
    //                         <img src='$this->imagesPath/{$item->getTwytUserScreenName()}.jpeg' width=48 height=48 alt='{$item->getTwytUserScreenName()}'>
    //                         <p>" . $item->getTwytText() . "</p>
    //                     </div>
    //                     <div class='twyt-url'>
    //                         <span>{$newLink} </span>
    //                     </div>
    //                     <br><br>
    //                     <div class='tywyt-user'>
    //                         <p> 
    //                             <a href='/mytwyt/search/index.php?screenname={$item->getTwytUserScreenName()}'>{$item->getTwytUserScreenName()} </a>
    //                             <span>@" . $item->getTwytCreatedAt() . "</span>
    //                         </p>

    //                         <div class='tywyt-user-actions'>

    //                             <input type='checkbox' name='selFavorite' id='chk-favorite{$twytId}' value=''/>
                               
    //                             <button type='submit' id='btn-share{$twytId}' onclick=\"shareTwyt(
    //                                 '$twytId',
    //                                 '$twytTextSanitized',
    //                                 '{$item->getTwytUserScreenName()}',
    //                                 '{$shareLink}',
    //                                 '{$item->getTwytCreatedAt()}')\">
    //                                 Share
    //                             </button>
    //                             <button type='submit' id='btn-{$twytId}' {$this->disabled} onclick=\"addToFavorite(
    //                                 '$twytId',
    //                                 '$twytTextSanitized',
    //                                 '{$item->getTwytUserScreenName()}',
    //                                 '{$link}',
    //                                 '{$item->getTwytCreatedAt()}',
    //                                 '{$item->getTwytProfileImage()}')\">" .
    //                 $this->btnText .
    //                 "</button>
                                
    //                         </div>    
    //                     </div>
    //                 </div>";
    //         }
    //         return $viewString;
    //     } catch (\Throwable $e) {
    //         echo "Sorry " . $e->getMessage();
    //     }
    // }

    public function view($jsonPath, $isFavorite)
    {

        try {
            $twytList = $this->getTwytList($jsonPath, $isFavorite);
            $this->btnText = ($isFavorite) ? "Remove" : "Add to Favorite";
            $viewString = "<div class='twyt-list-wrapper'>";
            $mySqliConnection = $this->twytController->getMsqliConnection();
            foreach ($twytList as $item) {

                $link = $item->getTwytUserUrl();
                $twytLink = "https://twitter.com/{$item->getTwytUserScreenName()}/status/{$item->getTwytId()}";
                $shareLink = ($link == "") ? $twytLink : $link;
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank' rel='noopener noreferrer'>{$link}</a>";

                $twytId = mysqli_real_escape_string($mySqliConnection, $item->getTwytId());
                $twytText = mysqli_real_escape_string($mySqliConnection, $item->getTwytText());
                $twytTextSanitized = htmlspecialchars($twytText);
                if (($this->twytController->isTwytInDb($twytId) == true) && ($isFavorite == false)) {
                    $this->disabled = "disabled";
                    $this->btnText = "Add to Favorite";
                } else {
                    $this->disabled = "";
                }
                $viewString = $viewString . "
                    
                        <div class='tywt-wrapper' id='{$item->getTwytId()}'>
                            <div class='tywt-content'>
                                <img src='$this->imagesPath/{$item->getTwytUserScreenName()}.jpeg' width=48 height=48 alt='{$item->getTwytUserScreenName()}'>
                                <p>" . $item->getTwytText() . "</p>
                            </div>
                            <div class='twyt-url'>
                                <span>{$newLink} </span>
                            </div>
                            <br><br>
                            <div class='tywyt-user'>
                                <p>
                                    <a href='/mytwyt/search/index.php?screenname={$item->getTwytUserScreenName()}'>{$item->getTwytUserScreenName()} </a>
                                    <span>@" . $item->getTwytCreatedAt() . "</span>
                                </p>

                                <div class='tywyt-user-actions'>
                                 
                                <input type='checkbox' name='selFavorite' id='chk-favorite{$twytId}' value='' aria-label='select' style='margin-top: 10px;margin-bottom: 10px;margin-left: 10px;margin-right: 10px;width: 16px;height: 16px;'/>
                        
                                <button type='button' id='btn-share{$twytId}' onclick=\"shareTwyt(
                                    '$twytId',
                                    '$twytTextSanitized',
                                    '{$item->getTwytUserScreenName()}',
                                    '{$shareLink}',
                                    '{$item->getTwytCreatedAt()}')\">
                                    Share
                                </button>
                                <button type='button' id='btn-{$twytId}' {$this->disabled} onclick=\"addToFavorite(
                                    '$twytId',
                                    '$twytTextSanitized',
                                    '{$item->getTwytUserScreenName()}',
                                    '{$link}',
                                    '{$item->getTwytCreatedAt()}',
                                    '{$item->getTwytProfileImage()}')\">" .
                    $this->btnText .
                    "</button>
                                
                            </div>    
                            </div>
        
                        </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry" . $e->getMessage();
        }
    }

    public function viewSearch(string $screenName)
    {
        try {

            $mySqliConnection = $this->twytController->getMsqliConnection();
            $userTimelineTwyts = $this->twytController->getUserTimelineTwyts(mysqli_real_escape_string($mySqliConnection, $screenName));
            $this->btnText = "Add to Favorite";
            $viewString = "<div class='twyt-list-wrapper'>";
            foreach ($userTimelineTwyts as $item) {
                $link = $item->getTwytUserUrl();
                $twytLink = "https://twitter.com/{$item->getTwytUserScreenName()}/status/{$item->getTwytId()}";
                $newLink = ($link == null) ? "" : "<a href='{$link}' target='_blank' rel='noopener noreferrer'>{$link}</a>";
                $shareLink = ($link == "") ? $twytLink : $link;
                $twytId = mysqli_real_escape_string($mySqliConnection, $item->getTwytId());
                $twytText = mysqli_real_escape_string($mySqliConnection, $item->getTwytText());

                $twytTextSanitized = htmlspecialchars($twytText);

                if ($this->twytController->isTwytInDb($twytId) == true) {
                    $this->disabled = "disabled";
                } else {
                    $this->disabled = "";
                }

                $viewString = $viewString . "
                
                    <div class='tywt-wrapper' id='div-{$item->getTwytId()}'>
                        <div class='tywt-content'>
                            <img src='$this->imagesPath/{$item->getTwytUserScreenName()}.jpeg' width=48 height=48 alt='{$item->getTwytUserScreenName()}'>
                            <p>" . $item->getTwytText() . "</p>
                        </div>
                        <div class='twyt-url'>
                            <span>{$newLink} </span>
                        </div>
                        <br><br>
                        <div class='tywyt-user'>
                            
                            <p>Posted by: " . $item->getTwytUserScreenName() . "<span>@" . $item->getTwytCreatedAt() . "</span></p>
                            <div class='tywyt-user-actions'>

                                <input type='checkbox' name='selFavorite' id='chk-favorite{$twytId}' value=''/>
                                
                                <button type='submit' id='btn-share{$twytId}' onclick=\"shareTwyt(
                                    '$twytId',
                                    '$twytTextSanitized',
                                    '{$item->getTwytUserScreenName()}',
                                    '{$shareLink}',
                                    '{$item->getTwytCreatedAt()}')\">
                                    Share
                                </button>
                                <button type='submit' id='btn-{$twytId}' {$this->disabled} onclick=\"addToFavorite(
                                    '$twytId',
                                    '$twytTextSanitized',
                                    '{$item->getTwytUserScreenName()}',
                                    '{$link}',
                                    '{$item->getTwytCreatedAt()}',
                                    '{$item->getTwytProfileImage()}')\">" .
                    $this->btnText .
                    "</button>
                                
                            </div>    
                        </div>
                    </div>";
            }
            return $viewString;
        } catch (\Throwable $e) {
            echo "Sorry " . $e->getMessage();
        }
    }
}

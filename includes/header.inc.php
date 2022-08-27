<?php header('Access-Control-Allow-Origin: *');  ?>
<!DOCTYPE html>
    <html lang='en' id="site-html">
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name="description" content="Twitter Client for Personal Account">
        <meta name="keywords" content="jaafar, twitter,jaafar twitter home">
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" type="text/css" href="/mytwyt/css/main.css">
        <title>mytwyt</title>
        <link rel="icon" type="image/x-icon" href="/mytwyt/favicon/favicon.png">
    </head>
        <body id="site-body">
            <main>
                <div class="main-content-wrapper">
                    <div class="header">
                       
                        <span id="span-header" onclick="hideShowNav()">mytwyt</span>
                        <nav id="nav-header">
                            
                            <ul>
                                <li <?php echo $activeArray['home'];?>>
                                    <a href="/mytwyt/index.php">Home|Latest</a>
                                </li>
                                <li <?php echo $activeArray['nigerian-news'];?>>
                                    <a href="/mytwyt/nigerian-news/index.php">Nigerian-News</a>
                                </li>
                                <li <?php echo $activeArray['web-dev'];?>>
                                    <a href="/mytwyt/web-dev/index.php">Web Dev</a>
                                </li>
                                <li <?php echo $activeArray['flutter'];?>>
                                    <a href="/mytwyt/flutter/index.php">Flutter</a>
                                </li>
                                <li <?php echo $activeArray['technology'];?>>
                                    <a href="/mytwyt/technology/index.php">Technology</a>
                                </li>
                                <li <?php echo $activeArray['football'];?>>
                                    <a href="/mytwyt/football/index.php">Football</a>
                                </li>
                                <li <?php echo $activeArray['favorites'];?>>
                                    <a href="/mytwyt/favorites/index.php">Favorites</a>
                                </li>
                                <li <?php echo $activeArray['search'];?>>
                                    <a href="/mytwyt/search/index.php">Search Users</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div id="action-header">
                        <button type="button" onclick="selectAll()">Select All</button>
                        <button type="button" onclick="shareSelected()">Share</button>
                        <button type="button" id="btnFavoritesSelected" onclick="addFavoritesSelected()">
                            <?php
                              if($page != "favorite"){
                                echo ("Add Favorites");
                            }
                              else{
                                echo ("Remove Favorites");
                            }
                            ?>
                        </button>
                    </div>
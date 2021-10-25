    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel="stylesheet" type="text/css" href="/mytwyt/css/main.css">
        <title>mytwyt</title>
    </head>
        <body>
            <main>
                <div class='main-content-wrapper'>
                 <nav>
                    <span>mytwyt</span>
                    <ul>
                        <li>Home|Latest</li>
                        <li>Nigerian-News</li>
                        <li>Web Dev</li>
                        <li>
                            <a href="/mytwyt/views/twytViewFlutter.php">Flutter</a>
                        </li>
                        <li>Technology</li>
                        <li>Android News</li>
                        <li>Football</li>
                        <li>Favorites</li>
                    </ul>
                 </nav>
                    <div class='twyt-list-wrapper'>
                        <?php 
                            require require_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/views/twytViewHomeTimeline.php';
                        ?>
                    </div>
                  
                </div>
            </main>
        </body>
    </html>
<?php
require "vendor/autoload.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/mytwyt/services/twytService.php';


//$reqPrefs['http']['header'] = 'X-Auth-Token: 352e6612f90546368c8e81a8eb633c35';

$reqPrefs['http']['method'] = 'GET';
// $myParams = array(
//     'oauth_consumer_key' => 'Dsmr86yGxNH3ujPIkQl4cpcKx',
//     'oauth_nonce' => 'dUvZs1FlDL1',
//     'oauth_signature' => 'V%2FM59lcShW2jRqGmVLNgZO2lMFU%3D',
//     'oauth_signature_method' => 'HMAC-SHA1',
//     'oauth_timestamp' => '1631782784',
//     'oauth_token' => '391616463-rCR7R6tj9EQ9VJtqdbCYqPizFZpjN4d1YY8pdUGn',
//     'oauth_version' => '1.0'
// );

    //$myFile = $_SERVER['DOCUMENT_ROOT']."/mytwyt/test.json";
    // $stream_context = stream_context_create($reqPrefs);
    //$response = file_get_contents($myURL, false, $stream_context);
    //$response = file_get_contents( $myFile);
    // //echo  $response;
    // $newResult = json_decode($response,true);
    // $fp = fopen($myFile, 'w');
    // fwrite($fp, $response);
    //echo phpinfo();

    
    // // $content = $connection->get("account/verify_credentials");
    
    //$myResult = json_encode($result,JSON_UNESCAPED_SLASHES);
    //$myResult = json_encode($response,JSON_UNESCAPED_SLASHES);
    //$newResult = json_decode($response,true);
//     $pageHead =  "
//     <!DOCTYPE html>
//     <html lang='en'>
//     <head>
//         <meta charset='UTF-8'>
//         <meta http-equiv='X-UA-Compatible' content='IE=edge'>
//         <meta name='viewport' content='width=device-width, initial-scale=1.0'>
//         <link rel=\"stylesheet\" type=\"text/css\" href=\"/mytwyt/css/main.css\">
//         <title>MyTwyt</title>
//     </head>
//         <body>
//             <main>
//                 <div class='main-content-wrapper'>
//                  <nav>
//                     <span>myTwyt</span>
//                     <ul>
//                         <li>Home|Latest</li>
//                         <li>Flutter</li>
//                         <li>Web Dev</li>
//                         <li>Technology</li>
//                         <li>Android News</li>
//                         <li>Football</li>
//                         <li>Nigerian-News 1</li>
//                         <li>Nigerian-News 2</li>
//                     <ul>
//                  </nav>";
//     $pageFooter = "
//                 </div>
//             </main>
//         </body>
//     </html>";
//     $pageMainContent ="" ;   
//     foreach ($newResult as $item) {
//         $myDate = date_create_from_format('d-M-Y',$item['created_at']);
//         $pageMainContent = $pageMainContent . "
//                 <div class='tywt-wrapper'>
//                     <div class='tywt-content'>
//                         <img src='{$item['user']['profile_image_url_https']}' height='100' width='100'>
//                         <p>{$item['text']}</p>
//                     </div>
//                     <br><br>
//                     <div class='tywyt-user'>
//                         <p>Posted by: {$item['user']['screen_name']} <span>@{$item['created_at']}</span></p>
//                         <button>Add to Favorite</button>
//                     </div>

//                 </div>";
          
//     }
// echo $pageHead.$pageMainContent.$pageFooter;
$twyts = new TwytService();
//$twyts->fetchTwyt(TwytService::noCodeApiHomeTimeline,"nocodeApiHomeTimeline.json");
var_dump( $twyts->fetchListStatusJson(203355522,"my-android-list"));
<?php $activeArray = array(
    "home" => "",
    "nigerian-news" => "",
    "web-dev" => "",
    "flutter" => "",
    "technology" => "",
    "android-news" => "",
    "football" => "",
    "favorites" => "",
    "search" => "class='active'"
); ?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/header.inc.php'; 
    date_default_timezone_set("Africa/Lagos");
?>
<?php
    $screenName = $_GET['screenname']??'';
    echo "<div class=searchForm>
        <h1>Search For User Timeline</h1>
        <form >
            <input type='text' name='screenName' id='txtScreenName' value= '{$screenName}' >
            <button type='button' id='btnSearch'>Search</button>
        </form>
       
        <div id='searchProgressContainer' class='hide'>
            <div class='searchProgress' ></div>
        </div>
        <div id='twyt-list-wrapper'>

        </div>
    </div>";
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/footer.inc.php'; ?>
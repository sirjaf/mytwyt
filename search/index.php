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
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/header.inc.php'; ?>
<?php
    $screenName = $_GET['screenname']??'';
    echo "<div class=searchForm>
        <h1>Search For User Timeline</h1>
        <form action='/mytwyt/search/searchProcessor.php'>
            <input type='text' name='screenName' id='txtScreenName' value= '{$screenName}' >
            <button type='submit' id='btnSearch'>Search</button>
        </form>
        <progress value='0' max='100'>
        </progress>
        <div id='twyt-list-wrapper'>

        </div>
    </div>";
?>
<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/mytwyt/includes/footer.inc.php'; ?>
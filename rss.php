<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>RSS</title>
</head>
<header>
    <H1>RSS</H1>
</header>
<body>
<h2>RSS feed</h2>
<?php

$feed = simplexml_load_file('https://www.ndl.go.jp/en/rss/update.xml');
$item = 3;
$loendur = 0;

foreach ($feed->channel->item as $item) {
    echo "<li>";
    echo "<a href='$item->link' target='_blank'> $item->title <a/>";
    echo "</li>";
    $loendur++;
}

?>
</body>
</html>
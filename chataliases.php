<?php

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

//$results = $conn->query('SELECT alias FROM ad_revs WHERE username = "' . $_COOKIE['chataddr'] . '" && (aim = "' . $_COOKIE['chataddr'] . '" || start = "' .  $_COOKIE['chataddr'] . '") && (aim = "' . $_COOKIE['myemail'] . '" || start = "' .  $_COOKIE['myemail'] . '") LIMIT 1');
$results = $conn->query('SELECT alias FROM ad_revs, chat WHERE (aim = "' . $_COOKIE['myemail'] . '" || start = "' .  $_COOKIE['myemail'] . '") && (aim = username || start = username)');

$c = "";

if ($results->num_rows > 0) {
    while ($row = $results->fetch_assoc())
        $c[] = $row['alias'];
    
}
foreach ($c as $v)
    $f[] = $v;

setcookie("aliases", json_encode($f));
?>
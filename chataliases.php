<?php

function getaliases($con) {
    $results = $conn->query('SELECT username FROM ad_revs, chat WHERE (aim = "' . $_COOKIE['myemail'] . '" || start = "' .  $_COOKIE['myemail'] . '") && (aim = username || start = username) && username != "' .  $_COOKIE['myemail'] . '"');
    
    $c = [];
    $d = [];
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $c[] = $row['username'];
        }
    }
    
    $f = [];
    foreach ($c as $v)
        $f[] = $v;
        
    echo json_encode($c);
    
    setcookie("aliases", json_encode($f));
}

function getfilename($con) {
    $results = $conn->query('SELECT filename FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" && start = "' .  $_COOKIE['chataddr'] . '") || (aim = "' . $_COOKIE['chataddr'] . '" && start = "' .  $_COOKIE['myemail'] . '")');
    
    $d = "oajc";
    
    if ($results->num_rows == 1) {
        $d = $row['filename'];
    }
    setcookie("chatfile", $d);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");
if ($_GET['c'] == 1)
    getaliases($conn);
else if ($_GET['c'] == 2)
    getfilename($conn);
?>
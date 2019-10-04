<?php

function getaliases($con) {
    $results = $con->query('SELECT username FROM ad_revs, chat WHERE username != "' . $_COOKIE['myemail'] . '" && (aim = "' . $_COOKIE['myemail'] . '" || start = "' .  $_COOKIE['myemail'] . '") ORDER BY last DESC') or die (mysqli_error($con));
    
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
    
    $f = array_unique($f);
    echo json_encode($f);
    
}

function getconduct($cnxn) {
    $results = $cnxn->query('SELECT filename, id, conduct_on FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" && start = "' .  $_GET['d'] . '") || (aim = "' . $_GET['d'] . '" && start = "' .  $_COOKIE['myemail'] . '") LIMIT 1') or die(mysqli_error($cnxn));

// Check if the store has conduct flag on/off
    if ($results->num_rows == 1) {
        $row = $results->fetch_assoc();
        $d = $row['conduct_on'];
        echo $row['conduct_on'];
        setcookie("conductOn", $d);
    }
    else
        echo 1;
}

function flagComment($cn) {
    
    $results = $cn->query('SELECT filename, conduct_on, id FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" && start = "' .  $_GET['d'] . '") || (aim = "' . $_GET['d'] . '" && start = "' .  $_COOKIE['myemail'] . '")') or die(mysqli_error($con));

    $row = [];
    $row = [];
    
    if ($results->num_rows == 1) {
        $row = $results->fetch_assoc();
        $d[0] = $row['id'];
        echo json_encode($d[0]);
        setcookie("chatfile", $row['filename']);
    // Insert new record of banned language
        $time = date("Y-m-d H:i:s",$_GET['time']);
        echo "\n" . $row['id'] . "\n";
        $id = $d[0];
        $d[1] = $row['conduct_on'];
        $sql = 'INSERT INTO conduct(serial_id,chat_id,conduct_on,message,date,flagged,username)
            VALUES (null,' . (int)$d[0] . ',' . (int)$d[1] . ',"' . $_GET['msg'] . '","' . $time . '",1,"' . $_GET['d'] . '")';
        $results = $cn->query($sql) or die(mysqli_error($cn));
    }
}

function getfilename($con) {

// Retrieve filename of chat
    $results = $con->query('SELECT filename, id FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" && start = "' .  $_GET['d'] . '") || (aim = "' . $_GET['d'] . '" && start = "' .  $_COOKIE['myemail'] . '")') or die(mysqli_error($con));
    if ($results->num_rows == 1) {
        $row = $results->fetch_assoc();
        $d = $row['filename'];
        echo json_encode($d);
        setcookie("chatfile", $d);
    }
}

function setconduct($con) {

    $results = $con->query('SELECT aim, conduct_on FROM chat WHERE filename = "'. $_COOKIE['chatfile'] . '"') or die(mysqli_error($con));
    if ($results->num_rows == 1) {
        $row = $results->fetch_assoc();
        $d = $row['conduct_on'];
    
    // Only a store can set the conduct flag
    // Stores are always the 'aim' column
    // People aren't called by stores, it's vice versa
        if ($row['aim'] != $_COOKIE['myemail'])
            return;
        echo json_encode($d);
        setcookie("chatfile", $d);
        $bool = ($d == 1) ? 0 : 1;
        $return = $con->query('UPDATE chat SET conduct_on = ' . $bool . ' WHERE filename = "'. $_COOKIE['chatfile'] . '"');
    }
}

function newconduct($cxn) {
    
    $results = $cxn->query('SELECT conduct_on, id FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" && start = "' .  $_GET['d'] . '") || (aim = "' . $_GET['d'] . '" && start = "' .  $_COOKIE['myemail'] . '")') or die(mysqli_error($cxn));

    $row = [];
    
    if ($results->num_rows == 1) {
        $row = $results->fetch_assoc();
        $d[0] = $row['conduct_on'];
        echo json_encode($d[0]);
        setcookie("chatfile", $d[0]);
        $d[1] = $row['id'];
    // Insert new record of banned language
        $sql = 'INSERT INTO conduct(serial_id,chat_id,conduct_on,message,date,flagged,username)
            VALUES (null,' . (int)$d[1] . ',' . (int)$d[0] . ',"' . $_GET['a'] . '",CURRENT_TIMESTAMP,0,"' . $_COOKIE['myemail'] . '")';
        $results = $cxn->query($sql) or die(mysqli_error($cxn));
    }
}

$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

if ($_GET['c'] == 1)
    getaliases($conn);
else if ($_GET['c'] == 2)
    getfilename($conn);
else if ($_GET['c'] == 3)
    getconduct($conn);
else if ($_GET['c'] == 4)
    newconduct($conn);
else if ($_GET['c'] == 5)
    setconduct($conn);
else if ($_GET['c'] == 6)
    flagComment($conn);
?>
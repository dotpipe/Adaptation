<?php

include("db.php");
function getaliases($con) {
    $sql = 'SELECT username FROM ad_revs, chat WHERE username != :myemail AND (aim = :myemail OR start = :myemail) ORDER BY last DESC';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    
    $c = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $c[] = $row['username'];
    }
    
    $f = array_unique($c);
    echo json_encode($f);
    
}

function getconduct($cnxn) {
    $sql = 'SELECT filename, id, conduct_on FROM chat WHERE (aim = :myemail1 AND start = :start1) OR (aim = :start2 AND start = :myemail2) LIMIT 1';
    $stmt = $cnxn->prepare($sql);
    $stmt->bindParam(':myemail1', $_COOKIE['myemail']);
    $stmt->bindParam(':start1', $_GET['d']);
    $stmt->bindParam(':start2', $_GET['d']);
    $stmt->bindParam(':myemail2', $_COOKIE['myemail']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d = $row['conduct_on'];
        echo $row['conduct_on'];
        setcookie("conductOn", $d);
    } else {
        echo 1;
    }
}

function flagComment($cn) {
    $sql = 'SELECT filename, conduct_on, id FROM chat WHERE (aim = :myemail1 AND start = :start1) OR (aim = :start2 AND start = :myemail2)';
    $stmt = $cn->prepare($sql);
    $stmt->bindParam(':myemail1', $_COOKIE['myemail']);
    $stmt->bindParam(':start1', $_GET['d']);
    $stmt->bindParam(':start2', $_GET['d']);
    $stmt->bindParam(':myemail2', $_COOKIE['myemail']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d[0] = $row['id'];
        echo json_encode($d[0]);
        setcookie("chatfile", $row['filename']);
    
        $time = date("Y-m-d H:i:s", $_GET['time']);
        $id = $d[0];
        $d[1] = $row['conduct_on'];
        $sql = 'INSERT INTO conduct(serial_id,chat_id,conduct_on,message,date,flagged,username) VALUES (null, :chat_id, :conduct_on, :msg, :time, 1, :username)';
        $stmt = $cn->prepare($sql);
        $stmt->bindParam(':chat_id', $id);
        $stmt->bindParam(':conduct_on', $d[1]);
        $stmt->bindParam(':msg', $_GET['msg']);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':username', $_GET['d']);
        $stmt->execute();
    }
}

function getfilename($con) {
    $sql = 'SELECT filename, id FROM chat WHERE (aim = :myemail1 AND start = :start1) OR (aim = :start2 AND start = :myemail2)';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':myemail1', $_COOKIE['myemail']);
    $stmt->bindParam(':start1', $_GET['d']);
    $stmt->bindParam(':start2', $_GET['d']);
    $stmt->bindParam(':myemail2', $_COOKIE['myemail']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d = $row['filename'];
        echo json_encode($d);
        setcookie("chatfile", $d);
    }
}

function setconduct($con) {
    $sql = 'SELECT aim, conduct_on FROM chat WHERE filename = :chatfile';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':chatfile', $_COOKIE['chatfile']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d = $row['conduct_on'];
    
        // Only a store can set the conduct flag
        // Stores are always the 'aim' column
        // People aren't called by stores, it's vice versa
        if ($row['aim'] != $_COOKIE['myemail']) {
            return;
        }
    
        echo json_encode($d);
        setcookie("chatfile", $d);
        $bool = ($d == 1) ? 0 : 1;
        $sql = 'UPDATE chat SET conduct_on = :bool WHERE filename = :chatfile';
        $stmt = $con->prepare($sql);
        $stmt->bindParam(':bool', $bool);
        $stmt->bindParam(':chatfile', $_COOKIE['chatfile']);
        $stmt->execute();
    }
}

function newconduct($cxn) {
    $sql = 'SELECT conduct_on, id FROM chat WHERE (aim = :myemail1 AND start = :start1) OR (aim = :start2 AND start = :myemail2)';
    $stmt = $cxn->prepare($sql);
    $stmt->bindParam(':myemail1', $_COOKIE['myemail']);
    $stmt->bindParam(':start1', $_GET['d']);
    $stmt->bindParam(':start2', $_GET['d']);
    $stmt->bindParam(':myemail2', $_COOKIE['myemail']);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d[0] = $row['conduct_on'];
        echo json_encode($d[0]);
        setcookie("chatfile", $d[0]);
        $d[1] = $row['id'];
        // Insert new record of banned language
        $sql = 'INSERT INTO conduct(serial_id,chat_id,conduct_on,message,date,flagged,username) VALUES (null, :chat_id, :conduct_on, :msg, CURRENT_TIMESTAMP, 0, :username)';
        $stmt = $cxn->prepare($sql);
        $stmt->bindParam(':chat_id', $d[1]);
        $stmt->bindParam(':conduct_on', $d[0]);
        $stmt->bindParam(':msg', $_GET['a']);
        $stmt->bindParam(':username', $_COOKIE['myemail']);
        $stmt->execute();
    }
}

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
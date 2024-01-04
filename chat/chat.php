<?php

include("db.php");
// Update
function updateChatFile($con) {
    $filename = $_COOKIE['chatfile'];
    $sql = 'UPDATE chat SET chat.altered = chat.last, chat.checked = 0, last = CURRENT_TIMESTAMP WHERE filename = :filename';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':filename', $filename);
    $stmt->execute();
}

// SELECT alias from ad_revs using prepared statement
$stmt1 = $conn->prepare('SELECT alias FROM ad_revs WHERE username = :username');
$stmt1->bindParam(':username', $_GET['d']);
$stmt1->execute();
$c = "";
if ($stmt1->rowCount() > 0) {
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    $c = $row['alias'];
}

// SELECT filename from chat using prepared statement
$stmt2 = $conn->prepare('SELECT filename FROM chat WHERE ((aim = :aim1 AND start = :start1) OR (aim = :aim2 AND start = :start2))');
$stmt2->bindParam(':aim1', $_GET['d']);
$stmt2->bindParam(':start1', $_COOKIE['myemail']);
$stmt2->bindParam(':aim2', $_COOKIE['myemail']);
$stmt2->bindParam(':start2', $_GET['d']);
$stmt2->execute();
$b = "";
if ($stmt2->rowCount() > 0) {
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $b = $row['filename'];
} else {
    return;
}
$filename = $b;
setcookie("chatfile", $filename);

// File operations
$xmlFilePath = '../xml/' . $filename;
if (!file_exists($xmlFilePath)) {
    file_put_contents($xmlFilePath, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
    chmod($xmlFilePath, 0644);
}

$dom = simplexml_load_file($xmlFilePath);

$tmpy = $dom->addChild("msg");
$tmp = $tmpy->addChild("text", $_GET['a']);
$tmpy->addAttribute("alias", $_COOKIE['myalias'] . " <-> "  . $c);
$tmp->addAttribute("time", time());
$tmp->addAttribute("user", $_COOKIE['myemail']);
$tmp->addAttribute("alias", $_COOKIE['myalias']);

file_put_contents($xmlFilePath, $dom->asXML());

updateChatFile($conn);
?>
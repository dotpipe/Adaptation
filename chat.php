<?php
include("db.php");
// Update
function updateChatFile($con)
{// Update the chat record using PDO
$filename = $_COOKIE['chatfile'];

$stmt = $con->prepare('UPDATE chat SET altered = last, checked = 0, last = CURRENT_TIMESTAMP WHERE filename = :filename');
$stmt->bindParam(':filename', $filename);
$stmt->execute();

}

// Prepare and execute the SELECT query using PDO
$chataddr = $_COOKIE['chataddr'];

$stmt = $conn->prepare('SELECT alias FROM ad_revs WHERE username = :chataddr');
$stmt->bindParam(':chataddr', $chataddr);
$stmt->execute();

// Get chat alias of the other side (store manager)
$c = "";
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $c = $row['alias'];
}

// Prepare and execute the SELECT query using PDO
$chataddr = $_COOKIE['chataddr'];
$myemail = $_COOKIE['myemail'];

$stmt = $conn->prepare('SELECT filename FROM chat WHERE ((aim = :chataddr1 && start = :myemail1) || (aim = :myemail2 && start = :chataddr2))');
$stmt->bindParam(':chataddr1', $chataddr);
$stmt->bindParam(':myemail1', $myemail);
$stmt->bindParam(':myemail2', $myemail);
$stmt->bindParam(':chataddr2', $chataddr);
$stmt->execute();

// Fetch the results
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Process the results as needed
    echo $row['filename'];
}

$filename = $b;
setcookie("chatfile", $filename);
if (!file_exists('xml/' . $filename)) {
    file_put_contents('xml/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
    chmod('xml/' . $filename, 0644);
}

$dom = "";

$dom = simplexml_load_file("xml/" . $filename);

$x = $dom->messages;
$v = $_GET['a'];
$n = "";

$tmpy = $dom->addChild("msg");
$tmp = $tmpy->addChild("text", $v);
$tmpy->addAttribute("alias", $_COOKIE['myalias'] . " <-> " . $c);

$tmp->addAttribute("time", time());
$tmp->addAttribute("user", $_COOKIE['myemail']);
$tmp->addAttribute("alias", $_COOKIE['myalias']);
echo $dom->asXML('xml/' . $filename);

updateChatFile($conn);

?>
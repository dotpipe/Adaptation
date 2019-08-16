<?php

function updateChatFile($conn) {
    $filename = $_COOKIE['chatfile'];
    $sql = 'UPDATE chat SET `before` = `chat.last`, last = CURRENT_TIMESTAMP WHERE filename = "' . $filename . '"';
    $results = $conn->query($sql);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

    if (!isset($_SESSION))
        session_start();
    
    $filename = './xml/' . $_COOKIE['chatfile'] . ".xml";

    if (!file_exists($filename))
        file_put_contents($filename, '<?xml version=\'1.0\'?><messages></messages>');

    $dom = new \DomDocument();
    $dom->load($filename);

    $z = $dom->getElementsByTagName("messages");
    $x = $dom->getElementsByTagName("messages")[0];
    $y = $z->childNodes;
    $i = 0;
    $v = $_GET['a'];
    $n = "";

  $tmp = $dom->createElement("msg");
  $tmp->setAttribute("user", $_COOKIE['myname']);
  $tmpy = $dom->createTextNode($v);
  $tmp->appendChild($tmpy);
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save($filename);
   updateChatFile($conn);
?>
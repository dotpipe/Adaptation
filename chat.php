<?php

function updateChatFile($con) {
    $filename = $_GET['b'];
    $sql = 'UPDATE `chat` SET `chat`.`altered` = `chat`.`last`, `chat`.`checked` = 0, last = CURRENT_TIMESTAMP WHERE filename = "' . $filename . '"';
    $results = $con->query($sql);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

    if (!isset($_SESSION))
        session_start();
    
    $filename = $_GET['b'];

    if (!file_exists('xml/' . $filename)) {
        file_put_contents('xml/' . $filename, '<?xml version=\'1.0\'?><messages></messages>');
        chmod('xml/' . $filename, 0644);
    }

    $dom = new \DomDocument();
    $dom->load('xml/' . $filename);

    $z = $dom->getElementsByTagName("messages");
    $x = $dom->getElementsByTagName("messages")[0];
    $v = $_GET['a'];
    $n = "";

  $tmp = $dom->createElement("msg");
  $tmp->setAttribute("user", $_COOKIE['myemail']);
  $tmpy = $dom->createTextNode($v);
  $tmp->appendChild($tmpy);
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save('xml/' . $filename);
   
   updateChatFile($conn);

?>
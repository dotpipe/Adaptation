<?php
// create new business and shuffle away
if (!isset($_SESSION))
    session_start();

    if (!file_exists('branches.xml'))
    file_put_contents('branches.xml', "<?xml version='1.0'?><accounts></accounts>");

    $dom = new \DomDocument();
    $dom->load('branches.xml');
  
    $z = $dom->getElementsByTagName("accounts");
    $x = $dom->getElementsByTagName("accounts")[0];
  
    $tmp = $dom->createElement("links");
    foreach ($_GET as $k=>$v) {
      $tmp->setAttribute($k,$v);
    }
     $x->appendChild($tmp);
     $dom->appendChild($x);
     $dom->save('branches.xml');
  
  header("Location: linkxml.php");
  
  ?>
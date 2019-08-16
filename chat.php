<?php
    if (!isset($_SESSION))
        session_start();
    $filename = './xml/' . md5($_COOKIE['id']) . ".xml";
    
    setcookie('chatfile','./xml/' . md5($_COOKIE['id']) . ".xml");
    if (!file_exists($filename))
        file_put_contents($filename, '<?xml version="1.0"?><messages></messages>');

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
?>
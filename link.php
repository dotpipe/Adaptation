<?php
if (!isset($_SESSION))
    session_start();
    
  if (!file_exists('./xml/' . md5($_COOKIE['myid']) . '.xml'))
    file_put_contents('./xml/' . md5($_COOKIE['myid']) . '.xml', '<?xml version=\'1.0\'?><accounts></accounts>');
  $xml = simplexml_load_file('./xml/' . md5($_COOKIE['myid']) . '.xml');
  
    $list = $xml->link;
    $arr = [];
    foreach ($_POST as $k=>$v) {
      $arr[$k] = $v;
    }
    for ($i = 0; $i < count($list); $i++) {
  	if ($list[$i]['no'] == $arr['no'] && $list[$i]['addr'] == $arr['addr']) {
  		
  		header("Location: ./");
  
  	}
    }
    $dom = new \DomDocument();
    $dom->load('./xml/' . md5($_COOKIE['myid']) . '.xml');
  
    $z = $dom->getElementsByTagName("accounts");
    $x = $dom->getElementsByTagName("accounts")[0];
    $y = $z->childNodes;
    $n = "";
  
    $tmp = $dom->createElement("link");
    foreach ($_POST as $k=>$v) {
      $tmp->setAttribute($k,$v);
    }
     $x->appendChild($tmp);
     $dom->appendChild($x);
     $dom->save('./xml/' . md5($_COOKIE['myid']) . '.xml');
  header("Location: ./linkxml.php");
  ?>
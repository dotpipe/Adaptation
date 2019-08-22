<?php
if (!isset($_SESSION))
    session_start();
    
  if (!file_exists('branches.xml'))
    file_put_contents('branches.xml', "<?xml version='1.0'?><accounts></accounts>");
  $xml = simplexml_load_file('branches.xml');
  
    $list = $xml->links;
    $arr = [];
    foreach ($_POST as $k=>$v) {
      $arr[$k] = $v;
    }
    for ($i = 0; $i < count($list); $i++) {
    	if ($list[$i]['store_no'] == $arr['store_no'] && $list[$i]['business'] == $arr['business']) {
    		header("Location: ./");
    	}
    }
    $dom = new \DomDocument();
    $dom->load('branches.xml');
  
    $z = $dom->getElementsByTagName("accounts");
    $x = $dom->getElementsByTagName("accounts")[0];
  
    $tmp = $dom->createElement("links");
    foreach ($_POST as $k=>$v) {
      $tmp->setAttribute($k,$v);
    }
     $x->appendChild($tmp);
     $dom->appendChild($x);
     $dom->save('branches.xml');
  header("Location: ./linkxml.php");
  ?>
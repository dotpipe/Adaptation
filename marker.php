<?php
  $xml = simplexml_load_file("newusers.xml");

  $list = $xml->marker;
  $arr = [];
  foreach ($_POST as $k=>$v) {
	$arr[$k] = $v;
  }
  for ($i = 0; $i < count($list); $i++) {
  	if ($list[$i]['email'] == $arr['email']) {
  		header("Location: ./");
  	}
  }

  $dom = new \DomDocument();
  $dom->load('stores.xml');

  $z = $dom->getElementsByTagName("users");
  $x = $dom->getElementsByTagName("users")[0];
  $y = $z->childNodes;
  $n = "";

  $tmp = $dom->createElement("user");
  foreach ($_POST as $k=>$v) {
    $tmp->setAttribute($k,$v);
  }
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save("newusers.xml");
header("Location: ./mysqlxml.php");
?>
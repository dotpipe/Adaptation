<?php
  $xml = simplexml_load_file("stores.xml");

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

  $z = $dom->getElementsByTagName("markers");
  $x = $dom->getElementsByTagName("markers")[0];
  $y = $z->childNodes;
  $n = "";

  $tmp = $dom->createElement("marker");
  foreach ($_POST as $k=>$v) {
    $tmp->setAttribute($k,$v);
  }
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save("stores.xml");
header("Location: ./mysqlxml.php");
?>
<?php
  if (!file_exists("../chat_logs/" . md5($_SESSION['user']) . ".xml"))
	file_put_contents(md5($_SESSION['user']) . ".xml", '<?xml version="1.0"?><chat></chat>');

  $dom = new \DomDocument();
  $dom->load("../chat_logs/" . md5($_SESSION['user']) . ".xml");

  $z = $dom->getElementsByTagName("chat");
  $x = $dom->getElementsByTagName("chat")[0];
  $y = $z->childNodes;
  $n = "";

  $tmp = $dom->createElement("msg");
  foreach ($_GET as $k=>$v) {
    $tmp->setAttribute($k,$v);
  }
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save("../chat_logs/" . md5($_SESSION['user']) . ".xml");

  $xml = simplexml_load_file("../chat_logs/" . md5($_SESSION['user']) . ".xml");

  $list = $xml->marker;
  $arr = "";
  for ($i = 0; $i < count($list); $i++) {
	if ($list[$i]['user'] == $_SESSION['user']) {
		$arr .= '<p style="background:gray;width:250px">' . $list[$i]['msg'] . '</p>';

	}
	else {
		$arr .= '<p style="width:250px">' . $list[$i]['msg'] . </p>;
  }
  $dom = new \DomDocument();
  $dom->load("../chat_logs/" . md5($_SESSION['user']) . ".xml");

  $z = $dom->getElementsByTagName("chat");
  $x = $dom->getElementsByTagName("chat")[0];
  $y = $z->childNodes;
  $n = "";

  $tmp = $dom->createElement("msg");
  foreach ($_GET as $k=>$v) {
    $tmp->setAttribute($k,$v);
  }
   $x->appendChild($tmp);
   $dom->appendChild($x);
   $dom->save("../chat_logs/" . md5($_SESSION['user']) . ".xml");
header("Location: ./");
?>
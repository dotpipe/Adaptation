<?php
    $filename = './xml/' . md5($_COOKIE['id']) . ".xml";
    if (!file_exists('./xml/' . $filename))
        file_put_contents('./xml/' . $filename, '<?xml version="1.0"?><preorder></preorder>');

    $dom = new \DomDocument();
    $dom->load('./xml/' . $filename);

    $z = $dom->getElementsByTagName("preorder");
    $x = $dom->getElementsByTagName("preorder")[0];
    $y = $z->childNodes;
    $i = 0;
    $a = $_GET['a'];
    $b = $_GET['b'];
    for ($i = 0 ; $i < count($z) ; $i++) {
        if ($z[$i]->getAttribute("name") == "" ||
            $z[$i]->getAttribute("quantity") == "")
            continue;
        $a .= "," . $z[$i]->getAttribute("name");
        $b .= "," . $z[$i]->getAttribute("quantity");
    }
    $varA = str_getcsv($a,",");
    $varB = str_getcsv($b,",");
    foreach ($varA as $v) {
        if ($v == null || $v == "" || $varB[$i] == "") {
            $i++;
            continue;
        }
        $tmp[] = $dom->createElement("item");
        $tmp[count($tmp)-1]->setAttribute("name",$v);
        $tmp[count($tmp)-1]->setAttribute("quantity",$varB[$i]);
        $i++;
    }
    foreach ($tmp as $v) {
        $x->appendChild($v);
    }
    $dom->appendChild($x);
    $dom->save('./xml/' . $filename);
?>
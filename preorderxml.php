<?php
    $filename = md5($_COOKIE['myemail']) . ".xml";

    if (!file_exists('preorders/' . $filename)) {
        file_put_contents('preorders/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><preorders></preorders>");
        chmod('preorders/' . $filename, 0644);
    }
    $dom = "";
    
    $dom = simplexml_load_file("preorders/" . $filename);

    $x = $dom->preorders;
    $y = $_GET['a'];
    $w = $_GET['b'];
    
    $a = str_getcsv($y,",");
    $b = str_getcsv($w,",");
    $i = 0;
    
    foreach($a as $v) {
        $tmpy = $dom->addChild("items");
        $tmp = $tmpy->addChild("product", $v);
        $tmpz = $tmpy->addChild("email", $_COOKIE['myemail']);
        $tmp = $tmpy->addAttribute("quantity", $b[$i]);
        $tmpy->addAttribute("from", $_COOKIE['myname']);
        $tmpy->addAttribute("day", date('d-m-Y',time()));
        $i++;
        echo $dom->asXML('preorders/' . $filename);
    }
    
?>
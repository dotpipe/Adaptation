<?php
    $filename = md5($_COOKIE['myemail']) . ".xml";

    if (!file_exists('preorders/.' . $filename)) {
        file_put_contents('preorders/.' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='inbox.xsl' ?><preorders></preorders>");
        chmod('preorders/.' . $filename, 0644);
    }
    $dom = "";
    
    $dom = simplexml_load_file("preorders/." . $filename);

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
        $tmpy->addAttribute("date", date('d-m-Y',time()));
        $i++;
        echo $dom->asXML('preorders/.' . $filename);
    }
    
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    if (!is_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t))) {
        mkdir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='preorders.xsl' ?><preorders></preorders>");
    }
    $dom2 = simplexml_load_file("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.' . $filename);

    $x = $dom2->preorders;

    $tmpy = $dom2->addChild("shopper");
    $tmpy->addChild("products", count($a));
    $tmpy->addChild("items", count($b));
    $tmpy->addChild("email", $_COOKIE['myemail']);
    $tmpy->addChild("from", $_COOKIE['myname']);
    $tmpy->addChild("date", date('d-m-Y',time()));
    if (!is_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t)))
        mkdir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
    echo $dom2->asXML('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.' . $filename);
    
?>
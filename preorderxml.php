<?php
    
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
<<<<<<< HEAD
    $filename = $salt . md5($_COOKIE['franchise_id'] . $t) . '.xml';
    $dom = "";
    if (!is_dir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t))){
        mkdir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Required all granted");
    }
    if (!file_exists('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename))       
        file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");

    $dom = simplexml_load_file("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);

=======
    $filename = md5($_COOKIE['myemail']) . ".xml";
    $dom = "";
    if (!is_dir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t))){
        mkdir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
    }
    if (!file_exists('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename))       
        file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
   
        
    $dom = simplexml_load_file("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);

>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    $x = $dom->preorders;
    $y = $_GET['a'];
    $w = $_GET['b'];
    
    $a = str_getcsv($y,",");
    $b = str_getcsv($w,",");
    $i = 0;
    
<<<<<<< HEAD
=======
    

>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    $tmpy = $dom->addChild("items");
    foreach($a as $v) {
        $tmpy->addChild("product", $v);
        $tmpy->addChild("email", $_COOKIE['myemail']);
        $tmpy->addAttribute("quantity", $b[$i]);
        $tmpy->addAttribute("from", $_COOKIE['myname']);
        $tmpy->addAttribute("date", date('d-m-Y',time()));
        $i++;
<<<<<<< HEAD
        $dom->asXML('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);
    }
    
    $filename = $salt . md5($_COOKIE['franchise_id'] . $t) . '.xml';
    
    if (!is_dir("inbox")) {
        mkdir("inbox");
        file_put_contents('inbox/.htaccess', "Required all granted");
    }
    if (!file_exists('inbox/' . $filename))       
        file_put_contents('inbox/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='oxml.xsl' ?><preorders></preorders>");

    $dom2 = simplexml_load_file('inbox/' . $filename);

    $x = $dom2->preorders;
    
=======
        echo $dom->asXML('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);
    }
    
    if (!is_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t))) {
        mkdir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
    }
    if (!file_exists('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename))       
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");

    $dom2 = simplexml_load_file('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);

    $x = $dom2->preorders;

>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    $tmpy = $dom2->addChild("shopper");
    $tmpy->addChild("products", count($a));
    $tmpy->addChild("items", count($b));
    $tmpy->addChild("email", $_COOKIE['myemail']);
    $tmpy->addChild("from", $_COOKIE['myname']);
    $tmpy->addChild("date", date('d-m-Y',time()));
<<<<<<< HEAD

    $dom2->asXML('inbox/' . $filename);
=======
    
    echo $dom2->asXML('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5

?>
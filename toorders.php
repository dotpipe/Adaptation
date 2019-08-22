<?php

    
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    $filename = '.' . md5($_COOKIE['franchise_id'] . $t);
    if (!is_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t))) {
        mkdir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='preorders.xsl' ?><preorders></preorders>");
    }
    $dom2 = simplexml_load_file("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);

    setcookie('orderfile', $filename);
?>
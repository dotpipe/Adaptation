<?php

function getFile($tvb) {
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    $filename = md5($tvb) . '.xml';
    if (!is_dir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t))) {
        mkdir("preorders/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Required all granted");
    }
    if (!file_exists('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename))       
            file_put_contents('preorders/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
    setcookie("order", "preorders/");
    setcookie('dir', $salt . md5($_COOKIE['franchise_id'] . $t) . '/');
    //setcookie('file', $filename);
}

function getInbox() {

    setcookie("order", "");
    setcookie('dir', '');
    setcookie('file', '');
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    if (!is_dir("inbox")) {
        mkdir("inbox");
        file_put_contents('inbox/.htaccess', "Required all granted");
    }
    if (!file_exists('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '.xml'))
            file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '.xml', "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
    setcookie("order", "inbox/");
    setcookie('dir', '');
    setcookie('file', $salt . md5($_COOKIE['franchise_id'] . $t) . '.xml');
}

if ($_GET['c'] == 's')
    getInbox();
else
    getFile($_GET['b']);

?>
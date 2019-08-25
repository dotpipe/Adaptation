<?php

function getDirectory($tvb) {
    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    $filename = $salt . md5($tvb . $_COOKIE['franchise_id'] . $t) . '.xml';
    if (!is_dir("preorders/" . $salt . md5($tvb . $_COOKIE['franchise_id'] . $t))) {
        mkdir("preorders/" . $salt . md5($tvb . $_COOKIE['franchise_id'] . $t));
        file_put_contents('preorders/' . $salt . md5($tvb . $_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
    }
    if (!file_exists('preorders/' . $salt . md5($tvb . $_COOKIE['franchise_id'] . $t) . '/' . $filename))       
        file_put_contents('preorders/' . $salt . md5($tvb . $_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
    setcookie("order", "preorders/");
    setcookie('dir', $salt . md5($tvb . $_COOKIE['franchise_id'] . $t) . '/');
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
        file_put_contents('inbox/.htaccess', "Require all granted");
    }
    if (!file_exists('inbox/' . $salt . md5($_COOKIE['myemail'] . $_COOKIE['franchise_id'] . $t) . '.xml'))
            file_put_contents('inbox/' . $salt . md5($_COOKIE['myemail'] . $_COOKIE['franchise_id'] . $t) . '.xml', "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
    setcookie("order", "inbox/");
    setcookie('file', $salt . md5($_COOKIE['myemail'] . $_COOKIE['franchise_id'] . $t) . '.xml');
}

if (isset($_GET['c']) && $_GET['c'] == 's')
    getInbox();
else
    getDirectory($_COOKIE['e']);

?>

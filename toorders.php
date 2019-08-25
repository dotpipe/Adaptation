<?php
<<<<<<< HEAD

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
=======
function scan_dir($dir) {
    $ignored = array('.', '..', '.svn', '.htaccess');

    $files = array();    
    foreach (scandir($dir) as $file) {
        if (in_array($file, $ignored)) continue;
        $files[$file] = filemtime($dir . '/' . $file);
    }

    arsort($files);
    $files = array_keys($files);

    return ($files) ? $files : false;
}

    srand($_COOKIE['franchise_id']);
    $t = rand(1,465365);
    $salt = rand(1,5);
    $filename = md5($_COOKIE['myemail']) . ".xml";
    if (!is_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t))) {
        mkdir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
        file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/.htaccess', "Require all granted");
    }
    if (!file_exists('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename))       
            file_put_contents('inbox/' . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='../oxml.xsl' ?><preorders></preorders>");
    $dom2 = simplexml_load_file("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t) . '/' . $filename);
    setcookie("order", "preorders/");
    if ($_GET['c'] == "1")
        setcookie("order", "inbox/");
    setcookie('dir', $salt . md5($_COOKIE['franchise_id'] . $t) . '/');
    $filenames = scan_dir("inbox/" . $salt . md5($_COOKIE['franchise_id'] . $t));
    setcookie('file', $filenames);
    ?>
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5

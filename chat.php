<?php

function updateChatFile($con) {
    $filename = $_COOKIE['chatfile'];
    $sql = 'UPDATE `chat` SET `chat`.`altered` = `chat`.`last`, `chat`.`checked` = 0, last = CURRENT_TIMESTAMP WHERE filename = "' . $filename . '"';
    $results = $con->query($sql);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

    $results = $conn->query('SELECT alias FROM ad_revs WHERE username = "' . $_COOKIE['chataddr'] . '"');
    
<<<<<<< HEAD
    if ($_GET['a'] == "adodocrossedthru")
        $v = "&nbsp";
    else
        $v = $_GET['a'];
    $filename = $_GET['b'];

=======
    $c = "";
    if ($results->num_rows > 0) {
        $row = $results->fetch_assoc();
        $c = $row['alias'];
    }
    
    $query_res = $conn->query('SELECT filename FROM chat WHERE ((aim = "' . $_COOKIE['chataddr'] . '" && start = "' . $_COOKIE['myemail'] . '") || (aim = "' . $_COOKIE['myemail'] . '" && start = "' . $_COOKIE['chataddr'] . '"))');
    $b = "";
    if ($query_res->num_rows > 0) {
        $row = $query_res->fetch_assoc();
        $b = $row['filename'];
    }
    
    $filename = $b;
    setcookie("chatfile",$filename);
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    if (!file_exists('xml/' . $filename)) {
        file_put_contents('xml/' . $filename, "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('xml/' . $filename, 0644);
    }
    $dom = "";
    
    $dom = simplexml_load_file("xml/" . $filename);

<<<<<<< HEAD
    $x = $dom->msg;
=======
    $x = $dom->messages;
    $v = $_GET['a'];
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    $n = "";

    $tmpy = $dom->addChild("msg");
    $tmp = $tmpy->addChild("text",$v);
<<<<<<< HEAD
    $tmpy->addAttribute("alias", $_COOKIE['store_id']);
=======
    $tmpy->addAttribute("alias", $_COOKIE['myalias'] . " <-> "  . $c);
  
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
    $tmp->addAttribute("time", time());
    $tmp->addAttribute("user", $_COOKIE['myemail']);
    $tmp->addAttribute("alias", $_COOKIE['myalias']);
    echo $dom->asXML('xml/' . $filename);
   
   updateChatFile($conn);

?>
<?php
//$con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");

$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");

$results = $con->query('SELECT id, filename FROM chat WHERE 1');
$var = [];
$temp = 0;

while ($var = $results->fetch_assoc()) {
    if (file_exists("xml/" . $var['filename']))
        continue;
    if (!file_exists("xml/" . $var['filename'])) {
        file_put_contents("xml/" . $var['filename'], "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('xml/' . $var['filename'], 0644);
    }
}

?>
<?php
//$con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");

$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");

<<<<<<< HEAD
$results = $con->query('SELECT id, filename FROM chat WHERE 1');
=======
$results = $con->query('SELECT filename FROM chat WHERE 1');
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
$var = [];
$temp = 0;

while ($var = $results->fetch_assoc()) {
    if (file_exists("xml/" . $var['filename']))
        continue;
    if (!file_exists("xml/" . $var['filename'])) {
<<<<<<< HEAD
        file_put_contents("xml/" . $var['filename'], "<?xml version=\'1.0\'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages><msg><text>&nbsp</text></msg></messages>");
=======
        file_put_contents("xml/" . $var['filename'], "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
        chmod('xml/' . $var['filename'], 0644);
    }
}

?>
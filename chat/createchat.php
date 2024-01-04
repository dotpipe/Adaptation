<?php

include("db.php");

$sql = 'SELECT id, filename FROM chat';
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$var = [];
$temp = 0;

// recover filenames
foreach ($results as $var) {
    if (file_exists("../xml/" . $var['filename'])) {
        continue;
    } else {
        file_put_contents("../xml/" . $var['filename'], "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('../xml/' . $var['filename'], 0644);
    }
}

?>
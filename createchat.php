<?php
include("db.php");

$stmt = $conn->prepare('SELECT id, filename FROM chat');
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recover filenames
foreach ($results as $var) {
    if (!file_exists("xml/" . $var['filename'])) {
        file_put_contents("xml/" . $var['filename'], "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('xml/' . $var['filename'], 0644);
    }
}

?>
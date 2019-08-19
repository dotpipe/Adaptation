<?php

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die(json_encode("Error: Cannot create connection"));

$sql = "SELECT `ad_revs`.`alias` FROM `ad_revs` WHERE '" . $_GET['a'] . "' = `ad_revs`.`username`";

$results = $conn->query($sql) or die(file_put_contents("test.txt",  mysqli_error()));

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        setcookie("contact_alias",$rows['alias']);
        
        if (!file_exists('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml")) {
            file_put_contents('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml",'<?xml version=\'1.0\'?><messages></messages>');
            chmod('./inbox/' . md5($_COOKIE['store'] . $_COOKIE['store_no']), 0666);
        }
        setcookie('inboxfile',md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml");
    }
    else {
        setcookie("store","from many stores!");
    }
?>
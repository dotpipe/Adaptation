<?php

// Grab the local tax
function getTax($con) {
    
    $sql = 'SELECT EstimatedCombinedRate AS taxed FROM taxes WHERE ZipCode  = ' . $_COOKIE['zip_code'];

    $tax = $con->query($sql);

    $row = $tax->fetch_assoc();

    setcookie("taxes", $row['taxed']);

}

// Create new chat files
function makeMyFile($cnxn) {
    $temp = 0;
    
    $results = $cnxn->query('SELECT * FROM chat WHERE (aim = "' . $_COOKIE['myemail'] . '" || start = "' . $_COOKIE['myemail'] . '") &&  (aim = "' . $_COOKIE['store_id'] . '" || start = "' . $_COOKIE['store_id'] . '")');
    while ($row = $results->fetch_assoc()) {
        if (in_array($_COOKIE['store_id'], $row) && in_array($_COOKIE['myemail'], $row))
            return 1;
    }
    $row = $results->num_rows;
    srand($row + $temp);
    $temp = $row + rand(1,25);
    srand($row + $temp);
    $temp += rand(1,25);
    srand($temp);
    $temp += rand(1,25);
    srand($row + $temp);
    $temp += rand(1,25);
    srand($temp);
    $temp += rand(1,25);
    
    if (!file_exists("xml/" . md5($temp) . ".xml")) {
        file_put_contents("xml/" . md5($temp) . ".xml", "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
        chmod('xml/' . md5($temp), 0644);
    }
    $sql = 'INSERT INTO chat(id,start,aim,filename,last,altered,checked) VALUES(null, "' . $_COOKIE["myemail"] . '", "' . $_COOKIE["store_id"] . '", "' . md5($temp) . '.xml", CURRENT_TIMESTAMP,null,0)';

    $results = $cnxn->query($sql) or die(mysqli_error($cnxn));
    return 0;
}

if ($_COOKIE['login'] != "true")
    header("Location: ./index.php");
$conn = mysqli_connect("localhost", "rooter", "", "adrs", "3306") or die("Error: Cannot create connection");

setcookie("store"," from stores!");

$results = "";

// get the current store
$sql = "SELECT franchise.id, franchise.store_name, ad_revs.store_creditor, franchise.store_no, franchise.owner_id, franchise.email, ad_revs.username, ad_revs.alias FROM franchise, ad_revs WHERE (franchise.owner_id = ad_revs.username || franchise.email = ad_revs.username) AND franchise.store_name = \"" . $_GET['a'] . "\" AND franchise.store_no = \"" . $_GET['b'] . "\"";

$results = $conn->query($sql);

if ($results->num_rows > 0) {
    $rows = $results->fetch_assoc();
    setcookie("franchise_id",$rows['id']);
    setcookie("store",$rows['store_name']);
    setcookie("store_no",$rows['store_no']);
    setcookie("owner_id",$rows['owner_id']);
    if (strlen($rows['email']) == 0)
        setcookie("store_id","");
    else 
        setcookie("store_id",$rows['email']);
    setcookie("contact",$rows['store_creditor']);
    setcookie("contact_alias",$rows['alias']);
    while (!makeMyFile($conn));
    getTax($conn);
    
}
else {
    setcookie("store","from many stores!");
}
    $results->close();
$conn->close();

?>
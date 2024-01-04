<?php

 include("db.php");
// Grab the local tax
function getTax($con) {
    $sql = 'SELECT EstimatedCombinedRate AS taxed FROM taxes WHERE ZipCode = :zip_code';
$stmt = $con->prepare($sql);
$stmt->bindParam(':zip_code', $_COOKIE['zip_code']);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
setcookie("taxes", $row['taxed']);
}

// Create new chat files
function makeMyFile($cnxn) {
    $temp = 0;
    
    $stmt = $cnxn->prepare('SELECT * FROM chat WHERE (aim = :myemail OR start = :myemail) AND (aim = :store_id OR start = :store_id)');
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->bindParam(':store_id', $_COOKIE['store_id']);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // Perform the necessary operations if the result set is not empty
    } else {
        $row = $stmt->rowCount();
        $temp = $row + rand(1, 25);
        
        if (!file_exists("xml/" . md5($temp) . ".xml")) {
            file_put_contents("xml/" . md5($temp) . ".xml", "<?xml version='1.0'?><?xml-stylesheet type='text/xsl' href='chatxml.xsl' ?><messages></messages>");
            chmod('xml/' . md5($temp), 0644);
        }
        
        $sql = 'INSERT INTO chat(id, start, aim, filename, last, altered, checked) VALUES(null, :myemail, :store_id, :filename, CURRENT_TIMESTAMP, null, 0)';
        $stmt = $cnxn->prepare($sql);
        $filename = md5($temp) . '.xml';
        $stmt->bindParam(':myemail', $_COOKIE["myemail"]);
        $stmt->bindParam(':store_id', $_COOKIE["store_id"]);
        $stmt->bindParam(':filename', $filename);
        $stmt->execute();
    }
}

if ($_COOKIE['login'] != "true")
    header("Location: ./index.php");
setcookie("store"," from stores!");

$results = "";
$sql = "SELECT franchise.id, franchise.store_name, ad_revs.store_creditor, franchise.store_no, franchise.owner_id, franchise.email, ad_revs.username, ad_revs.alias FROM franchise, ad_revs WHERE (franchise.owner_id = ad_revs.username OR franchise.email = ad_revs.username) AND franchise.store_name = :store_name AND franchise.store_no = :store_no";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':store_name', $_GET['a']);
$stmt->bindParam(':store_no', $_GET['b']);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    setcookie("franchise_id", $rows['id']);
    setcookie("store", $rows['store_name']);
    setcookie("store_no", $rows['store_no']);
    setcookie("owner_id", $rows['owner_id']);
    if (empty($rows['email'])) {
        setcookie("store_id", "");
    } else {
        setcookie("store_id", $rows['email']);
    }
    setcookie("contact", $rows['store_creditor']);
    setcookie("contact_alias", $rows['alias']);
    while (!makeMyFile($conn));
    getTax($conn);
} else {
    setcookie("store", "from many stores!");
}

?>
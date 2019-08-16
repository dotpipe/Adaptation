<?php
function makeChatFile($conn) {
    if (!isset($_COOKIE['chatfile']))
        return;
    $filename = $_COOKIE['chatfile'];
    $sql = 'INSERT INTO chat(id, start, aim, filename,last) VALUES(null,"' . $_COOKIE['myemail'] . '","' . $_COOKIE['store_id'] . '","' . $filename . '",null)';
    $results = $conn->query($sql);
}
$x = urldecode($_GET['addy']);
$y = str_getcsv($x,",");

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

$z = [];
if (mysqli_connect_errno()) {
    exit();
}
for ($i = 0 ; $i < count($y) ; $i++)
    $z[] = trim($y[$i]);

$results = "";

if (count($z) == 6)
    $results = $conn->query("SELECT ad_revs.store_uniq, franchise.store_name, franchise.store_no, ad_revs.store_creditor, franchise.addr_str, franchise.city, franchise.state, franchise.owner_id, franchise.alias, chat.filename FROM franchise, ad_revs, chat WHERE franchise.addr_str like \"" . $_GET['a'] . "\" AND franchise.city like \"" . $z[3] . "\" AND state like \"" . $z[4] . "\"") or die(mysqli_error());
else if (count($z) == 5)
    $results = $conn->query("SELECT ad_revs.store_uniq, franchise.store_name, franchise.store_no, ad_revs.store_creditor, franchise.addr_str, franchise.city, franchise.state, franchise.owner_id, franchise.alias, chat.filename FROM franchise, ad_revs, chat WHERE franchise.addr_str like \"" . $_GET['a'] . "\" AND franchise.city like \"" . $z[2] . "\" AND state like \"" . $z[3] . "\"") or die(mysqli_error());
else
    $results = $conn->query("SELECT ad_revs.store_uniq, franchise.store_name, franchise.store_no, ad_revs.store_creditor, franchise.addr_str, franchise.city, franchise.state, franchise.owner_id, franchise.alias, chat.filename FROM franchise, ad_revs, chat WHERE franchise.addr_str like \"" . $_GET['a'] . "\" AND franchise.city like \"" . $z[3] . "\" AND state like \"" . $z[5] . "\"") or die(mysqli_error());

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        setcookie("stores",$rows['store_name']);
        setcookie("store_no",$rows['store_no']);
        if ($rows['email'] == null)
            setcookie("store_id",$rows['owner_id']);
        else 
            setcookie("store_id",$rows['email']);
        setcookie("contact",$rows['store_creditor']);
        setcookie("contact_alias",$rows['alias']);
        if (!file_exists('./xml/' . md5($_COOKIE['myemail'] . ' oenq ' . $_COOKIE['store_id']) . ".xml")) {
            file_put_contents('./xml/' . md5($_COOKIE['myemail'] . ' oenq ' . $_COOKIE['store_id']) . ".xml",'<?xml version=\'1.0\'?><messages></messages>');
            makeChatFile($conn);
        }
        setcookie('chatfile','./xml/' . md5($_COOKIE['myemail'] . ' oenq ' . $_COOKIE['store_id']) . ".xml");
        
        if (!file_exists('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml"))
            file_put_contents('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml",'<?xml version=\'1.0\'?><messages></messages>');
        setcookie('inboxfile','./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml");
    }
    else
        setcookie("stores","");
    $results->close();
$conn->close();

?>
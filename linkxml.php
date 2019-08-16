<?php

function sanitize(&$r) {
    $r = filter_var(strip_tags($r), FILTER_SANITIZE_STRING);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

$xml = simplexml_load_file('./xml/' . md5($_COOKIE['myid']) . ".xml") or die(file_put_contents('./xml/' . md5($_COOKIE['myid']) . ".xml", "<?xml version=\'1.0\'?><accounts></accounts>"));

foreach ($xml->children() as $row) {
    foreach ($row as $k => $v)
        sanitize($v);
    $no = (strlen($row["store_no"]) > 0) ? $row["name"] : "";
    $busi = (strlen($row["store_name"]) > 0) ? $row["store_name"] : "";
    $username = (strlen($row["email"]) > 0) ? $row["email"] : "";
    $password = (strlen($row["password"]) > 0) ? $row["password"] : "";
    $t_addr = (strlen($row["addr_str"]) > 0) ? $row["addr_str"] : "";
    $ph = (strlen($row["phone"]) > 0) ? $row["phone"] : "";
    $email = (strlen($row["store_email"]) > 0) ? $row["store_email"] : "NULL";

    $affectedRow = 0;
    $options = array(
        'cost' => 12,
        'threads' => 2
        );
    $password = password_hash($password, PASSWORD_ARGON2ID, $options);
        
    $sql = 'INSERT INTO franchise(id,store_name,store_no,owner_id,addr_str,password,phone,email)
        VALUES (null,"' . $busi . '","' . $no . '","' . 
        $username . '","' . $t_addr . '","' . $password . '","' . $ph . '","' . $email . '")';
    
    $result = mysqli_query($conn, $sql);
    if (! empty($result)) {
        $affectedRow++;
    } else {
        $error_message = mysqli_error($conn) . "\n";
        echo $error_message;
    }
}
?>
Insert XML Data to MySql Table Output
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
    echo $message;
}
header("Location: ./");
?>
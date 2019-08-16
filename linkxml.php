<?php

function sanitize(&$r) {
    $r = filter_var(strip_tags($r), FILTER_SANITIZE_STRING);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

$xml = simplexml_load_file("branches.xml") or die(file_put_contents('branches.xml', "<?xml version=\'1.0\'?><accounts></accounts>"));

foreach ($xml->children() as $row) {
    foreach ($row as $k => $v)
        sanitize($v);
    $no = (strlen($row["store_no"]) > 0) ? $row["store_no"] : "";
    $busi = (strlen($row["business"]) > 0) ? $row["business"] : "";
    $username = (strlen($row["email"]) > 0) ? $row["email"] : "";
    $password = (strlen($row["password"]) > 0) ? $row["password"] : "";
    $t_addr = (strlen($row["address"]) > 0) ? $row["address"] : "";
    $ph = (strlen($row["phone"]) > 0) ? $row["phone"] : "";
    $email = (strlen($row["store_email"]) > 0) ? $row["store_email"] : "NULL";

    $affectedRow = 0;

    $city = ""; $st = "";
    if ($t_addr != null) {
        $index = 0;
        $holder = str_getcsv($t_addr);
        $index++;
        if (count($holder) >= 5)
            $index++;
        $city = trim(($holder[$index++]));
        $st = trim(($holder[$index++]));
    }
    
    $timeTarget = 0.045; // 45 milliseconds 

    $cost = 8;
    do {
        $cost++;
        $start = microtime(true);
        $password = password_hash($password, PASSWORD_BCRYPT, ["cost" => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);
    
    $sql = 'INSERT INTO franchise(id,store_name,store_no,owner_id,addr_str,password,phone,email,city,state)
        VALUES (null,"' . $busi . '","' . $no . '","' . 
        $username . '","' . $t_addr . '","' . $password . '","' . $ph . '","' . $email . '","' . $city . '","' . $state . '")';
    
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
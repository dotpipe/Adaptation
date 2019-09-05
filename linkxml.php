<?php


// Insert new businesses into database
// TODO: no xml for stores. just database filling.
// By zip codes.

function sanitize(&$r) {
    $r = filter_var(strip_tags($r), FILTER_SANITIZE_STRING);
}

$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

if (!file_exists('branches.xml'))
    file_put_contents('branches.xml', "<?xml version='1.0'?><accounts></accounts>");

$xml = simplexml_load_file('branches.xml');

$affectedRow = 0;
$i = 0;
foreach ($xml[$i]->children() as $row) {
        
    foreach ($row as $k => $v)
        sanitize($v);
    $timeTarget = 0.045; // 45 milliseconds 
    // make it a good password :)
    // TODO: make it necessary
    // to login to store for actions
    $cost = 8;
    do {
        $cost++;
        $start = microtime(true);
        $password1 = password_hash($row['password'], PASSWORD_BCRYPT, ['cost' => $cost]);
        $end = microtime(true);
    } while (($end - $start) < $timeTarget);
    
    
    $sql = 'INSERT INTO franchise(id,store_name,store_no,owner_id,manager,addr_str,city,state,password,phone,email,zip,avg_ads_hr,views,avg_views_day,reviews,avg_reviews,key1,key2,key3,key4,key5)
        VALUES (null,"' . $row['business'] . '","' . $row['store_no'] . '","' . $row['email'] . '","' . $row['manager'] . '","' . 
        $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['zip'] . '","' . $row['city'] . '","' . $row['state'] . '","' . $password1 . '","' . $row['phone'] . '","' . $row['store_email'] . '",
        ' . $row['zip'] . ',0,0,0,0,0,"' . $row['key1'] . '","' . $row['key2'] . '","' . $row['key3'] . '","' . $row['key4'] . '","' . $row['key5'] . '")';
    
    $result = mysqli_query($conn, $sql);
    if (! empty($result)) {
        $affectedRow++;
    } else {
        $error_message = mysqli_error($conn) . "\n";
        echo $error_message;
    }
    if ($i == sizeof($xml))
        break;
    $i++;
}
?>
Insert XML Data to MySql Table Output
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
    echo $message;
    file_put_contents("branches.xml", "<?xml version=\'1.0\'?><accounts></accounts>");
}
header("Location: ./");
?>
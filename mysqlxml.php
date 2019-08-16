<?php

function sanitize(&$r) {
    $r = filter_var(strip_tags($r), FILTER_SANITIZE_STRING);
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

$affectedRow = 0;

$xml = simplexml_load_file("stores.xml") or die(file_put_contents("stores.xml", "<?xml version=\'1.0\'?><markers></markers>"));

foreach ($xml->children() as $row) {
    foreach ($row as $k => $v)
        sanitize($v);
    $name = (strlen($row["name"]) > 0) ? $row["name"] : "";
    $busi = (strlen($row["business"]) > 0) ? $row["business"] : "";
    $no = (strlen($row["no"]) > 0) ? $row["no"] : "";
    $ph = (strlen($row["phone"]) > 0) ? $row["phone"] : "";
    $alias = (strlen($row["alias"]) > 0) ? $row["alias"] : "";
    $username = (strlen($row["email"]) > 0) ? $row["email"] : "";
    $password = (strlen($row["password"]) > 0) ? $row["password"] : "";
    $t_addr = (strlen($row["address"]) > 0) ? $row["address"] : "";

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
    //Encrypt Password
    $options = array(
        'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        'cost' => 12,
      );
    $password = password_hash($password, PASSWORD_BCRYPT, $options);
    
    $img_dir = md5($name . "4dis93" . $username) ;
    $sql = 'INSERT INTO ad_revs(store_uniq,store_creditor,ads_run,total_spent,img_dir,
        flags,joined_on,left_on,avg_hrs_day,avg_ads_hr,reviews,review_tally,username,password,alias,city,state)
            VALUES (null,"' . $name . '",0,0,"'
             . $img_dir . '",0,CURRENT_TIMESTAMP,null,0,0,0,0,"' . $username . '","' . $password . '","' . $alias
             . '","' . $city . '","' . $state . '")';
    
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
?>
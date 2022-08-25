<?php

$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

// create database entries for any type of user (owner, manager, shoppers)

$affectedRow = 0;
if (!file_exists('newusers.xml'))
    file_put_contents("newusers.xml", "<?xml version='1.0'?><users></users>");
    
$xml = simplexml_load_file("newusers.xml");

foreach ($xml->children() as $row) {
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
    $options = [
        'cost' => 10
    ]; 
    $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
    
    $img_dir = md5($name . "4dis93" . $username);
    $sql = 'INSERT INTO ad_revs(store_uniq,store_creditor,phone,ads_run,total_spent,img_dir,
        flags,joined_on,left_on,avg_hrs_day,avg_ads_hr,reviews,review_tally,username,password,alias)
            VALUES (null,"' . $name . '","' . $ph . '",0,0,"'
             . $img_dir . '",0,CURRENT_TIMESTAMP,null,0,0,0,0,"' . $username . '","' . $password_hash . '","' . $alias . '")';
    
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
    file_put_contents("newusers.xml", "<?xml version=\'1.0\'?><users></users>");
}
header("Location: ./index.php")
?>
<?php
function findChatFile($con) {
    $temp = "";

    foreach($con->query('SELECT id, start, aim, filename FROM chat WHERE 1') as $row) {
        if (($row['aim'] == $_COOKIE['store_id'] || $row['start'] == $_COOKIE['store_id'])
            && ($row['aim'] == $_COOKIE['myemail'] || $row['start'] == $_COOKIE['myemail'])) {
                setcookie('chatfile', md5($filename));
                if (!file_exists("./xml/" . $_COOKIE['chatfile']))
                    file_put_contents("./xml/" . $_COOKIE['chatfile'], '<?xml version=\'1.0\'?><messages></messages>');
                return 1;
            }
    }
    return makeChatFile($con);
}

function makeChatFile($cnxn) {
    foreach($conn->query('SELECT LAST_INSERT_ROW() FROM chat WHERE 1') as $row) {
        $temp = $row['LAST_INSERT_ROW()'] + 1;
    }
    
    $sql = 'INSERT INTO chat(id,start,aim,filename,last,altered) VALUES(null,"' . $_COOKIE['myemail'] . '","' . $_COOKIE['store_id'] . '","' . md5($temp) . ".xml" . '",CURRENT_TIMESTAMP,null)';
    $results = $conn->query($sql);
    return 0;
}

//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die(json_encode("Error: Cannot create connection"));

setcookie("store"," from stores!");
$z = [];
if (mysqli_connect_errno()) {
    exit();
}
for ($i = 0 ; $i < count($y) ; $i++)
    $z[] = trim($y[$i]);

$results = "";
$sql = "SELECT `franchise`.`store_name`, `franchise`.`email`, `franchise`.`store_no`, `franchise`.`owner_id`, `franchise`.`email`, `ad_revs`.`alias` FROM `franchise`, `ad_revs` WHERE (`franchise`.`owner_id` = `ad_revs`.`username` || `franchise`.`email` = `ad_revs`.`username`) AND `franchise`.`store_name` = \"" . $_GET['a'] . "\" AND `franchise`.`store_no` = \"" . $_GET['b'] . "\"";

$results = $conn->query($sql) or die(setcookie("store", mysql_error()));

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        setcookie("store",$rows['store_name']);
        setcookie("store_no",$rows['store_no']);
        if (!isset($rows['email']) || $rows['email'] == null)
            setcookie("store_id",$rows['owner_id']);
        else 
            setcookie("store_id",$rows['email']);
        setcookie("contact",$rows['store_creditor']);
        setcookie("contact_alias",$rows['alias']);
        while (!findChatFile($conn));
        if (!file_exists('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml"))
            file_put_contents('./inbox/' . md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml",'<?xml version=\'1.0\'?><messages></messages>');
        setcookie('inboxfile',md5($_COOKIE['store_id'] . $_COOKIE['store_no']) . ".xml");
    }
    else {
        setcookie("store","from many stores!");
    }
    $results->close();
$conn->close();

?>
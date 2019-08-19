<?php
function findMyFile($con) {
    $temp = "";
    $files = [];
    setcookie("chatfiles","");
    $results = $con->query('SELECT id, start, aim, filename FROM chat WHERE 1');
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            if ($row['aim'] == $_COOKIE['myemail'] || $row['start'] == $_COOKIE['myemail']) {
                $files[] = $row['filename'];
                if (!file_exists("./xml/" . $row['filename']))
                    file_put_contents("./xml/" . $row['filename'], '<?xml version=\'1.0\'?><messages></messages>');
                $con->query('UPDATE chat SET `checked` = 0 WHERE `filename` = "' . $row['filename'] . '"');
            }
        }
    }
    if (sizeof($files) > 1) {
        return 1;
    }
    if (sizeof($files) == 1) {
        setcookie("chatfiles", json_encode(array($files)));
        setcookie("chatfile", ($file));
    }
    return makeMyFile($con);
}

function makeMyFile($cnxn) {
    $temp = 0;
    
    $results = $cnxn->query('SELECT * FROM chat WHERE 1');
    
    $row = $results->num_rows;
    srand($row);
    $temp = $row + rand(1,25);
    srand($rows + $temp);
    $temp += rand(1,25);
    srand($temp);
    $temp += rand(1,25);
    
    if (!file_exists("./xml/" . md5($temp) . ".xml"))
        file_put_contents("./xml/" . md5($temp) . ".xml", '<?xml version=\'1.0\'?><messages></messages>');
    $sql = 'INSERT INTO chat(id,start,aim,filename,last,altered,checked) VALUES (null, "' . $_COOKIE["myemail"] . '", "' . $_COOKIE["store_id"] . '", "' . md5($temp) . '.xml", CURRENT_TIMESTAMP,null,0)';

    $results = $cnxn->query($sql);
    $r[] = md5($temp);
    setcookie("chatfiles", json_encode($r));
    return 1;
}

if ($_COOKIE['login'] != "true")
    header("Location: ./index.php");
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

$sql = "SELECT `franchise`.`store_name`, `ad_revs`.`store_creditor`, `franchise`.`store_no`, `franchise`.`owner_id`, `franchise`.`email`, `ad_revs`.`username`, `ad_revs`.`alias` FROM `franchise`, `ad_revs` WHERE (`franchise`.`owner_id` = `ad_revs`.`username` || `franchise`.`email` = `ad_revs`.`username`) AND `franchise`.`store_name` = \"" . $_GET['a'] . "\" AND `franchise`.`store_no` = \"" . $_GET['b'] . "\"";

$results = $conn->query($sql) or die(file_put_contents("test.txt", "idiaj"));

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        setcookie("store",$rows['store_name']);
        setcookie("store_no",$rows['store_no']);
        setcookie("owner_id",$rows['owner_id']);
        if (strlen($rows['email']) == 0)
            setcookie("store_id","");
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
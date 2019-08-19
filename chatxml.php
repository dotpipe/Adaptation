
<?php

//$con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");

$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");

$files = [];
$alias = [];
$r = "";
setcookie("chatfiles","");
setcookie("aliases","");
$results = $con->query('SELECT `alias`, `aim`, `start`, `filename`, `email`, `owner_id`, `store_name`, `store_no` FROM `chat`, `franchise`, `ad_revs` WHERE (`franchise`.`owner_id` = `ad_revs`.`username` || `franchise`.`email` = `ad_revs`.`username`) AND `chat`.`checked` = 0 AND (`chat`.`aim` = "' . $_COOKIE['myemail'] . '" || `chat`.`start` = "' . $_COOKIE['myemail'] . '")');

$num = $results->num_rows;
if ($num > 0) {
    while ($row = $results->fetch_assoc()) {
        $files[] = $row['filename'];
        $alias[] = ($row['aim'] == $_COOKIE['myemail']) ? $row['start'] : $row['aim'];
        $names[] = $row['alias'];
    }
}
$r = [];
$files = array_unique($files);
foreach ($files as $k => $v)
    $r[] = $v;
$r = json_encode($r);
setcookie('chatfiles', $r);
$r = [];
$alias = array_unique($alias);
foreach ($alias as $k => $v)
    $r[] = $v;
$r = json_encode($r);
setcookie('aliases', $r);
$r = [];
$names = array_unique($names);
foreach ($names as $k => $v)
    $r[] = $v;
$r = json_encode($r);
setcookie('names', $r);

?>
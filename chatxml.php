
<?php
$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");
foreach($con->query('SELECT * FROM chat WHERE `checked` = 0') as $row) {
    if ($row['aim'] == $_COOKIE['myemail'] || $row['start'] == $_COOKIE['myemail']) {
	    if ($row['aim'] == $_COOKIE['myemail'])
	        $_SESSION['chats'][] = $row['start'];
	    else
	        $_SESSION['chats'][] = $row['aim'];
	    $new = $_SESSION['chats'][sizeof($_SESSION['chats'])-1];
	    foreach($con->query("SELECT * FROM `franchise` WHERE `franchise`.`owner_id` = '$new' OR `franchise`.`email` = '$new'") as $rows){
	        $_SESSION['alias'][] = $row['alias'];
	    }
	}
	$chats = (isset($_SESSION['chats'])) ? $_SESSION['chats'] : [];
	$alias = (isset($_SESSION['alias'])) ? $_SESSION['alias'] : [];
}
?>
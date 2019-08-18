
<?php

//$con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");

$con = mysqli_connect('localhost', 'root', '', 'adrs','3306') or die("Error: Can't connect");

if ($_GET['a'] == "2") {
    $x = []; $y = [];
    
    foreach($con->query('SELECT * FROM chat WHERE `checked` = 0') as $row) {
        if ($row['aim'] == $_COOKIE['myemail'] || $row['start'] == $_COOKIE['myemail']) {
    	    if ($row['aim'] == $_COOKIE['myemail'])
    	        $new = $row['start'];
    	    else
    	        $new = $row['aim'];
    	    $x[] = $new;
    	    $x = array_unique($x);
    	    foreach($con->query('SELECT * FROM `ad_revs` WHERE `ad_revs`.`username` = "' . $new . '"') as $rows){
    	        $y[] = $rows['alias'];
    	        $y = array_unique($y);
    	    }
    	}
    }
    
        foreach ($x as $v) {
            $fg[] = $v;
            $fg = array_unique($fg);
        }
        foreach ($y as $v) {
            $fgh[] = $v;
            $fgh = array_unique($fgh);
        }
    
    	setcookie("chats",json_encode($fg[0]));
    	setcookie("aliases",json_encode($fgh[0]));
}
else {
    $sql = "UPDATE chat SET `altered` = `last`, `last` = CURRENT_TIMESTAMP WHERE `filename` = '" . $_COOKIE['chatfile'] . "'";
    $results = $con->query($sql) or die(file_put_contents("x.txt", mysqli_error()));
}
?>
<?php
$x = urldecode($_POST['password']);
$y = urldecode($_POST['email']);
//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

setcookie("login","false",time()+60*60*$_COOKIE['vartime']);
$z = [];
if (mysqli_connect_errno()) {
    echo "";
    exit();
}
if ($_POST['remember'] == "checked")
    setcookie("vartime",24*60);
else
    setcookie("vartime",1);
$results = "";

$results = $conn->query('SELECT store_uniq, store_creditor, username, password, alias FROM ad_revs WHERE username = "' . $y . '"') or die(mysqli_error());

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        if (!password_verify($x, $rows['password'])) {
            setcookie("login","false",time()+60*60*$_COOKIE['vartime']);
            echo "FALSE1";
            header("Location: ./");
        }
        setcookie("myemail", $rows['username'],time()+60*60*$_COOKIE['vartime']);
        setcookie("myid",$rows['store_uniq'],time()+60*60*$_COOKIE['vartime']);
        setcookie("myname",$rows['store_creditor'],time()+60*60*$_COOKIE['vartime']);
        setcookie("myalias",$rows['alias'],time()+60*60*$_COOKIE['vartime']);
        setcookie("login","true",time()+60*60*$_COOKIE['vartime']);
        echo "TRUE";
        header("Location: ./");
        if (!isset($_COOKIE['count']) || isset($_COOKIE['count']))
            setcookie("count", 0);
        setcookie("lock", time()+1000);
    }
    else {
        if (!isset($_COOKIE['count']))
            setcookie("count", 1);
        if (isset($_COOKIE['count']))
            $_COOKIE['count']++;
        if ($_COOKIE['count'] >= 3)
            setcookie("lock", time()+60*60*24);
        setcookie("login","false",time()+60*60*$_COOKIE['vartime']);
        header("Location: ./");
    }
    
?>
<?php
$x = urldecode($_POST['password']);
$y = urldecode($_POST['email']);
//$conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

$conn = mysqli_connect("localhost", "root", "", "adrs", "3306") or die("Error: Cannot create connection");

setcookie("login","false",time()+60*60);
$z = [];
if (mysqli_connect_errno()) {
    echo "";
    exit();
}

$results = "";

$results = $conn->query('SELECT store_uniq, store_creditor, username, password, alias FROM ad_revs WHERE username = "' . $y . '"') or die(mysqli_error());

    if ($results->num_rows > 0) {
        $rows = $results->fetch_assoc();
        if (!password_verify($x, $rows['password'])) {
            setcookie("login","false",time()+60*60);
            echo "FALSE1";
            header("Location: ./");
        }
        setcookie("myemail", $rows['username'],time()+60*60);
        setcookie("myid",$rows['store_uniq'],time()+60*60);
        setcookie("myname",$rows['store_creditor'],time()+60*60);
        setcookie("myalias",$rows['alias'],time()+60*60);
        setcookie("login","true",time()+60*60);
        echo "TRUE";
        header("Location: ./");

    }
    else {
        echo "FALSE";
        setcookie("login","false",time()+60*60);
        return "FALSE";
        header("Location: ./");
    }
    
?>
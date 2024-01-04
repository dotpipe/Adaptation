<?php
$x = urldecode($_POST['password']);
$y = urldecode($_POST['email']);

include("db.php");

if (!isset($_SESSION))
    session_start();

setcookie("login","false",time()+60*60*($_COOKIE['vartime']+1));
$z = [];
if (mysqli_connect_errno()) {
    echo "";
    exit();
}
$results = "";
$sql = 'SELECT store_uniq, store_creditor, username, password, alias FROM ad_revs WHERE username = :username';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $y);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

if ($results->rowCount() > 0) {
    $rows = $results->fetch(PDO::FETCH_ASSOC);
    if (!password_verify($x, $rows['password'])) {
        unset($_COOKIE);
        //setcookie("login","false",time()+60*60*($_COOKIE['vartime']+1));
        echo "FALSE1";
        header("Location: ./");
        exit();
    }

    if ($_POST['remember'] == "checked") {
        setcookie("vartime", 24*60);
    } else {
        setcookie("vartime", 1);
    }

    setcookie("myemail", $rows['username'], time()+60*60*($_COOKIE['vartime']+1));
    setcookie("myid", $rows['store_uniq'], time()+60*60*($_COOKIE['vartime']+1));
    setcookie("myname", $rows['store_creditor'], time()+60*60*($_COOKIE['vartime']+1));
    setcookie("myalias", $rows['alias'], time()+60*60*($_COOKIE['vartime']+1));
    setcookie("login", "true", time()+60*60*($_COOKIE['vartime']+1));
    echo "TRUE";
    if (!isset($_COOKIE['count']) || isset($_COOKIE['count'])) {
        setcookie("count", 0);
    }
    setcookie("lock", time()+1000);

    $sql = 'SELECT COUNT(*) FROM franchise WHERE (franchise.email = :myemail || franchise.owner_id  = :myemail)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $stores = $stmt->fetch(PDO::FETCH_COLUMN);

    header("Location: ./");
} else {
    if (!isset($_COOKIE['count'])) {
        setcookie("count", 0);
    }
    if (isset($_COOKIE['count'])) {
        $_COOKIE['count']++;
    }
    if ($_COOKIE['count'] >= 3) {
        setcookie("lock", time()+60*60*24);
    }
    setcookie("login", "false", time()+60*60*($_COOKIE['vartime']+1));
    header("Location: ./");
}
?>
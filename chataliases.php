<?php

include("db.php");
function getaliases($con)
{ // Prepare and execute the SELECT query using PDO
    $myemail = $_COOKIE['myemail'];

    $stmt = $con->prepare('SELECT username FROM ad_revs, chat WHERE (aim = :myemail1 || start = :myemail2) && (username = start || aim = username) && username != :myemail3 ORDER BY last DESC');
    $stmt->bindParam(':myemail1', $myemail);
    $stmt->bindParam(':myemail2', $myemail);
    $stmt->bindParam(':myemail3', $myemail);
    $stmt->execute();

    $d = [];
    // Fetch the results using PDO
    $c = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $c[] = $row['username'];
    }

    $f = [];
    foreach ($c as $v)
        $f[] = $v;

    echo json_encode($c);

    setcookie("aliases", json_encode($f));
}

function getfilename($con)
{
    // Prepare and execute the SELECT query using PDO
    $chataddr = $_COOKIE['chataddr'];
    $myemail = $_COOKIE['myemail'];

    $stmt = $con->prepare('SELECT filename FROM chat WHERE (aim = :myemail1 && start = :chataddr1) || (aim = :chataddr2 && start = :myemail2)');
    $stmt->bindParam(':myemail1', $myemail);
    $stmt->bindParam(':chataddr1', $chataddr);
    $stmt->bindParam(':chataddr2', $chataddr);
    $stmt->bindParam(':myemail2', $myemail);
    $stmt->execute();

    // Check the number of rows and set the cookie
    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $d = $row['filename'];
        setcookie("chatfile", $d);
    }
}


if ($_GET['c'] == 1)
    getaliases($conn);
else if ($_GET['c'] == 2)
    getfilename($conn);
?>
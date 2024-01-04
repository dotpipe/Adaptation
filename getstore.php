<?php

include("db.php");
// Grab the local tax
function getTax($con)
{
    // Prepare and execute the SELECT query using PDO
    $zip_code = $_COOKIE['zip_code'];

    $stmt = $con->prepare('SELECT EstimatedCombinedRate AS taxed FROM taxes WHERE ZipCode = :zip_code');
    $stmt->bindParam(':zip_code', $zip_code);
    $stmt->execute();

    // Fetch the result and set the cookie
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    setcookie("taxes", $row['taxed']);
}

// Create new chat files
function makeMyFile($cnxn)
{
    $temp = 0;
    // Prepare and execute the SELECT query using PDO
    $stmt = $cnxn->prepare('SELECT * FROM chat WHERE (aim = :myemail1 || start = :myemail2) && (aim = :store_id1 || start = :store_id2)');
    $stmt->bindParam(':myemail1', $_COOKIE['myemail']);
    $stmt->bindParam(':myemail2', $_COOKIE['myemail']);
    $stmt->bindParam(':store_id1', $_COOKIE['store_id']);
    $stmt->bindParam(':store_id2', $_COOKIE['store_id']);
    $stmt->execute();

    // Fetch the results and perform the required operations
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (in_array($_COOKIE['store_id'], $row) && in_array($_COOKIE['myemail'], $row)) {
                return 1;
            }
        }
    }

    $row = $stmt->rowCount();
    $temp = 0;
    srand($row + $temp);
    $temp = $row + rand(1, 25);
    srand($row + $temp);
    $temp += rand(1, 25);
    srand($temp);
    $temp += rand(1, 25);
    srand($row + $temp);
    $temp += rand(1, 25);
    srand($temp);
    $temp += rand(1, 25);

    if (!file_exists("csv/" . md5($temp) . ".csv")) {
        $file = fopen("csv/" . md5($temp) . ".csv", 'a');
        fputcsv($file, array('Time', $_COOKIE["myemail"], 'Message')); // Write header row
        fclose($file);
    }

    $sql = 'INSERT INTO chat(id,start,aim,filename,last,altered,checked) VALUES(null, :myemail, :store_id, :filename, CURRENT_TIMESTAMP, null, 0)';
    $stmt = $cnxn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE["myemail"]);
    $stmt->bindParam(':store_id', $_COOKIE["store_id"]);
    $stmt->bindParam(':filename', md5($temp) . '.xml');
    $stmt->execute();

    return 0;
}

if ($_COOKIE['login'] != "true")
    header("Location: ./index.php");

setcookie("store", " from stores!");

$results = "";
// Prepare and execute the SELECT query using PDO
$sql = "SELECT franchise.id, franchise.store_name, ad_revs.store_creditor, franchise.store_no, franchise.owner_id, franchise.email, ad_revs.username, ad_revs.alias FROM franchise, ad_revs WHERE (franchise.owner_id = ad_revs.username || franchise.email = ad_revs.username) AND franchise.store_name = :store_name AND franchise.store_no = :store_no";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':store_name', $_GET['a']);
$stmt->bindParam(':store_no', $_GET['b']);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    setcookie("franchise_id", $rows['id']);
    setcookie("store", $rows['store_name']);
    setcookie("store_no", $rows['store_no']);
    setcookie("owner_id", $rows['owner_id']);
    if (strlen($rows['email']) == 0) {
        setcookie("store_id", "");
    } else {
        setcookie("store_id", $rows['email']);
    }
    setcookie("contact", $rows['store_creditor']);
    setcookie("contact_alias", $rows['alias']);
    while (!makeMyFile($conn)) {
        // Perform required operations
    }
    getTax($conn);
} else {
    setcookie("store", "from many stores!");
}
$results->close();
$conn->close();

?>
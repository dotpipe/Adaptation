<?php

include ("db.php");
// extract database entries for stores (owner, manager, shoppers)
// Prepare and execute the SELECT query using PDO
$sql = 'SELECT manager, owner_id AS email, addr_str AS address, phone, store_name AS business, store_no, city, state, email AS store_email FROM franchise WHERE zip = :zip';
$stmt = $conn->prepare($sql);
$stmt->bindParam(':zip', $_GET['a']);
$stmt->execute();

// Create a new XML document
$dom = new \DomDocument();
$dom->appendChild($dom->createElement('accounts'));

// Iterate through the results and add them to the XML document
while ($zip = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tmp = $dom->createElement("links");
    foreach ($zip as $k => $v) {
        $tmp->setAttribute($k, $v);
    }
    $dom->documentElement->appendChild($tmp);
}

// Save the XML document to a file
$dom->save($_GET['a'] . ".xml");

header("Location: ./index.php");
?>
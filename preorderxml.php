<?php

function getTax($conn)
{

    // Prepare and execute the SELECT query using PDO
    $sql = 'SELECT EstimatedCombinedRate FROM taxes WHERE ZipCode = :zip_code';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':zip_code', $_COOKIE['zip_code']);
    $stmt->execute();

    // Fetch the result and set the cookie
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    setcookie("taxes", $row['EstimatedCombinedRate']);

}

function countOrders($conn)
{

    // Set the "orders" cookie to 0
    setcookie("orders", 0);

    // Prepare and execute the SELECT query using PDO
    $sql = 'SELECT MAX(order_id) AS max FROM preorders WHERE store_name = :store_name AND store_no = :store_no';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store']);
    $stmt->bindParam(':store_no', $_COOKIE['store_no']);
    $stmt->execute();

    // Fetch the result and set the "orders" cookie
    $f = $stmt->fetch(PDO::FETCH_ASSOC);
    $next_order = $f['max'];
    setcookie("orders", $next_order + 1);

}

// preorder entry into database

countOrders($con);
getTax($con);
$a = str_getcsv($_GET['a']);
$b = str_getcsv($_GET['b']);
$c = $_GET['c'];

$sql = 'INSERT INTO preorders(id, customer, store_name, store_no, product, quantity, indv_price, tax, total_price, needed_by, delivered, expected, action, created, order_id, edited) VALUES';
$values = array();
foreach ($a as $i => $v) {
    if ($v !== "" && $v !== null) {
        $values[] = '(null, :myemail, :store, :store_no, :product' . $i . ', :quantity' . $i . ', 0, :taxes, 0, :needed_by, null, null, 0, CURRENT_TIMESTAMP, :orders, null)';
    }
}

$sql .= implode(',', $values);
$stmt = $conn->prepare($sql);
$stmt->bindParam(':myemail', $_COOKIE['myemail']);
$stmt->bindParam(':store', $_COOKIE['store']);
$stmt->bindParam(':store_no', $_COOKIE['store_no']);
$stmt->bindParam(':taxes', $_COOKIE['taxes']);
$stmt->bindParam(':needed_by', $c);
$stmt->bindParam(':orders', $_COOKIE['orders']);

foreach ($a as $i => $v) {
    if ($v !== "" && $v !== null) {
        $stmt->bindParam(':product' . $i, $v);
        $stmt->bindParam(':quantity' . $i, $b[$i]);
    }
}

$stmt->execute();
?>
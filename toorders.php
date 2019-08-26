<?php

function updateRow() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = "";

    if ($_GET['b'] == "action") {
        $f = "";
        if ($_GET['a'] === "3")
            $f = ', delivered = CURRENT_TIMESTAMP ';
        $g = (int)$_GET['a'];
        $sql = 'UPDATE `preorders` SET `action` = ' . $g . $f . 'WHERE `id` = ' . $_COOKIE['id'] . ' && `customer` = "' . $_COOKIE['e'] . '"';
    }
    else if (is_int($_GET['a']))
        $sql = 'UPDATE `preorders` SET ' . $_GET['b'] . ' = ' . $_GET['a'] . ' WHERE `id` = ' . $_COOKIE['id'] . ' && `customer` = "' . $_COOKIE['e'] . '"';
    else
        $sql = 'UPDATE `preorders` SET ' . $_GET['b'] . ' = "' . $_GET['a'] . '" WHERE `id` = ' . $_COOKIE['id'] . ' && `customer` = "' . $_COOKIE['e'] . '"';

    echo $sql;

    $conn->query($sql) or die("AGGHHH");
    

}

function countOrders() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id FROM preorders WHERE store_name = "' . $_COOKIE['store'] . '" && store_no = "' . $_COOKIE['store_no'] . '" && (customer = "' . $_COOKIE['e'] . '")';

    $results = $conn->query($sql) or die("AGGHHH");

    $next_order = $results->num_rows;

    setcookie("orders", $next_order + 1);

}

function listDelivered() {
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT DISTINCT(order_id) AS ord, customer, action FROM preorders WHERE action = 3';
    
    $result = $conn->query($sql) or die("GAAAHHHH");
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Customer</td><td>Action</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        
        $info .= '<tr id="rn' . $row['ord'] . '" onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'d\')">';
        foreach ($row as $k => $v) {
            $info .= '<td>';
            $info .= $v;
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
}

function listCanceled() {
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT DISTINCT(order_id) AS ord, customer, action FROM preorders WHERE action = 2';
    
    $result = $conn->query($sql) or die("GAAAHHHH");
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Customer</td><td>Action</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        
        $info .= '<tr id="rn' . $row['ord'] . '" onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'c\')">';
        foreach ($row as $k => $v) {
            $info .= '<td>';
            $info .= $v;
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
}

function listHold() {
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT DISTINCT(order_id) AS ord, customer, action FROM preorders WHERE action = 0';
    
    $result = $conn->query($sql) or die("GAAAHHHH");
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Customer</td><td>Action</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        
        $info .= '<tr id="rn' . $row['ord'] . '" onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'h\')">';
        foreach ($row as $k => $v) {
            $info .= '<td>';
            $info .= $v;
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
}

function listOrdered() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT DISTINCT(order_id) AS ord, customer, action FROM preorders WHERE action = 1';

    $result = $conn->query($sql) or die("GAAAHHHH");

    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Customer</td><td>Action</td></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $info .= '<tr id="rn' . $row['ord'] . '" onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'d\')">';
        foreach ($row as $k => $v) {
            $info .= '<td>';
            $info .= $v;
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
}


function getOrder() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id, id, customer, product, quantity, indv_price, total_price, delivered, needed_by, created, action FROM preorders WHERE customer = "' . $_COOKIE['e'] . '" || store_name = "' . $_COOKIE['store'] . '"';
    
    $result = $conn->query($sql) or die("GAAAHHHH");
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Customer</td><td>Product</td><td>Qu</td><td>Price</td><td>Total</td><td>Days Left</td><td>Created</td><td>Action</td></tr>";
    
    $row = [];
    
    while ($row = $result->fetch_assoc()) {
        $info .= '<tr name="' . $row['id'] . '" onfocus="setCookie(\'e\',\'' . $row['customer'] . '\')">';
        $indv_price = 0;
        $quantity = 0;
        $total = 0;
        foreach ($row as $k => $v) {
            $edit = "";
            if ($v === null || $k == "id" || ($k === "delivered" && $v === null))
                continue;
            switch($k) {
                case "action":
                break;
                case "customer":
                break;
                case "indv_price":
                break;
                case "order_id":
                break;
                case "id":
                break;
                case "total_price":
                break;
                default:
                    $edit = ' onclick="this.contentEditable=\'true\';setCookie(\'e\',\'' . $row['customer'] . '\')" onblur="this.contentEditable=\'false\';editFields(this,\'' . $row['id'] . '\')"';
                break;
            }
            $info .= '<td name="' . $k . '" style="color:lightgray;border:2px solid darkblue"' . $edit .'>';
            $act0 = ""; $act1 = ""; $act2 = ""; $act3 = ""; 
            if ($k === "action" && $v == 0) {
                $act0 = "selected ";
            }
            else if ($k === "action" && $v == 1) {
                $act1 = "selected ";
            }
            else if ($k === "action" && $v == 2) {
                $act2 = "selected ";
            }
            else if ($k === "action" && $v == 3) {
                $act3 = "selected ";
            }
            if ($k === "action") {
                $info .= '<select onclick="setCookie(\'id\',' . $row['id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\')" onchange="editDrop(this)" id=\'sn' . $row['id'] . '\'>';
                $info .= '<option ' . $act0 . 'value=\'0\'>On Hold</option>';
                $info .= '<option ' . $act1 . 'value=\'1\'>Ordered</option>';
                $info .= '<option ' . $act2 . 'value=\'2\'>Canceled</option>';
                $info .= '<option ' . $act3 . 'value=\'3\'>Delivered</option>';
                $info .= '</select>';
            }
            else
                $info .= $v;
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
    echo $info;
}

countOrders();

if (isset($_GET['c']) && $_GET['c'] == 'd')
    listDelivered();
else if (isset($_GET['c']) && $_GET['c'] == 'o')
    listOrdered();
else if (isset($_GET['c']) && $_GET['c'] == 'h')
    listHold();
else if (isset($_GET['c']) && $_GET['c'] == 'c')
    listCanceled();
else if (isset($_GET['c']) && $_GET['c'] == 'u')
    updateRow();
else if (isset($_GET['c']) && $_GET['c'] == 'a')
    getOrder();


?>

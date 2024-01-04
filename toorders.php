<?php

include("db.php");

function getTax($conn)
{

    $sql = 'SELECT EstimatedCombinedRate AS taxed FROM taxes WHERE ZipCode = :zip_code';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':zip_code', $_COOKIE['zip_code']);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    setcookie("taxes", $row['taxed']);

}

// my outgoing wishlist
function shortListOut($conn)
{

    getTax($conn);

    $sql = 'SELECT preorders.order_id, preorders.id, preorders.store_name, preorders.needed_by, preorders.action, preorders.customer, preorders.store_no, customer FROM preorders WHERE customer = :myemail';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Est.</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();

}

// my incoming wishlist
function shortListIn($conn)
{

    getTax($conn);
    $sql = 'SELECT preorders.order_id, preorders.id, preorders.customer, preorders.store_no, preorders.needed_by, preorders.action, preorders.store_name FROM franchise, ad_revs, preorders WHERE (preorders.store_name = franchise.store_name OR preorders.store_no = preorders.store_no) AND (ad_revs.username = franchise.owner_id OR ad_revs.username = franchise.email) AND ad_revs.username = :myemail';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();
}

// orders on hold
function listHold($conn)
{

    getTax($conn);
    $sql = 'SELECT preorders.order_id, preorders.id, preorders.customer, preorders.store_no, preorders.needed_by, preorders.action, preorders.store_name FROM franchise, ad_revs, preorders WHERE (franchise.store_name = :store_name AND franchise.store_no = :store_num) AND (franchise.store_name = preorders.store_name AND franchise.store_no = preorders.store_no) AND (franchise.owner_id = ad_revs.username OR franchise.email = ad_revs.username) AND action = 0';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();
}

// ordered preorders
function listOrdered($conn)
{

    getTax($conn);

    $sql = 'SELECT preorders.order_id, preorders.id, preorders.customer, preorders.store_no, preorders.needed_by, preorders.action, preorders.store_name FROM franchise, ad_revs, preorders WHERE (franchise.store_name = :store_name AND franchise.store_no = :store_num) AND (franchise.store_name = preorders.store_name AND franchise.store_no = preorders.store_no) AND (franchise.owner_id = ad_revs.username OR franchise.email = ad_revs.username) AND action = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();
}

// canceled orders
function listCanceled($conn)
{

    getTax($conn);
    $sql = 'SELECT preorders.order_id, preorders.id, preorders.customer, preorders.store_no, preorders.needed_by, preorders.action, preorders.store_name FROM franchise, ad_revs, preorders WHERE (franchise.store_name = :store_name AND franchise.store_no = :store_num) AND (franchise.store_name = preorders.store_name AND franchise.store_no = preorders.store_no) AND (franchise.owner_id = ad_revs.username OR franchise.email = ad_revs.username) AND action = 2';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();
}

// delivered orders
function listDelivered($conn)
{

    getTax($conn);
    $sql = 'SELECT preorders.order_id, preorders.id, preorders.customer, preorders.store_no, preorders.needed_by, preorders.action, preorders.store_name FROM franchise, ad_revs, preorders WHERE (franchise.store_name = :store_name AND franchise.store_no = :store_num) AND (franchise.store_name = preorders.store_name AND franchise.store_no = preorders.store_no) AND (franchise.owner_id = ad_revs.username OR franchise.email = ad_revs.username) AND action = 3';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $tables = '<table style="color:lightgray;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
    
    shortList($result, $tables);
    $conn->close();
}

// order list lite
function shortList($results, $table)
{
    $oid = [];
    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            if (in_array(array($row['store_name'] => $row['order_id']), $oid))
                continue;
            $table .= '<tr>';
            $oid[] = array($row['store_name'] => $row['order_id']);
            $bool = 0;
            if ($_GET['c'] = 'li' && $row['customer'] = $_COOKIE['myemail'])
                continue;
            foreach ($row as $k => $v) {
                if ($k == "id")
                    continue;
                if ($bool == 1)
                    continue;
                if ($k == "action") {
                    $s0 = "";
                    $s1 = "";
                    $s2 = "";
                    $s3 = "";
                    switch ($v) {
                        case 0:
                            $s0 = " selected";
                            break;
                        case 1:
                            $s1 = " selected";
                            break;
                        case 2:
                            $s2 = " selected";
                            break;
                        case 3:
                            $s3 = " selected";
                            break;
                    }
                    $table .= '<td style="border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px">';
                    $table .= '<select onclick="setCookie(\'orderid\',' . $row['order_id'] . ');setCookie(\'store_name\',\'' . $row['store_name'] . '\');setCookie(\'store_num\',' . $row['store_no'] . ')" onchange="editStack(this)" id=\'sn' . $row['id'] . '\'>';
                    $table .= '<option' . $s0 . ' value=\'0\'>On Hold</option>';
                    $table .= '<option' . $s1 . ' value=\'1\'>Ordered</option>';
                    $table .= '<option' . $s2 . ' value=\'2\'>Canceled</option>';
                    $table .= '<option' . $s3 . ' value=\'3\'>Delivered</option>';
                    $table .= '</select>';
                    $table .= '</td>';
                    $bool = 1;
                } else
                    $table .= '<td style="border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px" onclick="setCookie(\'orderid\',' . $row['order_id'] . ');setCookie(\'store_name\',\'' . $row['store_name'] . '\');setCookie(\'store_num\',' . $row['store_no'] . ');getInbox(\'a\',' . $row['order_id'] . ')">' . $v . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
        echo $table;
    }
}

// entire order
function deleteOrder($conn)
{

    $sql = 'DELETE FROM preorders WHERE store_name = :store_name AND store_no = :store_num AND order_id = :orderid';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->bindParam(':orderid', $_COOKIE['orderid']);
    $stmt->execute();
    $conn->close();
}

function deleteItem($conn)
{

    $sql = 'DELETE FROM preorders WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_COOKIE['id']);
    $stmt->execute();
    $conn->close();
}


// my outgoing wishlist
function myOrders($conn)
{

    getTax($conn);

    $sql = 'SELECT order_id, id, store_name, product, quantity, indv_price, tax, total_price, delivered, needed_by, created, action FROM preorders WHERE customer = :customer AND order_id = :orderid';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':customer', $_COOKIE['myemail']);
    $stmt->bindParam(':orderid', $_COOKIE['orderid']);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border-right:1px solid red' id='order'><tr><td style='width:70px;'># &nbsp;</td><td style='width:70px;'>Est.</td><td style='width:70px;'>Product</td><td style='width:70px;'>Qu *</td><td style='width:70px;'>Price</td><td style='width:70px;'>Tax</td><td style='width:70px;'>Total</td><td style='width:70px;'>TOA</td><td style='width:70px;'>Need By *</td><td style='width:70px;'>Created</td><td>Action</td><td>Delete</td></tr>";
    
    getTable($result, $info);
    $conn->close();
}

function outOrders($conn)
{

    getTax($conn);

    $sql = 'SELECT order_id, id, customer, product, quantity, indv_price, tax, total_price, delivered, needed_by, created, action FROM preorders WHERE order_id != :orderid AND store_name = :store_name AND store_no = :store_num';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':orderid', $_COOKIE['orderid']);
    $stmt->bindParam(':store_name', $_COOKIE['store']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetchAll();
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border-right:1px solid red' id='order'><tr><td style='width:70px;'># &nbsp;</td><td style='width:70px;'>Customer</td><td style='width:70px;'>Product</td><td style='width:70px;'>Qu *</td><td style='width:70px;'>Price</td><td style='width:70px;'>Tax</td><td style='width:70px;'>Total</td><td style='width:70px;'>TOA</td><td style='width:70px;'>Need By *</td><td style='width:70px;'>Created</td><td>Action</td><td>Delete</td></tr>";
    
    getTable($result, $info);
    $conn->close();
}

// create table
function getTable($results, $info)
{

    $row = [];

    while ($row = $results->fetch_assoc()) {
        $info .= '<tr name="' . $row['id'] . '">';
        $indv_price = 0;
        $quantity = 0;
        $total = 0;
        $tax = 0;
        foreach ($row as $k => $v) {
            $edit = "";
            if ($k == "id")
                continue;
            if ($k == "customer")
                continue;
            switch ($k) {
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
                case "product":
                    break;
                case "total_price":
                    break;
                case "delivered":
                    break;
                case "created":
                    break;
                case "store_name":
                    break;
                default:
                    $edit = ' onclick="this.contentEditable=\'true\';" onblur="this.contentEditable=\'false\';editFields(this,\'' . $row['id'] . '\')"';
                    break;
            }
            $act0 = "";
            $act1 = "";
            $act2 = "";
            $act3 = "";
            if ($k == "action" && $v = 0) {
                $act0 = "selected ";
            } else if ($k == "action" && $v = 1) {
                $act1 = "selected ";
            } else if ($k == "action" && $v = 2) {
                $act2 = "selected ";
            } else if ($k == "action" && $v = 3) {
                $act3 = "selected ";
            }
            if ($k == "action") {
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px">';
                $info .= '<select onclick="setCookie(\'store_num\',' . $row['store_no'] . ');setCookie(\'store_name\',' . $row['store_name'] . ');setCookie(\'id\',' . $row['id'] . ');" onchange="editDrop(this)" id=\'sn' . $row['id'] . '\'>';
                $info .= '<option ' . $act0 . 'value=\'0\'>On Hold</option>';
                $info .= '<option ' . $act1 . 'value=\'1\'>Ordered</option>';
                $info .= '<option ' . $act2 . 'value=\'2\'>Canceled</option>';
                $info .= '<option ' . $act3 . 'value=\'3\'>Delivered</option>';
                $info .= '</select>';
            } else if ($k == "indv_price") {
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px">';
                $info .= '$' . $row['indv_price'];
            } else if ($k == "tax") {
                $tax = $row['indv_price'] * $row['quantity'] * $row['tax'];
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px">';
                $info .= '$' . $tax;
            } else if ($k == "total_price") {
                $total = $row['indv_price'] * $row['quantity'] + $tax;
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px">';
                $info .= '$' . $total;
            } else if ($k == "store_no") {
                $info .= '<td onclick="setCookie(\'id\',' . $row['id'] . ');this.style.display=\'none\';getInbox(\'x\')" style="cursor:pointer;background:gray;color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px"><img style="width:25px" src="icons/recycling-bin.png"/>';
            } else {
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border-right:1px solid lightgray;border-bottom:0px;border-top:0px;cell-spacing:0px"' . $edit . '>';
                $info .= $v;
            }
            $info .= '</td>';
        }
        $info .= '</tr>';
    }
    $info .= '</table>';
    echo $info;
}

// update spreadsheet
function updateRows($conn)
{
    $sql = 'UPDATE preorders SET action = :action' . $f . ' WHERE store_name = :store_name AND store_no = :store_num AND order_id = :orderid';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':action', $_GET['b'], PDO::PARAM_INT);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->bindParam(':orderid', $_COOKIE['orderid']);
    if ($_GET['b'] == "3") {
        $stmt->bindValue(':f', 'delivered = CURRENT_TIMESTAMP');
    } else {
        $stmt->bindValue(':f', 'delivered = NULL');
    }
    $stmt->execute();
    $conn->close();

}

//
function updateRow($conn)
{
    $sql = "";

    if ($_GET['b'] == "action") {
        $f = "";
        if ($_GET['a'] == "3") {
            $f = ', delivered = CURRENT_TIMESTAMP';
        } else {
            $f = ', delivered = null';
        }
        $g = (int) $_GET['a'];
        $sql = 'UPDATE preorders SET action = :action' . $f . ' WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':action', $g, PDO::PARAM_INT);
        $stmt->bindParam(':id', $_COOKIE['id'], PDO::PARAM_INT);
    } else if (is_numeric($_GET['a'])) {
        $sql = 'UPDATE preorders SET ' . $_GET['b'] . ' = :value WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $_GET['a'], PDO::PARAM_INT);
        $stmt->bindParam(':id', $_COOKIE['id'], PDO::PARAM_INT);
    } else {
        $sql = 'UPDATE preorders SET ' . $_GET['b'] . ' = :value WHERE id = :id';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':value', $_GET['a']);
        $stmt->bindParam(':id', $_COOKIE['id'], PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $conn->close();
}

function countOrders($conn)
{
    $sql = 'SELECT MAX(order_id) AS max_order_id FROM preorders WHERE store_name = :store_name AND store_no = :store_num';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':store_name', $_COOKIE['store']);
    $stmt->bindParam(':store_num', $_COOKIE['store_num']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $next_order = $result['max_order_id'] + 1;
    
    setcookie("orders", $next_order);
    
    $conn->close();
}

function getOrder($conn)
{
    getTax($conn);

    $sql = 'SELECT order_id, id, store_name, product, quantity, indv_price, tax, total_price, delivered, needed_by, created, action, store_no, customer FROM preorders WHERE order_id = :orderid AND store_no = :store_num AND store_name = :store_name';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':orderid', $_COOKIE['orderid'], PDO::PARAM_INT);
    $stmt->bindParam(':store_num', $_COOKIE['store_num'], PDO::PARAM_INT);
    $stmt->bindParam(':store_name', $_COOKIE['store_name']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray; id='order'><tr><td style='width:70px;'># &nbsp;</td><td style='width:35px;'>Est.</td><td style='width:35px;'>Product</td><td style='width:70px;'>Qu *</td><td style='width:70px;'>Price</td><td style='width:70px;'>Tax</td><td style='width:70px;'>Total</td><td style='width:70px;'>TOA</td><td style='width:70px;'>Need By *</td><td style='width:70px;'>Created</td><td>Action</td><td>Delete</td></tr>";
    
    getTable($result, $info);
    
    $conn->close();
}

if (isset($_GET['c']) && $_GET['c'] == 'd')
    listDelivered($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'o')
    listOrdered($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'g')
    updateRows($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'h')
    listHold($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'c')
    listCanceled($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'u')
    updateRow($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'a')
    getOrder($conn);
else if (isset($_GET['c']) && $_GET['c'] == 's')
    deleteOrder($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'x')
    deleteItem($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'li')
    shortListIn($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'p')
    shortListOut($conn);
else if (isset($_GET['c']) && $_GET['c'] == 'm')
    outOrders($conn);
?>
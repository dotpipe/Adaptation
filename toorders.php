<?php
    function shortList() {
    
        $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
        $table = "";
        $sql = "";
        if ($_GET['p'] == 0) {
            $sql = 'SELECT id, order_id, store_name, store_no, customer, needed_by, action FROM preorders WHERE customer != "' . $_COOKIE['e'] . '" && store_name = "' . $_COOKIE['store_name'] . '" && store_no = ' . $_COOKIE['store_num'];
            $table = '<table style="color:lightgray;border:2px solid blue;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
        }
        else {
            $sql = 'SELECT id, order_id, store_name, store_no, customer, needed_by, action FROM preorders WHERE customer = "' . $_COOKIE['e'] . '" ORDER BY created DESC';
            $table = '<table style="color:lightgray;border:2px solid blue;font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Est.</th><th>By Day</th><th>Action</th></tr>';
        }

        $result = $conn->query($sql) or die("GARRRRRRR");
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $table .= '<tr>';
                foreach ($row as $k => $v) {
                    if ($k === "id" || $k === "store_name" || $k === "store_no")
                        continue;
                    if ($k === "action") {
                        $s0 = ""; $s1 = ""; $s2 = ""; $s3 = "";
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
                        $table .= '<td>';
                        $table .= '<select onclick="setCookie(\'orderid\',' . $row['order_id'] . ');setCookie(\'store_name\',\'' . $row['store_name'] . '\');setCookie(\'store_num\',' . $row['store_no'] . ');setCookie(\'id\',' . $row['id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\')" onchange="editStack(this)" id=\'sn' . $row['id'] . '\'>';
                        $table .= '<option' . $s0 . ' value=\'0\'>On Hold</option>';
                        $table .= '<option' . $s1 . ' value=\'1\'>Ordered</option>';
                        $table .= '<option' . $s2 . ' value=\'2\'>Canceled</option>';
                        $table .= '<option' . $s3 . ' value=\'3\'>Delivered</option>';
                        $table .= '</select>';
                        $table .= '</td>';
                    }
                    else
                        $table .= '<td onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'a\',\'' . $row['order_id'] . '\')">' . $v . '</td>';
                }
                $table .= '</tr>';
            }
            $table .= '</table>';
            echo $table;
        }
    }
    
    function deleteOrder() {
        
        $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
        $sql = 'DELETE FROM preorders WHERE store_name = "' . $_COOKIE['store_name'] . '" && store_no = "' . $_COOKIE['store_num'] . '" && order_id = "' . $_COOKIE['orderid'] . '" && customer = "' . $_COOKIE['e'] . '"';
        
        $result = $conn->query($sql) or die("GAAAHHHH");
        
    }
    
    function deleteItem() {
        
        $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
        $sql = 'DELETE FROM preorders WHERE id = ' . $_COOKIE['id'];
        
        $result = $conn->query($sql) or die("GAAAHHHH");
        
    }

    function myOrders() {
    
        $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
        $sql = 'SELECT order_id, id, customer, product quantity, indv_price, total_price, delivered, needed_by, created, action FROM preorders WHERE customer = "' . $_COOKIE['e'] . '"';
        
        $result = $conn->query($sql) or die("GAAAHHHH");
        
        getTable($result);
    }
    
    function getTable($results) {
        $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>Order #</td><td>Est.</td><td>Product</td><td>Qu</td><td>Price</td><td>Total</td><td>TOA</td><td>Created</td><td>Action</td><td>Delete</td></tr>";
        
        $row = [];
    
        while ($row = $results->fetch_assoc()) {
            $info .= '<tr name="' . $row['id'] . '" onfocus="setCookie(\'e\',\'' . $row['customer'] . '\')">';
            $indv_price = 0;
            $quantity = 0;
            $total = 0;
            foreach ($row as $k => $v) {
                $edit = "";
                if ($k === "id" || $k === "store_no")
                    continue;
                if ($k === "customer" && $_GET['p'] == 1)
                    continue;
                if ($k === "store_name" && $_GET['p'] != 1)
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
                        case "product":
                        break;
                        case "total_price":
                        break;
                        case "delivered":
                        break;
                        case "created":
                        break;
                        default:
                            $edit = ' onclick="this.contentEditable=\'true\';setCookie(\'e\',\'' . $row['customer'] . '\')" onblur="this.contentEditable=\'false\';editFields(this,\'' . $row['id'] . '\')"';
                        break;
                    }
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
                    $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border:2px solid darkblue"' . $edit .'>';
                    $info .= '<select onclick="setCookie(\'id\',' . $row['id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\')" onchange="editDrop(this)" id=\'sn' . $row['id'] . '\'>';
                    $info .= '<option ' . $act0 . 'value=\'0\'>On Hold</option>';
                    $info .= '<option ' . $act1 . 'value=\'1\'>Ordered</option>';
                    $info .= '<option ' . $act2 . 'value=\'2\'>Canceled</option>';
                    $info .= '<option ' . $act3 . 'value=\'3\'>Delivered</option>';
                    $info .= '</select>';
                }
                else if ($k === "store_no") {
                    $info .= '<td onclick="setCookie(\'store_num\',' . $row['store_no'] . ');setCookie(\'store_name\',\'' . $row['store_name'] . '\');setCookie("orderid",' . $row['order_id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\');setCookie(\'id\',' . $row['id'] . ');getInbox(\'x\')" style="cursor:pointer;background:gray;color:lightgray;border:2px solid darkblue"><img style="width:25px" src="icons/recycling-bin.png"/>';
                }
                else {
                    $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border:2px solid darkblue"' . $edit .'>';
                    $info .= $v;
                }
                $info .= '</td>';
            }
            $info .= '</tr>';
        }
        $info .= '</table>';
        echo $info;
    }

function updateRows() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = "";

    $f = "";
    if ($_GET['b'] === "3") 
        $f = ', delivered = CURRENT_TIMESTAMP';
    else
        $f = ', delivered = NULL';
    $g = (int)$_GET['b'];
    $sql = 'UPDATE `preorders` SET `action` = ' . $g . $f . ' WHERE `store_name` = "' . $_COOKIE['store_name'] . '" && `store_no` = ' . $_COOKIE['store_num'] . ' && `order_id` = ' . $_COOKIE['orderid'] . ' && `customer` = "' . $_COOKIE['e'] . '"';

    echo $sql;

    $conn->query($sql) or die("AGGHHH");

}

function updateRow() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = "";
    
    
    if ($_GET['b'] == "action") {
        $f = "";
        if ($_GET['a'] === "3")
            $f = ', delivered = CURRENT_TIMESTAMP';
        else
            $f = ', delivered = null';
        $g = (int)$_GET['a'];
        $sql = 'UPDATE `preorders` SET `action` = ' . $g . $f . ' WHERE `id` = ' . $_COOKIE['id'] . ' && `customer` = "' . $_COOKIE['e'] . '"';
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

    $sql = 'SELECT order_id, id, store_name, product, quantity, indv_price, total_price, delivered, needed_by, created, action, store_no, customer FROM preorders WHERE store_no = ' . $_COOKIE['store_num'] . ' && store_name = "' . $_COOKIE['store_name'] . '" && store_no = "' . $_COOKIE['store_num'] . '"';
    
    $result = $conn->query($sql) or die("GAAAHHHH");
    
    $info = "<table style='text-align:center;font-size:13px;color:lightgray;border:2px solid darkblue' id='order'><tr><td>#</td><td>Est.</td><td>Product</td><td>Qu</td><td>Price</td><td>Total</td><td>TOA</td><td>Created</td><td>Action</td><td>Delete</td></tr>";
    
    $row = [];
    
    while ($row = $result->fetch_assoc()) {
        $info .= '<tr name="' . $row['id'] . '" onfocus="setCookie(\'e\',\'' . $row['customer'] . '\')">';
        $indv_price = 0;
        $quantity = 0;
        $total = 0;
        foreach ($row as $k => $v) {
            $edit = "";
            if ($k === "id" || $k === "customer")
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
                case "delivered":
                break;
                case "created":
                break;
                case "store_no":
                break;
                case "store_name":
                break;
                case "product":
                break;
                default:
                    $edit = ' onclick="this.contentEditable=\'true\';setCookie(\'e\',\'' . $row['customer'] . '\')" onblur="this.contentEditable=\'false\';editFields(this,\'' . $row['id'] . '\')"';
                break;
            }
            
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
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border:2px solid darkblue"' . $edit .'>';
                $info .= '<select onclick="setCookie(\'id\',' . $row['id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\')" onchange="editDrop(this)" id=\'sn' . $row['id'] . '\'>';
                $info .= '<option ' . $act0 . 'value=\'0\'>On Hold</option>';
                $info .= '<option ' . $act1 . 'value=\'1\'>Ordered</option>';
                $info .= '<option ' . $act2 . 'value=\'2\'>Canceled</option>';
                $info .= '<option ' . $act3 . 'value=\'3\'>Delivered</option>';
                $info .= '</select>';
            }
            else if ($k === "store_no") {
                $info .= '<td onclick="setCookie(\'store_num\',' . $row['store_no'] . ');setCookie(\'store_name\',\'' . $row['store_name'] . '\');setCookie(\'orderid\',' . $row['order_id'] . ');setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'x\')" style="cursor:pointer;background:gray;color:lightgray;border:2px solid darkblue"><img style="width:25px" src="icons/recycling-bin.png"/>';
            }
            else {
                $info .= '<td name="' . $k . '" xid="' . $row['id'] . '" style="color:lightgray;border:2px solid darkblue"' . $edit .'>';
                $info .= $v;
            }
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
else if (isset($_GET['c']) && $_GET['c'] == 'g')
    updateRows();
else if (isset($_GET['c']) && $_GET['c'] == 'h')
    listHold();
else if (isset($_GET['c']) && $_GET['c'] == 'c')
    listCanceled();
else if (isset($_GET['c']) && $_GET['c'] == 'u')
    updateRow();
else if (isset($_GET['c']) && $_GET['c'] == 'a')
    getOrder();
else if (isset($_GET['c']) && $_GET['c'] == 'p')
    myOrders();
else if (isset($_GET['c']) && $_GET['c'] == 's')
    deleteOrder();
else if (isset($_GET['c']) && $_GET['c'] == 'x')
    deleteItem();
else if (isset($_GET['c']) && $_GET['c'] == 'z')
    shortList();
?>

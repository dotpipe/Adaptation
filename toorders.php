<?php

function countOrders() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id FROM preorders WHERE store_name = "' . $_COOKIE['store_name'] . '" && store_no = "' . $_COOKIE['store_no'] . '" && customer = "' . $_COOKIE['e'] . '" UNIQUE';

    $conn->mysqli_query($sql) or die("AGGHHH");

    $next_order = $results->num_rows;

    setcookie("orders", $next_order + 1);

}

function getOrder($tvb) {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id, id, customer, expected, product, quantity, indv_price, total_price, delivered, needed_by, action, created FROM preorders WHERE customer = "' . $_COOKIE['e'] . '" || store_name = "' . $_COOKIE['store_name'] . '"';
    
    $result = mysql_connect($conn,$sql) or die("GAAAHHHH");
    
    $info = "<table id='order'><tr><th>Order #</th><th>Customer</th><th>Expected</th><th>Product</th><th>Qu</th><th>Price</th><th>Total</th><th>Note</th><th>Need By</th><th>Created</th><th>Action</th></tr>";
    
    foreach ($result->fetch_assoc() as $row) {
        $info .= '<tr id="rn' . $row['id'] . '">';
        $indv_price = 0;
        $quantity = 0;
        $total = 0;
        $info .= '<td>' . $row['order_id'] . '</td>';
        foreach ($row as $k => $v) {
            $edit = "";
            switch($k) {
                case "action":
                break;
                case "total_price":
                break;
                case "customer":
                break;
                case "indv_price":
                break;
                case "order_id":
                break;
                case "id":
                break;
                default:
                    $edit = ' onclick="this.isEditable=\'true\'" onblur="this.isEditable=\'false\'"';
                break;
            }
            $info .= '<td' . $edit .'>';
            $act0 = ""; $act1 = ""; $act2 = ""; $act3 = ""; 
            if ($k == "indv_price") {
                $indv_price .= $v;
                $info .= $v;
            }
            else if ($k == "quantity") {
                $quantity = $v;
                $info .= $v;
            }
            else if ($quantity > 0 && $indv_price > 0)
                $total = $quantity * $indv_price;
            else if ($k == "total_price")
                $info .= $total;
            else if ($k === "action" && $v == 0) {
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
            else if ($k !== "order_id" && $k !== "id")
                $info .= $v;
            $info .= '</td>';
        }
        $info .= '<td>';
        $info .= '<select id=\'sn' . $row['id'] . '\'>';
        $info .= '<option ' . $act0 . 'value=\'0\'>On Hold</option>';
        $info .= '<option ' . $act1 . 'value=\'1\'>Ordered</option>';
        $info .= '<option ' . $act2 . 'value=\'2\'>Canceled</option>';
        $info .= '<option ' . $act3 . 'value=\'3\'>Delivered</option>';
        $info .= '</select>';
        $info .= '</td>';
        $info .= '</tr>';
    }
    $info .= '</table>';
    
}

if (isset($_GET['c']) && $_GET['c'] == 'd')
    getOrder($_COOKIE['store_id']);
else
    countOrders();

?>

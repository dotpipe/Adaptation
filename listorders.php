<?php

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id, customer, needed_by, action FROM preorders WHERE store_name = "' . $_COOKIE['store'] . '" && store_no = ' . $_COOKIE['store_no'];
    
    $result = $conn->query($sql) or die("GARRRRRRR");
    $table = "";
    if ($result->num_rows > 0) {
        $table = '<table style="font-size:13px;text-align:center;"><tr><th>Order #<th>Customer</th><th>Needed By</th><th>Action</th></tr>';
        while ($row = $result->fetch_assoc()) {
            $table .= '<tr onclick="setCookie(\'e\',\'' . $row['customer'] . '\');getInbox(\'a\',\'' . $row['order_id'] . '\')">';
            foreach ($row as $k => $v) {
                $table .= '<td>' . $v . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
    }
echo $table;

?>
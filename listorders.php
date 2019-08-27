<?php

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    if ($_GET['p'] == 1)
        $sql = 'SELECT id, order_id, store_name, store_no, customer, needed_by, action FROM preorders WHERE store_name = "' . $_COOKIE['store'] . '" && store_no = ' . $_COOKIE['store_no'];
    else
        $sql = 'SELECT id, order_id, store_name, store_no, customer, needed_by, action FROM preorders WHERE customer = "' . $_COOKIE['e'] . '" ORDER BY created DESC';
    
    
    $result = $conn->query($sql) or die("GARRRRRRR");
    $table = "";
    if ($result->num_rows > 0) {
        $table = '<table style="font-size:13px;text-align:center;"><tr><th>#&nbsp&nbsp<th>Customer</th><th>By Day</th><th>Action</th></tr>';
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
    }
echo $table;

?>
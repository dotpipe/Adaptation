<?php

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");

    $sql = 'SELECT order_id, customer, needed_by, action FROM preorders WHERE delivered = NULL';
    
    $result = $conn->mysqli_query($sql) or die("GARRRRRRR");
    $table = "";
    if ($result->num_rows > 0) {
        $table = '<table><tr><th>Order #<th>Customer</th><th>Needed By</th><th>Action</th></tr>';
        foreach ($result->fetch_assoc() as $row) {
            $table .= '<tr onclick="getInbox(d,\'' . $row['id'] . '\')">';
            foreach ($row as $k => $v) {
                $table .= '<td>' . $v . '</td>';
            }
            $table .= '</tr>';
        }
        $table .= '</table>';
    }
echo $table;

?>
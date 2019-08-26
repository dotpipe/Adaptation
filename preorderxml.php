<?php

    function countOrders() {

        setcookie("orders",0);
        
        $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
        $sql = 'SELECT DISTINCT(order_id) FROM `preorders` WHERE `store_name` = "' . $_COOKIE['store'] . '" && `store_no` = ' . $_COOKIE['store_no'] . ' && `customer` = "' . $_COOKIE['e'] . '"';
    
        echo $sql;
        $results = mysqli_query($conn,$sql) or die("AGGHHH");
    
        $f = $results->fetch_assoc();
        
        $next_order = $results->num_rows;
    
        setcookie("orders", $next_order + 1);
    
        $conn->close();
    }
    
    $con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");
    
    countOrders();

    $a = str_getcsv($_GET['a']);
    $b = str_getcsv($_GET['b']);
    $c = $_GET['c'];
    
    $i = 0;
    $sql = "";
    foreach ($a as $v) {
        if ($v === "" || $v === null) {
            $i++;
            continue;
        }
        $sql = 'INSERT INTO preorders(`id`,`customer`,`store_name`,`store_no`,`product`,`quantity`,`indv_price`,`total_price`,`needed_by`,`delivered`,`expected`,`action`,`created`,`order_id`)';
        $sql .= ' VALUES(null,"' . $_COOKIE['myemail'] . '","' . $_COOKIE['store'] . '",' . $_COOKIE['store_no'] . ',"' . $v . '",' . $b[$i] . ',0,0,' . $c . ',null,null,0,CURRENT_TIMESTAMP,' . $_COOKIE['orders'] . ')';
        $i++;
        $result = $con->query($sql) or die(json_encode(mysqli_error_list($con)));
    }
    
    //echo $sql;
    
   


?>
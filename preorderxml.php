<?php

    function getTax($conn) {
    
        $sql = 'SELECT EstimatedCombinedRate FROM taxes WHERE ZipCode = "' . $_COOKIE['zip_code'] . '"';
        //echo $sql;
        $tax = $conn->query($sql) or die(mysqli_error($conn));
    
        $row = $tax->fetch_assoc();
    
        setcookie("taxes", $row['EstimatedCombinedRate']);
    
    }

    function countOrders($conn) {

        setcookie("orders",0);
        
        $sql = 'SELECT MAX(order_id) AS max FROM preorders WHERE store_name = "' . $_COOKIE['store'] . '" && store_no = ' . $_COOKIE['store_no'];
    
        $results = $conn->query($sql) or die("AGGHHH");
    
        $f = $results->fetch_assoc();
        
        $next_order = $f['max'];
    
        setcookie("orders", $next_order + 1);
    
    }
    
    // preorder entry into database
    
    $con = mysqli_connect('localhost', 'r0ot3d', 'RTYfGhVbN!3$', 'adrs','3306') or die("Error: Can't connect");
    
    countOrders($con);
    getTax($con);
    
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
        
        $sql = 'INSERT INTO preorders(id,customer,store_name,store_no,product,quantity,indv_price,tax,total_price,needed_by,delivered,expected,action,created,order_id,edited)';
        $sql .= ' VALUES(null,"' . $_COOKIE['myemail'] . '","' . $_COOKIE['store'] . '",' . $_COOKIE['store_no'] . ',"' . $v . '",' . $b[$i] . ',0,' . $_COOKIE['taxes'] . ',0,' . $c . ',null,null,0,CURRENT_TIMESTAMP,' . $_COOKIE['orders'] . ',null)';
        $i++;
        $result = $con->query($sql) or die(mysqli_error($con));
    }
    
    $con->close();
?>
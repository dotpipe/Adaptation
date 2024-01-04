<?php

    include("db.php");
    function getTax($conn) {
        $sql = 'SELECT EstimatedCombinedRate FROM taxes WHERE ZipCode = :zip_code';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':zip_code', $_COOKIE['zip_code']);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        setcookie("taxes", $row['EstimatedCombinedRate']);
    
    }

    function countOrders($conn) {
        setcookie("orders", 0);

        $sql = 'SELECT MAX(order_id) AS max FROM preorders WHERE store_name = :store_name AND store_no = :store_no';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':store_name', $_COOKIE['store']);
        $stmt->bindParam(':store_no', $_COOKIE['store_no']);
        $stmt->execute();
        
        $f = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $next_order = $f['max'];
        
        setcookie("orders", $next_order + 1);
    
    }
    
    // preorder entry into database
    try {
    
        countOrders($conn);
        getTax($conn);
    
        $a = str_getcsv($_GET['a']);
        $b = str_getcsv($_GET['b']);
        $c = $_GET['c'];
    
        $i = 0;
        $sql = "INSERT INTO preorders(customer, store_name, store_no, product, quantity, indv_price, tax, total_price, needed_by, delivered, expected, action, created, order_id) VALUES(:customer, :store_name, :store_no, :product, :quantity, 0, :taxes, 0, :needed_by, null, null, 0, CURRENT_TIMESTAMP, :orders)";
        $stmt = $conn->prepare($sql);
    
        foreach ($a as $v) {
            if ($v === "" || $v === null) {
                $i++;
                continue;
            }
    
            $stmt->bindParam(':customer', $_COOKIE['myemail']);
            $stmt->bindParam(':store_name', $_COOKIE['store']);
            $stmt->bindParam(':store_no', $_COOKIE['store_no']);
            $stmt->bindParam(':product', $v);
            $stmt->bindParam(':quantity', $b[$i]);
            $stmt->bindParam(':taxes', $_COOKIE['taxes']);
            $stmt->bindParam(':needed_by', $c);
            $stmt->bindParam(':orders', $_COOKIE['orders']);
            $stmt->execute();
            $i++;
        }
    
        $conn = null;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
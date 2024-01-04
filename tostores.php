<?php
if (!isset($_SESSION))
    session_start();

    include("db.php");  
function listStores($conn) {

    $sess = [];
    $sql = 'SELECT store_no, franchise.store_name, nums AS running, nums AS stored, seen, franchise.avg_reviews, franchise.addr_str, franchise.zip, total_paid, last_paid_on, end FROM franchise, ad_revs, advs WHERE ad_revs.username = :myemail && (franchise.email = ad_revs.username || franchise.owner_id = ad_revs.username) && advs.store_name = franchise.store_name';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $stores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sql = 'SELECT store_no, franchise.store_name, nums FROM franchise, ad_revs, advs WHERE ad_revs.username = :myemail && (franchise.email = ad_revs.username || franchise.owner_id = ad_revs.username) && advs.store_name = franchise.store_name';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $ads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $sess = [];
    foreach ($stores as $row) {
        $sess[$row['store_name']] = [];
        foreach ($row as $k => $v) {
            if ($k === "0" || $k === "end") {
                continue;
            }
            // Write code to match store no with storename
            // get list of store nos from nums, and add
            // accordingly.
            if ($k === 'running') {
                if (!isset($sess[$row['store_name']]['running'])) {
                    $sess[$row['store_name']]['running'] = 0;
                }
                if ($row['end'] > time()) {
                    // Add logic to increment running count
                    // based on conditions
                }
            } elseif ($k === 'stored') {
                if (!isset($sess[$row['store_name']]['stored'])) {
                    $sess[$row['store_name']]['stored'] = 0;
                }
                if ($row['end'] <= time()) {
                    // Add logic to calculate stored count
                    // based on conditions
                }
            } else {
                $sess[$row['store_name']][$k] = $v;
            }
        }
    }
    
    $form = '<style> .t { text-align:center;font-size:12px;border-right:1px solid white;width:200px; } </style>';
    $form .= '<table><tr>';
    $form .= '<td class="t"><span>Store_No.</span></td><td class="t"><span>Name</span></td><td class="t"><span>Ads_Running</span></td>';
    $form .= '<td class="t"><span>Stored Ads</span></td><td class="t"><span>Hits</span></td><td class="t"><span>Reviews_(x/5)</span></td>';
    $form .= '<td class="t"><span>Address</span></td><td class="t"><span>ZipCode</span></td><td class="t"><span>Total_Paid</span></td>';
    $form .= '<td class="t"><span>Last Paid On</span></td></tr>';
    $i = 0;
    
    foreach ($sess as $key) {
        $form .= '<tr onclick="menuList(\'adsheet.php\')">';
        $i = 0;
        foreach ($key as $k => $v) {
            $form .= '<td class="t" id="' . $k . '" style="text-align:center;background:lightgray;color:black;border-right:1px solid black;border-bottom:1px solid black;">' . $v . '</td>';
            $i++;
        }
        $form .= '<tr>';
    }
    $form .= "</table>";
    echo $form;
}

listStores($conn);
?>
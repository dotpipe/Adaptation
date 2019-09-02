<?php
if (!isset($_SESSION))
    session_start();
    
function listStores() {

    $sess = [];
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    $sql = 'SELECT store_no, franchise.store_name, nums AS running, nums AS stored, seen, franchise.avg_reviews, franchise.addr_str, franchise.zip, total_paid, last_paid_on, end FROM franchise, ad_revs, advs WHERE ad_revs.username = "' . $_COOKIE['myemail'] . '" && (franchise.email = ad_revs.username || franchise.owner_id = ad_revs.username)';
    $stores = $conn->query($sql) or die (mysqli_error($conn));
    $sql = 'SELECT store_no, franchise.store_name, nums FROM franchise, ad_revs, advs WHERE ad_revs.username = "' . $_COOKIE['myemail'] . '" && (franchise.email = ad_revs.username || franchise.owner_id = ad_revs.username) && advs.store_name = franchise.store_name';
    $ads = $conn->query($sql) or die (mysqli_error($conn));
    $res = [];
    $j = 0;
    $in = [];
    while ($res = $stores->fetch_assoc()) {
        $ads->data_seek(0);
        while ($row = $ads->fetch_assoc()) {
            if ($res['store_name'] === $row['store_name'] && $res['store_no'] === $row['store_no']) {
                $in[$j][0] = array($res['store_name'] => $res['store_no']);
                $in[$j][1] = ($res['stored'] == "0") ? 0 : count(str_getcsv($res['stored']));
                $j++;
                break;
            }
        }
    }
    $stores->data_seek(0);
    if ($stores->num_rows > 0) {
        $row = [];
        $i = 0;
        while ($row = $stores->fetch_assoc()) {
            $store = "";
            $sess[$row['store_name']] = [];
            while ($ads_assoc = $ads->fetch_assoc()) {
                $i++;
                if ($ads_assoc['store_name'] === $row['store_name'] && $ads_assoc['store_no'] === $row['store_no'])
                    break;
            }
            $ads->data_seek($i);
            foreach ($row as $k => $v) {
                if ($k === "0" || $k === "end")
                    continue;
                // Write code to match store no with storename
                // get list of store nos from nums, and add
                // accordingly.
                if ($k === 'running') {
                    if (!isset($sess[$row['store_name']]['running']))
                        $sess[$row['store_name']]['running'] = 0;
                    if ($row['end'] > time()) {
                        if (!in_array(array($row['store_name'], $row['store_no']), $in))
                            $sess[$row['store_name']]['running']++;
                    }
                }
                else if ($k === 'stored') {
                    if (!isset($sess[$row['store_name']]['stored']))
                        $sess[$row['store_name']]['stored'] = 0;
                    if ($row['end'] <= time()) {
                        $g = 0;
                        $h = 0;
                        while ($h < count($in) && array($row['store_name'] => $row['store_no']) != $in[$h++][0]);
                        
                        $sess[$row['store_name']]['stored'] = $in[$h-1][1];
                        
                    }
                }
                else
                    $sess[$row['store_name']][$k] = $v;
            }
        }
    }
    else
        $_SESSION['stores'] = null;
        
    $form = '<style> .t { text-align:center;font-size:12px;border-right:1px solid white;width:200px; } </style>';
    $form .= '<table><tr>';
    $form .= '<td class="t"><span>Store_No.</span></td><td class="t"><span>Name</span></td><td class="t"><span>Ads_Running</span></td>';
    $form .= '<td class="t"><span>Stored Ads</span></td><td class="t"><span>Hits</span></td><td class="t"><span>Reviews_(x/5)</span></td>';
    $form .= '<td class="t"><span>Address</span></td><td class="t"><span>ZipCode</span></td><td class="t"><span>Total_Paid</span></td>';
    $form .= '<td class="t"><span>Last Paid On</span></td></tr>';
    $i = 0;
    
    $arrays = [];
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

listStores();
?>
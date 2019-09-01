<?php
if (!isset($_SESSION))
    session_start();
    
function listStores() {

    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
    $sql = 'SELECT store_no, franchise.store_name AS stn, nums AS running, nums AS seri, seen, franchise.avg_reviews, franchise.addr_str, franchise.zip, total_paid, last_paid_on FROM franchise, ad_revs, advs WHERE (franchise.email = "' . $_COOKIE['myemail'] . '" || franchise.owner_id  = "' . $_COOKIE['myemail'] . '")';
    $stores = $conn->query($sql) or die (mysqli_error($conn));
    $sql = 'SELECT store_no, franchise.store_name, nums FROM advs, franchise WHERE franchise.store_name = advs.store_name ';
    if ($stores->num_rows > 0) {
        $row = [];
        while ($row = $stores->fetch_assoc()) {
            $store = "";
            $sql = 'SELECT store_no, franchise.store_name, nums, end FROM advs, franchise WHERE "' . $row['stn'] . '" = advs.store_name ';
            $ads = $conn->query($sql) or die (mysqli_error($conn));
            $ads_res = $ads->fetch_assoc();
            $i = 0;
            foreach ($row as $k => $v) {
                if ($k === 'running' || $k === "seri") {
                    if ($ads_res['end'] > time())
                        $sess[$row['stn']]['running']++;
                    else if ($ads_res['end'] <= time())
                        $sess[$row['stn']]['stored'] = count(str_getcsv($ads_res['nums'], ","));
                }
                else
                    $sess[$row['stn']][$k] = $v;
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
        $form .= '<tr onclick="menuList(\'adsheet.php\')>';
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
    
function updateRow() {
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs", "3306") or die("Error: Cannot create connection");
    
    $sql = "";
    
    if (is_int($_GET['a']))
        $sql = 'UPDATE advs SET ' . $_GET['b'] . ' = ' . $_GET['a'] . ' WHERE serial  = ' . $_GET['d'];
    else
        $sql = 'UPDATE advs SET ' . $_GET['b'] . ' = "' . $_GET['a'] . '" WHERE serial = ' . $_GET['d'];
    
    $conn->query($sql) or die(mysqli_error($conn));
    
    $conn->close();

}

listStores();
?>
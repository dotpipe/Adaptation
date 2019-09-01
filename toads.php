<?php

if (!isset($_SESSION))
    session_start();

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

function listAds($res) {

    $form = '<style> .t { text-align:center;font-size:12px;border-right:1px solid white;width:200px; } </style>';
    $form .= '<table><tr>';
    $form .= '<td class="t"><span>Serial (Click to review)</span></td><td class="t"><span>Storename</span></td><td class="t"><span>State</span></td>';
    $form .= '<td class="t">Time Left</td><td class="t">Extend (hrs)</td><td class="t">End</td><td class="t">Seen</td><td class="t">Flags</td><td class="t">YouTube</td>';
    $form .= '<td class="t">Zip Code</td><td class="t"><span>Total Paid</span></td><td class="t"><span>Last Paid On</span></td><td class="t"><span>Store_#</span></td></tr>';
    $i = 0;
    
    foreach ($_SESSION['ads'] as $key => $val) {    
        $form .= '<tr onclick="setCookie(\'serial\',' . $val['serial'][0] . ');callPagePost(\'adsheet.php\')">';
        $i = 0;
        foreach ($val as $k => $v) {
            $t_start = (int)$val['start'];
            $t_end = (int)$val['end'];
            $time_left = null;
            if ($t_end > time())
                $time_left = date("z:H:i", (int)$t_end - time());
            else
                $time_left = "Suspended";
            $time_start = date("d-m-Y H:i", (int)$val['start']);
            $time_end = date("d-m-Y H:i", (int)$val['end']);
            if ($i === 2)
                $form .= '<td class="t" id="state" style="text-align:center;background:lightgray;color:red;border-right:1px solid black;border-bottom:1px solid black;">' . $time_left . '</td>';
            if ($i === 3)
                $form .= '<td class="t" id="extend" onblur="updateRow(this)" style="text-align:center;background:white;color:black;border-right:1px solid black;border-bottom:1px solid black;" contentEditable="true">4</td>';            
            $form .= '<td class="t" id="' . $k . '" style="text-align:center;background:lightgray;color:black;border-right:1px solid black;border-bottom:1px solid black;">' . $v[0] . '</td>';    
            $i++;
        }
        
        $form .= '<tr>';
    }
    echo $form;
}

function newAd() {
    
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs") or die(mysqli_error($conn));
    
    $x = urldecode($_GET['password']);
    $y = str_getcsv(urldecode($_GET['no']),",");
    
    $passql = 'SELECT franchise.password AS a, ad_revs.password AS b, store_no, owner_id, email FROM franchise, ad_revs WHERE (owner_id = email && owner_id = username) || (username = owner_id || username = email)';
    $i = 0;
    $same = [];
    if ($passql->num_rows > 0) {
        while ($row = $passql->fetch_assoc()) {
            if (in_array($row['store_no'],$y) && password_verify($x, $rows['a'])) {
                $i = 2;
                break;
            }
            else if (in_array($row['store_no'],$y) && password_verify($x, $rows['b'])) {
                $i = 1;
                $same[] = $row['store_no'];
            }
        }
    }

    if ($i === 2 || $i === 1) {
        $sql = 'INSERT INTO advs(store_name,slogan,description,img,total_paid,last_paid_on,flagged,start,end,serial,url,seen,zip,nums) VALUE("' . $_COOKIE['mystore'] . '","' . $_COOKIE['slogan'] . '","' . $_COOKIE['desc'] . '","' . $_COOKIE['img'] . '",0,0,0,' . $_COOKIE['start'] . ',' . $_COOKIE['end'] . ',null,"' . $_COOKIE['url'] . '",0,' . $_COOKIE['zip_code'] . ',"' . $_GET['no'] . '")';
        $res = $conn->query($sql);
    }
    
}

function loadAds() {
    
    $_SESSION['ads'] = array();
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs") or die(mysqli_error($conn));
    
    $sql = 'SELECT store_name, slogan, description, img, serial, url, zip FROM advs, franchise WHERE end > "' . $_COOKIE['time'] . '" && start < "' . $_COOKIE['time'] . '" ORDER BY start ASC';
    
    $res = $conn->query($sql) or die(mysqli_error($conn));

    if ($res->num_rows) {
        $i = 0;
        while ($row = $res->fetch_assoc()) {
            foreach ($row as $k => $v) {
                $_SESSION['ads'][$i][$k][] = $v;
            }
            $i++;
        }
    }
    listAds($_SESSION);
}

function loadMyAds() {
    
    $_SESSION['ads'] = array();
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs") or die(mysqli_error($conn));
    
    $stores = "";
    foreach ($_SESSION['stores'] as $key => $v) {
        //if (is_array($v)) {
            foreach ($v as $k => $val)
                $stores .= ' || (franchise.store_name = "' . $key . '" && franchise.store_no = ' . $val . ')';
        //}
    }
    $sql = 'SELECT serial, franchise.store_name, start, end, seen, advs.flags, url, franchise.zip, total_paid, last_paid_on, store_no, nums FROM ad_revs, franchise, advs WHERE (ad_revs.username = franchise.owner_id || franchise.email = ad_revs.username) && (' . substr($stores,4,strlen($stores)) . ') ORDER BY start ASC';
    
    $res = $conn->query($sql) or die(mysqli_error($conn));

    if ($res->num_rows) {
        $i = 0;
        while ($row = $res->fetch_assoc()) {
            if (!in_array($row['store_no'], str_getcsv($row['nums'])))
                continue;
            foreach ($row as $k => $v) {
                if ($k === 'nums')
                    continue;
                $_SESSION['ads'][$i][$k][] = $v;
            }
            $i++;
        }
    }
    listAds($_SESSION);
}

function updSeen() {
    
    $_SESSION['ads'] = array();
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs") or die(mysqli_error($conn));
    
    $sql = 'UPDATE advs SET seen = (seen + 1) WHERE serial = ' . $_GET['serial'];
    
    $res = $conn->query($sql);
}

function updTime() {
    
    $_SESSION['ads'] = array();
    $conn = mysqli_connect("localhost", "r0ot3d", "RTYfGhVbN!3$", "adrs") or die(mysqli_error($conn));
    $time = int($_GET['e']);
    $sql = 'UPDATE advs SET end = (end + ' . ($time*60*60) . ') WHERE serial = ' . $_GET['d'];
    
    $res = $conn->query($sql);
}

setcookie("time",time());

if ($_GET['c'] == 'na')
    newAd();
if ($_GET['c'] == 'la')
    loadAds();
if ($_GET['c'] == 'us')
    updSeen();
if ($_GET['c'] == 'uptime')
    updTime();    
if ($_GET['c'] == 'up')
    updateRow();
if ($_GET['c'] == 'lx')
    loadMyAds($_SESSION['ads']);

?>
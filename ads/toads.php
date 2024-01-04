<?php

if (!isset($_SESSION))
    session_start();

    include("db.php");
function updateRow($conn) { // update propery `b  to value `a` where `serial` is `d` in `advs` (advertisements) 
    $sql = "";
    $params = array(
        'a' => $_GET['a'],
        'b' => $_GET['b'],
        'd' => $_GET['d']
    );
    
    if (is_numeric($_GET['a'])) {
        $sql = 'UPDATE advs SET ' . $_GET['b'] . ' = :a WHERE serial = :d';
    } else {
        $sql = 'UPDATE advs SET ' . $_GET['b'] . ' = :a WHERE serial = :d';
    }
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

}

function listAds($res) {

    $form = '<style> .t { text-align:center;font-size:12px;border-right:1px solid white;width:200px; } </style>';
    $form .= '<table><tr>';
    $form .= '<td class="t"><span>Serial (Click to review)</span></td><td class="t"><span>Storename</span></td><td class="t"><span>State</span></td>';
    $form .= '<td class="t">Time Left</td><td class="t">Extend (hrs)</td><td class="t">End</td><td class="t">Seen</td><td class="t">Flags</td><td class="t">YouTube</td>';
    $form .= '<td class="t">Zip Code</td><td class="t"><span>Total Paid</span></td><td class="t"><span>Last Paid On</span></td><td class="t"><span>Store_#</span></td></tr>';
    $i = 0;
    
    foreach ($res as $key => $val) {    
        $form .= '<tr onclick="setCookie(\'serial\',' . $key['serial'] . ');callPagePost(\'ads/adsheet.php\')">';
        $i = 0;
        foreach ($val as $k => $v) {
            $t_start = (int)$key['start'];
            $t_end = (int)$key['end'];
            $time_left = null;
            if ($t_end > time())
                $time_left = date("z:H:i", (int)$t_end - time());
            else
                $time_left = "Suspended";
            $time_start = date("d-m-Y H:i", (int)$key['start']);
            $time_end = date("d-m-Y H:i", (int)$key['end']);
            if ($i === 2)
                $form .= '<td class="t" id="state" style="text-align:center;background:lightgray;color:red;border-right:1px solid black;border-bottom:1px solid black;">' . $time_left . '</td>';
            if ($i === 3)
                $form .= '<td class="t" id="extend" onblur="updateRow(this)" style="text-align:center;background:white;color:black;border-right:1px solid black;border-bottom:1px solid black;" contentEditable="true">4</td>';            
            $form .= '<td class="t" id="' . $k . '" style="text-align:center;background:lightgray;color:black;border-right:1px solid black;border-bottom:1px solid black;">' . $v[0] . '</td>';    
            $i++;
        }
        
        $form .= '<tr>';
    }
    $form .= '</table>';
    echo $form;
}

// enter new ad from newad.php to database TODO
function newAd($conn) {
    
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
        $sql = 'INSERT INTO advs(store_name, slogan, description, img, total_paid, last_paid_on, flagged, start, end, serial, url, seen, zip, nums) VALUES(:store_name, :slogan, :description, :img, 0, 0, 0, :start, :end, null, :url, 0, :zip_code, :no)';
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':store_name', $_COOKIE['mystore']);
        $stmt->bindParam(':slogan', $_COOKIE['slogan']);
        $stmt->bindParam(':description', $_COOKIE['desc']);
        $stmt->bindParam(':img', $_COOKIE['img']);
        $stmt->bindParam(':start', $_COOKIE['start']);
        $stmt->bindParam(':end', $_COOKIE['end']);
        $stmt->bindParam(':url', $_COOKIE['url']);
        $stmt->bindParam(':zip_code', $_COOKIE['zip_code']);
        $stmt->bindParam(':no', $_GET['no']);
        $res = $stmt->execute();
    }
    
}

// load all active ads
function loadAds($conn) {
    $sql = 'SELECT store_name, slogan, description, img, serial, url, zip FROM advs, franchise WHERE end > :current_time AND start < :current_time ORDER BY start ASC';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_time', time(), PDO::PARAM_INT);
    $stmt->execute();
    $sess = $stmt->fetchAll(PDO::FETCH_ASSOC);
    listAds($sess);
}

//look at my ads

function loadMyAds($conn) {
    $sql = 'SELECT nums, franchise.store_name, store_no FROM franchise, ad_revs, advs WHERE ad_revs.username = :myemail AND (franchise.email = ad_revs.username OR franchise.owner_id = ad_revs.username) AND franchise.store_name = advs.store_name';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->execute();
    $st_sess = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stores_str = "";
    $store_nos = [];
    foreach ($st_sess as $key => $v) {
        if ($key === "nums") {
            $store_nos = str_getcsv($st_sess['nums'], ",");
        } elseif ($key === "store_name") {
            $stores_str .= '(advs.store_name = :store_name AND franchise.store_name = :store_name) AND';
        } elseif ($key === "store_no") {
            $stores_str .= '(';
            foreach ($store_nos as $k) {
                $stores_str .= 'franchise.store_no = ' . $k . ' OR ';
            }
            $stores_str = substr($stores_str, 0, strlen($stores_str) - 4) . ')';
        }
    }
    
    $sql = 'SELECT serial, franchise.store_name, start, end, seen, advs.flags, url, franchise.zip, total_paid, last_paid_on, store_no, nums FROM franchise, ad_revs, advs WHERE ad_revs.username = :myemail AND ' . $stores_str . ' AND (franchise.email = ad_revs.username OR franchise.owner_id = ad_revs.username) AND franchise.store_name = advs.store_name';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':myemail', $_COOKIE['myemail']);
    $stmt->bindParam(':store_name', $st_sess['store_name']);
    $stmt->execute();
    $sess = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    listAds($sess);
}
// new hit
function updSeen($conn) {
    $sql = 'UPDATE advs SET seen = (seen + 1) WHERE serial = :serial';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':serial', $_GET['serial']);
    $stmt->execute();
}

// add hours (+/-) minus hours (spreadsheet on MyAds.php)
function updTime($conn) {
    $time = intval($_GET['e']);
    $sql = 'UPDATE advs SET end = (end + :time) WHERE serial = :serial';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':time', $time*60*60, PDO::PARAM_INT);
    $stmt->bindParam(':serial', $_GET['d']);
    $stmt->execute();
}

setcookie("time",time());

if ($_GET['c'] == 'na')
    newAd($conn);
if ($_GET['c'] == 'la')
    loadAds($conn);
if ($_GET['c'] == 'us')
    updSeen($conn);
if ($_GET['c'] == 'uptime')
    updTime($conn);    
if ($_GET['c'] == 'up')
    updateRow($conn);
if ($_GET['c'] == 'lx')
    loadMyAds($_SESSION['ads']);

?>
<?php


$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$form .= '<form method="POST" action="link.php"><label style="color:lightgray;">Enter your<br>Store contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input required id="email" type="email" name="email" placeholder="Manager Email"> <b style="color:red">*</b><br>';
$form .= '<input required id="password" type="password" name="password" placeholder="Store Password"> <b style="color:red">*</b><br>';
$form .= '<input required class="bizreq" id="addr" style="background:white" name="address" type="text" placeholder="St. No, Street, City, State, Zip, Country"> <b style="color:red">*</b><br>';
$form .= '<input required class="bizreq" id="ph" style="background:white" name="phone" type="text" placeholder="Phone Number"> <b style="color:red">*</b><br>';
$form .= '<input required id="biz" type="text" onkeypress=\'checkValue(this)\' name="business" placeholder="Business Name"> <b style="color:red">*</b><br>';
$form .= '<input required id="no" style="background:white" name="store_no" type="text" placeholder="Store Number"> <b style="color:red">*</b><br>';
$form .= '<input id="store_email" style="background:white" name="store_email" type="email" placeholder="Store Email"><br>';
$form .= '<button onclick="submit">List My Store!</button><br>';
$form .= '</form></div>';

$f = str_replace('"','\'',$form);
echo json_encode($f);
?>
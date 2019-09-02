<?php


    
// Sidebar for Linking Stores (For window)
$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$form .= '<form method="POST" action="link.php"><label style="color:lightgray;">Enter your<br>Store contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input required id="manager" type="text" name="manager" placeholder="Manager Name" value="' . $_COOKIE['myname'] . '"> <b style="color:red">*</b><br>';
$form .= '<input required id="email" type="email" name="email" placeholder="Manager Email" value="' . $_COOKIE['myemail'] . '"> <b style="color:red">*</b><br>';
$form .= '<input required id="password" type="password" name="password" placeholder="Store Password"> <b style="color:red">*</b><br>';
$form .= '<input required id="addr" style="background:white" name="address" type="text" placeholder="St. No, Street, City, State, Zip, Country"> <b style="color:red">*</b><br>';
$form .= '<input required id="ph" style="background:white" name="phone" type="text" placeholder="Phone Number"> <b style="color:red">*</b><br>';
$form .= '<input required id="biz" type="text" name="business" placeholder="Business Name"> <b style="color:red">*</b><br>';
$form .= '<input required id="no" style="background:white" name="store_no" type="text" placeholder="Store Number"> <b style="color:red">*</b><br>';
$form .= '<input required id="city" style="background:white" name="city" type="text" placeholder="City"> <b style="color:red">*</b><br>';
$form .= '<input required id="state" style="background:white" name="state" type="text" placeholder="State"> <b style="color:red">*</b><br>';
$form .= '<input id="store_email" style="background:white" name="store_email" type="email" placeholder="Store Email (opt.)"><br>';
$form .= '<button>List My Store!</button><br>';
$form .= '</form></div>';

echo $form;
?>
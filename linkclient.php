<?php


    
// Sidebar for Linking Stores (For window)
$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$form .= '<form method="POST" action="link.php"><label style="color:lightgray;">Enter your<br>Store contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input id="manager" type="text" name="manager" placeholder="Manager Name" value="' . $_COOKIE['myname'] . '"> <b style="color:red">*</b><br>';
$form .= '<input id="email" type="email" name="email" placeholder="Manager Email" value="' . $_COOKIE['myemail'] . '"> <b style="color:red">*</b><br>';
$form .= '<input id="password" type="password" name="password" placeholder="Store Password"> <b style="color:red">*</b><br>';
$form .= '<input id="addr" style="background:white" name="address" type="text" placeholder="St. No, Street, City, State, Zip, Country"> <b style="color:red">*</b><br>';
$form .= '<input id="ph" style="background:white" name="phone" type="text" placeholder="Phone Number"> <b style="color:red">*</b><br>';
$form .= '<input id="biz" type="text" name="business" placeholder="Business Name"> <b style="color:red">*</b><br>';
$form .= '<input id="no" style="background:white" name="store_no" type="text" placeholder="Store Number"> <b style="color:red">*</b><br>';
$form .= '<input id="city" style="background:white" name="city" type="text" placeholder="City"> <b style="color:red">*</b><br>';
$form .= '<input id="state" style="background:white" name="state" type="text" placeholder="State"> <b style="color:red">*</b><br>';
$form .= '<input id="store_email" style="background:white" name="store_email" type="email" placeholder="Store Email (opt.)"><br>';
$form .= '<button>List My Store!</button></form>';
$form .= '<font style="font-size:11px">Enter upto 5 keywords to be found in search:</font><br>';
$form .= '<div id="keywrds" style="display:table;width:255px;border-radius:10px;background:white"><input id="insWrd" onkeypress="keywordLookup(this,event.keyCode);" style="display:table-cell;width:40px;color:black;border-radius:10px;border:0px solid white;"></div>';
$form .= '<div id="div-keys"></div>';
$form .= '</div>';

echo $form;
?>
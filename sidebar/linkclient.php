<?php
   
// Sidebar for Linking Stores (For window)
$form = '<h3 onclick=menuList(\'sidebar/menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
//$form .= '<form name="newClient" method="POST" action="stores/link.php">
$form .= '<label style="color:lightgray;">Enter your<br>Store contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input class="business-form" id="manager" type="text" name="manager" placeholder="Manager Name" value="' . $_COOKIE['myname'] . '"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="email" type="email" name="email" placeholder="Manager Email" value="' . $_COOKIE['myemail'] . '"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="password" type="password" name="password" placeholder="Store Password"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="addr" style="background:white" name="address" type="text" placeholder="Address"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="ph" style="background:white" name="phone" type="text" placeholder="Phone Number"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="biz" type="text" name="business" placeholder="Business Name"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="no" style="background:white" name="store_no" type="text" placeholder="Store Number"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="city" style="background:white" name="city" type="text" placeholder="City"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="state" style="background:white" name="state" type="text" placeholder="State"> <b style="color:red">*</b><br>';
$form .= '<input class="business-form" id="zip" style="background:white" name="zip" type="text" placeholder="Zip Code"> <b style="color:red">*</b><br>';
$form .= '<font style="font-size:11px">Enter up to 5 keywords to be found in search:</font>';
$form .= '<div id="keywrds" style="display:table;width:255px;border-radius:10px;background:white">';
$form .= '<input id="insWrd" onfocus="this.style.border=0px;" onkeyup="keywordLookup(this,event.keyCode);" style="display:table-cell;width:90%;color:black;border-radius:10px;border:0px;"></div>';
$form .= '<div id="div-keys" style="display:table;width:75%"></div>';
$form .= '<button onclick="getForm()">List My Store!</button></form>';
$form .= '</div>';

echo $form;
?>
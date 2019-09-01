<?php

setcookie("time",time());

$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$form .= '<form method="POST" action="toads.php"><label style="color:lightgray;">Enter your<br>Store contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input required id="password" type="password" name="password" placeholder="Store Password"> <b style="color:red">*</b><br>';
$form .= '<input required id="slogan" style="background:white" name="slogan" type="text" placeholder="Slogan"> <b style="color:red">*</b><br>';
$form .= '<textarea id="description" style="background:white" name="description" type="text" placeholder="Text in ad; No necessary with YouTube URLs"><br>';
$form .= '<input id="img" style="background:white" name="img" type="text" placeholder="URL of Image File"><br>';
$form .= '<input id="url" style="background:white" name="url" type="text" placeholder="YouTube URL"><br>';
$form .= '<input required id="zip_code" style="background:white" name="zip" type="text" placeholder="Zip Code"> <b style="color:red">*</b><br>';
$form .= '<input id="nums" style="background:white" name="nums" type="text" placeholder="Store Numbers (1,2,..)"> <b style="color:red">*</b><br>';
$form .= '<button>List My Store!</button><br>';
$form .= '</form></div>';

echo $form;
?>
<?php

// Sidebar for new user additions
$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li>';
$form .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$form .= '<form method="POST" action="marker.php"><label style="color:lightgray;">Enter your<br>Direct contact<br>information ';
$form .= '<i style="color:red">required</i> <b style="color:red">*</b> : </label><br>';
$form .= '<input required id="email" type="email" name="email" placeholder="Email"> <b style="color:red">*</b><br>';
$form .= '<input required id="name" type="text" name="name" placeholder="Contact Person"> <b style="color:red">*</b><br>';
$form .= '<input required id="alias" type="text" name="alias" placeholder="Alias for Chat"> <b style="color:red">*</b><br>';
$form .= '<input required id="phone" type="phone" name="phone" placeholder="Phone Number"> <b style="color:red">*</b><br>';
$form .= '<input required id="password" type="password" name="password" placeholder="Password"> <b style="color:red">*</b><br>';
$form .= '<button onclick="submit">Welcome!</button><br>';
$form .= '</form></div>';

//$f = str_replace('"','\'',$form);
//echo json_encode($f);
echo $form;
?>
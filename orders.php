<?php

$chat = "<h3 onclick=menuList('menu.php')>Menu</h3>";
$chat .= '<li><b style=\'font-size:18px;color:lightgray\' onclick=\'javascript:mapView()\'>Click to Toggle Map</b></li>';
$chat .= '<table style=\'border:1px solid black;padding:3px;spacing:0px;width:250px;height:300px\'>';
$chat .= '<tr><td><b style=\'font-size:15px;color:red\'></b>Orders : : <br><i style=\'font-size:10px;\'>See who\'s coming in!</i></td>';
$chat .= '<td><button onclick=\'clearChat();\' style=\'vertical-alignment:bottom;border-radius:50%;color:green\'>&check;</button></td></tr>';
$chat .= '<tr><td colspan=2 style=\'background:black;border:0px;height:300px;width:250px\'>';
$chat .= '<div id=\'in-window\' style=\'border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:300px;width:250px\'>';
$chat .= '&nbsp;</div></td></tr><tr><td colspan=2 style=\'text-align:center;background:black;\'>';
$chat .= '<form method=\'POST\' action=\'msg.php\'>';
$chat .= '<input style=\'background-color:green;\' name=\'listen\' type=\'radio\'> Got it! ';
$chat .= '<input style=\'color:white;background-color:red;\' name=\'listen\' type=\'radio\'> Waiting...<br>';
$chat .= '<select><option value="ignore">User Queue</option></select> <input style=\'background-color:blue;color:white;noshadow:true\' type=\'checkbox\'> Busy -- ';
$chat .= '<button style=\'font-size:14px;background-color:blue;color:white;border-radius:50%\'>:)</button>';
$chat .= '</form></td></tr></table>';

$g = str_replace('"',"\'",$chat);
echo json_encode($chat);

?>
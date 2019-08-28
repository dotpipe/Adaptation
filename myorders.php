<?php

$chat = "<h3 onclick=menuList('menu.php')>Menu</h3>";
$chat .= '<li><b style=\'font-size:18px;color:lightgray\' onclick=\'javascript:mapView()\'>Click to Toggle Map</b></li>';
$chat .= '<table style=\'border:1px solid black;padding:3px;spacing:0px;width:250px;height:300px\'>';
$chat .= '<tr><td><b style=\'font-size:15px;color:red\'>Welcome to your Inbox!</b> : : <br><i style=\'font-size:10px;\'>Read who\'s coming in!</i></td>';
$chat .= '<td><button onclick=\'clearChat();\' style=\'vertical-alignment:bottom;border-radius:50%;color:green\'>&check;</button></td></tr>';
$chat .= '<tr><td colspan=2 style=\'background:black;border:0px;height:300px;width:250px\'>';
$chat .= '<div id=\'chatpane\' style=\'border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;height:300px;width:250px\'>';
$chat .= '<br><br><br><br><br><center><a onclick=getInbox(\'p\')>Click here to open Inbox</a></div></td></tr></table>';
$chat .= '<div style="font-size:12px;color:lightgray">Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/"         title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"         title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>';

$g = str_replace('"',"\'",$chat);
//echo json_encode($chat);
echo $chat;
?>
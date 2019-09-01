<?php
    
$chat = "<h3 onclick=menuList('menu.php')>Menu</h3>";
$chat .= '<li><b style=\'font-size:18px;color:lightgray\' onclick=\'javascript:mapView()\'>Click to Toggle Map</b></li>';
$chat .= '<table style=\'border:1px solid black;padding:3px;spacing:0px;width:250px;height:300px\'>';
$chat .= '<tr><td><b style=\'font-size:15px;color:red\'>Welcome to AdSheet!</b> : : <br><i style=\'font-size:10px;\'>Read who\'s coming in!</i></td>';
$chat .= '<td><button onclick=\'clearChat();\' style=\'vertical-alignment:bottom;border-radius:50%;color:green\'>&check;</button></td></tr>';
$chat .= '<tr><td colspan=2 style=\'background:black;border:0px;height:300px;width:250px\'>';
$chat .= '<div id=\'chatpane\' style=\'border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;height:300px;width:250px\'>';
$chat .= '<br><br><br><br><br><center><a onclick="getAdSheet(\'lx\')">Start AdSheet</a></center>';
$chat .= '</div></td></tr></table>';

echo $chat;

?>

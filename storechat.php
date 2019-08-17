
<?php

$chat = '<div id="startchat" loaded="0" onmouseover=startChat()><h3 style="color:wine" onclick=menuList("menu.php");>Menu</h3>';
$chat .= '<li><b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">Click to Toggle Map</b></li>';
$chat .= '<table style="border:1px solid black;padding:3px;spacing:0px;width:250px;height:350px">';
$chat .= '<tr><td><b style="font-size:15px;color:red">Cheri with ' . $_COOKIE["contact_alias"] . '</b> : : </td>';
$chat .= '<td><button onclick=\'clearChat();\' style="border-radius:50%;color:green">&check;</button></td></tr>';
$chat .= '<tr><td colspan=2 style="background:black;border:0px;height:350px;width:250px"><div id="chatwindow" style="border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:350px;width:250px">';
$chat .= '&nbsp;</div></td></tr><tr><td colspan=2 style="background:black;"><div id="texter" style="background:black;height:30px;width:250px">';
$chat .= '<input spellcheck="true" onkeypress=\'goChat(this,event.keyCode)\' style="font-size:24px;border:2px solid darkblue;width:250px;" type="text"></div></td></tr></table>';
$chat .= '</div>';
$g = str_replace("\"",'\'',$chat);
echo json_encode($g);
?> 
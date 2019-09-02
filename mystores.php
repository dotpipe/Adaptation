<?php

    
// Sidebar for Stores (For window)
$form = "<h3 onclick=menuList('menu.php')>Menu</h3>";
$form .= '<li><b style=\'font-size:18px;color:lightgray\' onclick=\'javascript:mapView()\'>Click to Toggle Map</b></li>';
$form .= '<table style=\'border:1px solid black;padding:3px;spacing:0px;width:250px;height:300px\'>';
$form .= '<tr><td><b style=\'font-size:15px;color:red\'>Your Linked Stores</b> : : <br><i style=\'font-size:10px;\'>Read who\'s coming in!</i></td></tr>';
$form .= '<tr><td colspan=2 style=\'background:black;border:0px;height:300px;width:250px\'>';
$form .= '<div id=\'storepane\' style=\'border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;height:300px;width:250px\'>';
$form .= '<br><br><br><br><br><center><a onclick="getStores(\'m\')">Click here to view Stores</a></div></td></tr></table>';
$form .= '<div style="font-size:12px;color:lightgray">Icons made by <a href="https://www.flaticon.com/authors/smashicons" title="Smashicons">Smashicons</a> from <a href="https://www.flaticon.com/"         title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"         title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>';

$g = str_replace('"',"\'",$form);
//echo json_encode($form);
echo $form;
?>
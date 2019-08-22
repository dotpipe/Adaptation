<?php

$form = "<h3 onclick=menuList('menu.php');>Menu</h3><li><b style='font-size:18px;color:lightgray;' onclick=javascript:mapView()>Click to Toggle Map</b><br><br>";
$form .= '<font style=\'font-size:16;color:red;\'>Preorder Items ' . $_COOKIE['store'] . '</font><br>';

//$form .= '<form id="preform" method="POST" action="preorderxml.php">';
$form .= '<div id=\'preorders\'>';
$form .= '<div class=\'inclusions\'>';
$form .= '<input required type=\'text\' class=\'item\' placeholder=\'Item name\'>';
$form .= '<font style=\'font-size:12px\'> Qu: </font><input type=\'number\' class=\'quantity\' style=\'display:table-cell;width:24px;\' value=1 min=1 required>';
$form .= '&nbsp;<button style=\'background:red;color:black;border-radius:50%;font-size:18px;border:2px solid white;\' onclick=\'removeItem(this)\'>&times;</button>';
$form .= '</div></div>';
$form .= '<div style=\'width:100%;display:table\'>';
$form .= '<div style=\'width:50%;display:table-cell;text-align:left;margin-left:20px;\'><button style=\'color:white;border:2px solid white;background:blue;border-radius:50%;font-size:18px\' onclick=\'addNewItem()\'>+</button></div>';
$form .= '<div style=\'width:50%;display:table-cell;text-align:right;margin-right:20px\'><button style=\'background:black;color:green;border-radius:50%;font-size:18px;border:2px solid white;\' onclick=\'makePreorder()\'>&check;</button></div>';
$form .= '</div>';
//$form .= '</form>';

$g = str_replace("\'",'"',$form);
echo json_encode($form);

?>
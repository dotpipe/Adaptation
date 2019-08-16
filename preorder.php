<?php
if (!isset($_COOKIE['stores']))
    setcookie("stores", "from stores!");
$form = '<h3 onclick=menuList(\'menu.php\');>Menu</h3><li><b style="font-size:18px;color:lightgray;" onclick=javascript:mapView()>Click to Toggle Map</b><br><br>';
$form .= '<font style=\'font-size:16;color:red;\'>Preorder Items ' . $_COOKIE['stores'] . '</font><br>';
$form .= '<div id=\'preorders\'><div>';
$form .= '<div style="display:table-cell"><input required type=\'text\' class=\'item\' placeholder=\'Item name\'>';
$form .= '<font style="font-size:12px"> Qu: </font><input type=\'number\' class=\'quantity\' style=\'width:24px;\' value=1 min=1 required>';
$form .= '&nbsp;<button style="background:black;border-radius:50%;font-size:18px" onclick=\'removeItem(this)\'>&times;</button><br></div>';
$form .= '</div></div>';
$form .= '<div style="margin-left:200px;display:table-cell;text-align:right"><button style="background:black;border-radius:50%;font-size:18px" onclick=\'addNewItem()\'>+</button></div>';
$form .= '<div style="margin-left:300px;display:table-cell;text-align:right"><button style="background:black;color:green;border-radius:50%;font-size:18px" onclick=\'makePreorder()\'>&check;</button></div>';

echo json_encode($form);

?>
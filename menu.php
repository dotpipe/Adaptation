<?php
$id = session_id();
$menu = "";

    
// Sidebar for Menu options
setcookie("time",time());

	if (isset($_COOKIE) && isset($_COOKIE['login']) && $_COOKIE['login'] == "true") {
		$menu = '<h3 onclick=menuList(\'menu.php\')>Menu</h3><li>';
		$menu .= '<b style="font-size:18px;color:lightgray" onclick=mapView()>';
		$menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'linkclient.php\');>Link Account!</ul>';
		$menu .= '<ul onclick=menuList(\'storechat.php\');>Cheri</ul>';
		$menu .= '<ul onclick=menuList(\'preorder.php\');>Preorder</ul>';
		$menu .= '<ul onclick=menuList(\'inbox.php\');>Inbox</ul>';
		$menu .= '<ul onclick=menuList(\'myorders.php\');>My Orders</ul>';
		if (isset($_COOKIE) && $_COOKIE['store_cnt'] > 0) {
			$menu .= '<ul onclick="menuList(\'mystores.php\');">My Stores</ul>';
		    $menu .= '<ul onclick="menuList(\'adsheet.php\');">My Ads</ul>';
		}
		$menu .= '<ul><a href=\'nologin.php\' style=\'color:white;text-decoration:none;font-size:18px;\'>Logout</a></ul>';
		$menu .= '<ul>Logged in as ' . $_COOKIE['myemail'] . '</ul></li>';
	}
	else {
		$menu = '<h3 onclick="menuList(\'menu.php\');">Menu</h3><li>';
		$menu .= '<b style="font-size:18px;color:lightgray" onclick=mapView()>';
		$menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'newclient.php\');>Create Account!</ul>';
		$menu .= '<ul onclick=menuList(\'login.php\');>Login</ul></li>';
	}
$f = str_replace("\'",'"',$menu);
//echo json_encode($f);
echo $menu;
?>
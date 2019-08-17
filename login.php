<?php

$form = "<h3 onclick=menuList('menu.php');>Menu</h3><li>";
$form .= "<b style=\"font-size:18px;color:lightgray\" onclick=\"javascript:mapView()\">Click to Toggle Map</b></li>";
$form .= "<label style=\"color:lightgray;\">Enter your<br>Login Details ";
$form .= "<i style=\"color:red\">required</i> <b style=\"color:red\">*</b> : </label><br>";
$form .= "<div><form method=\"POST\" action=\"verify.php\">";
$form .= "<input required id=\"email\" type=\"email\" autocomplete=\"username\" name=\"email\" placeholder=\"Email\"> <b style=\"color:red\">*</b><br>";
$form .= "<input required autocomplete=\"current-password\" id=\"password\" type=\"password\" name=\"password\" placeholder=\"Password\"> <b style=\"color:red\">*</b><br>";
$form .= "<input id=\"remember\" type=\"checkbox\" name=\"remember\"> Remember Me<br>";
$form .= "<button>Welcome!</button><br>";
$form .= "</form></div>";

if (isset($_COOKIE) && isset($_COOKIE['count']) && $_COOKIE['count'] == 3) {
    $form = "Locked out for " . ($_COOKIE['lock'] - time()) . " hours due to login tries exceeded.";
}
$f = str_replace("\"","'",$form);
echo json_encode($f);
?>
	<?php
	header("X-Content-Type-Options: nosniff");
	header("Content-Type: text/html");
	session_start();
	
	//if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') 
	  //  header("Location: https://www.diads.co/");
	
	$Storename[] = "Sal's Party Store";
	$Storename[] = "Hal's Example Store";
	$Storename[] = "Hale-Bopp Comedty Shop Examples";
	
	$Storeslogan[] = "Next to the Chicken House!";
	$Storeslogan[] = "Behind the Chicken House!";
	$Storeslogan[] = "Behind the Moon!";
	
	// array_merge_recursive()
	
	$serial[0][0] = "134123";
	$serial[0][1] = "1342";
	$serial[0][2] = "13413";
	$serial[0][3] = "34123";
	$serial[0][4] = "13412";
	$serial[0][5] = "1343";
	$serial[1][0] = "13123";
	$serial[1][1] = "13423";
	$serial[2][0] = "14123";
	
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>
	Diads - Follow your Best Deals
	</title>
	<style>
	  div #policy-terms {
	    top:70px;
	    position: absolute;
	    float:left;
	    margin-left:575px;
	    text-decoration:underline;
	    width:900px;
	    color:#fefefe;
	    z-index: 1 !important;
	  }
	  div #menu {
	    top:110px;
	    position: fixed;
	    width:350px;
	    z-index: 1 !important;
	  }
	  #map {
	    top:95px;
	    background:url('blacksand.jpg');
	    position:relative;
	    height: 80%;
	    width: 100%;
	  }
	  html, body {
	    height: 100%;
	    margin: 0px;
	    padding: 0px;
	  }
	  // This container element gives us the scrollbars we want.
	div.horizontal {
	    width: 410px;
	    height: 120px;
	    overflow: auto;
	}
	
	@import "reset.css";
	
	/* Scroll bar */
	/* width */
	::-webkit-scrollbar {
	  display: none;
	  width: 10px;
	  background: black;
	}
	
	/* Track */
	::-webkit-scrollbar-track {
	  display: none;
	  width: 10px;
	  background: darkgray; 
	}
	
	/* Handle */
	::-webkit-scrollbar-thumb {
	  display:none;
	  background: #888; 
	}
	
	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	  width: 10px;
	  background: #555; 
	}
	
	@import url(http://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed:300);
	* {
	  -webkit-box-sizing: border-box;
	  -moz-box-sizing: border-box;
	  box-sizing: border-box;
	}
	div.horizontal-mobi {
	  display: block;
	  width: 750px;
	  height: 75%;
	  overflow: auto;
	}
	div.horizontal-mobi .table-mobi {
	  display: table;
	  table-layout: static;
	  width: 750px;
	}
	div.horizontal-mobi .table-mobi article {
	  width: 750px;
	  height: 325px;
	  display: table-cell;
	  background: gray;
	  vertical-align: middle;
	  text-align: center;
	}
	
	div.horizontal-mobi .table-mobi dd {
	  width: 100%;
	  height: 100%;
	  display: table-cell;
	  vertical-align: middle;
	  text-align: center;
	  margin-left:0px;
	}
	
	body {
	  font-family: 'Open Sans', Helvetica, Arial, sans-serif;
	  font-size: 18px;
	  line-height: 24px;
	}
	h1,
	h2,
	h3,
	h4 {
	  font-family: 'Open Sans Condensed', Helvetica, Arial, sans-serif;
	}
	h1 {
	  font-size: 54px;
	}
	h2 {
	  font-size: 36px;
	  line-height: 48px;
	}
	header#pageheader {
	  line-height: 96px;
	  padding-left: 24px;
	}
	.horizontal-track2 {
	  width: 750px;
	  height: 17px;
	  background: #b4b4b4;
	}
	.horizontal-handle2 {
	  height: 17px;
	  background: #555;
	}
	.horizontal .left {
	  display: hidden;
	}
	.horizontal .right {
	  display: hidden;
	}
	
	#myProgress {
	  z-index:3;
	  width: 100%;
	  background-color: grey;
	}
	
	#myBar {
	  height: 10px;
	  width: 1%;
	  background-color: blue;
	}
	
	</style>
	
	<script>
	
	function move() {
	  var elem = document.getElementById("myBar"); 
	  var width = 1;
	  var id = setInterval(frame, 10);
	  function frame() {
	    if (width >= 100) {
	      clearInterval(id);
	      document.getElementById("myProgress").style.display = "none";
	    } else {
	      width++; 
	      elem.style.width = width + '%'; 
	    }
	  }
	  menuList('menu.php');
	}
	
	function mapView() {
	    var p = document.getElementById("page");
	    var t = document.getElementById("map");
	    var f = document.getElementById("following");
	    if (p.index != "-1") {
	      f.style.top = t.style.height + "px";
	      f.style.index = "-1";
	      f.style.style = "margin-top:95px;width:100%;z-index:-1;background:url('blacksand.jpg');position:static;";
	      p.index = "-1";
	      t.parentNode.style = "z-index:-1;overflow:none;position:fixed;width:100%;";
	      t.style.height = (screen.height - 95) + "px";
	    }
	    else {
	      f.style.index = "-1";
	      f.style.style = "margin-top:95px;width:100%;z-index:1;background:url('blacksand.jpg');position:static;";
	      p.index = "1";
	      t.parentNode.style = "z-index:1;overflow:none;position:fixed;width:100%;";
	      t.style.height = (screen.height - 95) + "px";
	    }
	  }
	
	  function menuslide() {
	    if (document.getElementById('menu').style.display == "table-cell") {
	      document.getElementById('menu').style.display = "none";
	      document.getElementById('page').style.left = "0px";
	      document.getElementById('following').style.left = "0px";
	    }
	    else {
	      document.getElementById('menu').style.display = "table-cell";
	      document.getElementById('page').style.left = "305px";
	      document.getElementById('following').style.left = "295px";
	    }
	  }
	
	</script>
	<script src="gmaps.js"></script>
	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6nPPAMCGMzGcTS-HOkT1FXCJ3AqwV2V4&libraries=places&callback=honey"
	  async defer></script>
	  <meta content="Diads is your best place to advertise. Get Followers, Preordering, Reviews from customers and much more." name="description">
	</head>
	
	<body style="background:url('blacksand.jpg');" onload="move();" onunload="">
	<!-- Loading Progress bar -->
	<div id="myProgress" style="position:fixed">
	  <div id="myBar"></div>
	</div>
	
	<!-- Create button for menu open and close -->
	<div id="fb-root"></div>
	<section style="background:url('blacksand.jpg');z-index:2;position:fixed;">
	<div style="background:url('blacksand.jpg');text-align:center;text-align:left;width:100%;margin-left:-1px;margin-top:-8px;height:105px;position:fixed;">
	<div onclick="javascript:menuslide();" style="cursor:pointer;text-align:center;position:fixed;width:65px;">
	<br>
		<hr style="border-radius: 100px;margin-left:10px;text-align:center;height:5px;background:gray;">
		<hr style="border-radius: 100px;margin-left:10px;text-align:center;height:5px;background:gray;">
		<hr style="border-radius: 100px;margin-left:10px;text-align:center;height:5px;background:gray;">
		<hr style="border-radius: 100px;margin-left:10px;text-align:center;height:5px;background:gray;">
	</div>
	
	<div class="horizontal-mobi" style="cursor:default;width:100%;margin-left:75px;height:105px;margin-top:20px;position:fixed;">
	<br>
	<div style="position:fixed;display:table-cell;font-size:28px;color:#fefefe">Welcome to Diads!</div>
	<div id="policy-terms" style="vertical-alignment:middle;position:fixed;left:500px;display:table-cell;"><a style="color:#fefefe" href="privacy_policy.pdf">Privacy Policy</a> and <a style="color:#fefefe" href="terms.pdf">Terms</a></div>
	</div>
	</div>
	</section>
	<?php
	$menu = "";
	if (isset($_COOKIE) && isset($_COOKIE['login']) && $_COOKIE['login'] == "true") {
	  $menu = '<h3 onclick="menuList(\'menu.php\');">Menu</h3><li>';
	  $menu .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">';
	  $menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'linkclient.php\');>Link Account!</ul>';
	  $menu .= '<ul onclick=menuList(\'storechat.php\');>Cheri</ul>';
	  $menu .= '<ul onclick="menuList(\'preorder.php\');">Preorder</ul>';
	  $menu .= '<ul onclick="menuList(\'inbox.php\');">Inbox</ul>';
	  $menu .= '<ul><a href="nologin.php" style="color:white;text-decoration:none;font-size:18px;">Logout</a></ul></li>';
	}
	else {
	  $menu = '<h3 onclick="menuList(\'menu.php\');">Menu</h3><li>';
	  $menu .= '<b style="font-size:18px;color:lightgray" onclick="javascript:mapView()">';
	  $menu .= 'Click to Toggle Map</b><ul onclick=menuList(\'newclient.php\');>Create Account!</ul>';
	  $menu .= '<ul onclick=menuList(\'login.php\');>Login</ul></li>';
	}
	?>
	<!-- Side menu -->
	<section id="menu" style="display:none">
	  <div style="background:black;width:300px;margin-top:95px;height:100%;z-index:4;position:fixed">
	    <div>
	      <article id="menu-article" style="margin-left:15px;color:white">
	        <?php echo $menu; ?>
	      </article>
	    </div>
	  </div>
	</section>
	
	<section id="page" style="background:url('blacksand.jpg');width:100%">
		<div class="horizontal-mobi">
			<div class="table-mobi" style="width:100%;">
				<dd>
					<div id="map" style="position:relative;z-index:1"></div>
				</dd>
			</div>
		</div>
	</section>
	
	<section id="following" style="background:url('blacksand.jpg');margin-top:95px">
	
	<?php for ($j = 0 ; $j < count($Storename) ; $j++) { ?>
	
	    <div class="horizontal-mobi" style="width:100%;background:opacity(0);">
	
	     <div class="table-mobi" style="position:static;">
	
	<?php for ($i = 0 ; $i < count($serial[$j]) ; $i++) { ?>
	    <article serial="<?=$serial[$j][$i]?>" class="card" style="margin-left:<?=($i)*750?>px;background:opacity(0);width:750px;border-radius: 10px;border: 5px solid lightgray;">
	        <b><i><?=$Storename[$j]?></i></b>
	        <hr style="height:1px;width:750px">
	        <b><?=$Storeslogan[$j]?></b><br>
	        &#11088;&#11088;&#11088;&#11088;&#127775;<br>
	        <b style="z-index:2;"><i>Review Now! !</i>
	        <?php for ($k = 0 ; $k < 5 ; $k++) { ?>
	          <c class="star" onclick="javascript:confirm_star((<?=$k?>+1),<?=$serial[$j][$i]?>)">&#9734;</c>
	        <?php } ?>
	        </b>
	    </article>
	<?php } ?>
	
	  </div>
	  </div>
	
	<?php 
	}
	?>
	</section>
	</body>
	</html>

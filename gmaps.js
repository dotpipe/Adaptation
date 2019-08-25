<<<<<<< HEAD

dojo.provide("XslTransform");

dojo.declare("XslTransform", [],
{
	_xslDoc : null,
	_xslPath : null,

	constructor : function(xslPath) {
		this._xslPath = xslPath;
	},

	transform : function(xmlPath) {
		if (this._xslDoc === null)
			this._xslDoc = this._loadXML(this._xslPath);

		var result = null;
		var xmlDoc = this._loadXML(xmlPath);

		if (dojo.isIE) {
			result = xmlDoc.transformNode(this._xslDoc);
		} else if(typeof XSLTProcessor !== undefined) {
			xsltProcessor = new XSLTProcessor();
	  		xsltProcessor.importStylesheet(this._xslDoc);

	  		var ownerDocument = document.implementation.createDocument("", "", null);
	  		result = xsltProcessor.transformToFragment(xmlDoc, ownerDocument);
		} else {
			alert("Your browser doesn't support XSLT!");
		}

		return result;

	},

	createXMLDocument : function(xmlText) {
		var xmlDoc = null;

		if (dojo.isIE) {
			xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async = false;
			xmlDoc.loadXML(xmlText);
		} else if (window.DOMParser) {
			parser = new DOMParser();
			xmlDoc = parser.parseFromString(xmlText, "text/xml");
		} else {
			alert("Your browser doesn't suppoprt XML parsing!");
		}

		return xmlDoc;
	},

	// Synchronously loads a remote xml file
	_loadXML : function(xmlPath) {
		var getResult = dojo.xhrGet({
			url : xmlPath,
			handleAs : "xml",
			sync: true
		});

		var xml = null;
		// Returns immediately, because the GET is synchronous.
		var xmlData = getResult.then(function (response) {
			xml = response;
		});

		return xml;
	}
});


/////////////
var datarray = [];
var ADDR;
function callFile(str) {

  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", str, false);
  xhttp.send();
}

function listConvo() {
  callFile("chataliases.php?c=1");
  var alias = getCookie("aliases");
  alias = alias.substring(1,alias.length-1);
  console.log(alias);
  alias = alias.split(",");
  var x = document.getElementById("chatters");
  var h = 0;
  
  while (x.childElementCount > h++) {
    x.removeChild(x.firstChild);
  }
  x.options[0] = new Option("You have " + alias.length + " people to chat with!","");

  if (alias.length == 1) {
    x.options[1] = new Option(alias,alias);
  }
  else {
    for (var i = 0 ; i < alias.length ; i++)
      x.options[i+1] = new Option(alias[i].substr(1,alias[i].length-2),alias[i].substr(1,alias[i].length-2));
  }
  callPage();
}

function loginUnsuccessful() {
  var y = getCookie("count");
  y++;
  setCookie("count", y);
  document.getElementById("warning").value = "Wrong Email/Password (" + y + "/3)";
  menuList('login.php');
}

function logout() {
  
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      return;
    }
  };
  xhttp.open("GET", "nologin.php", true);
  xhttp.send();

  localStorage.clear();
}

function unload() {
  if (localStorage.getItem("remember") == false)
    logout();
}

function getOption() {
  var x = document.getElementById("chatters");
  var idx = x.options[x.selectedIndex];
  var str = idx.value;
  if (str[0] === '"')
    str = str.substr(1,str.length-2);
  if (str == "")
    return;
  setCookie("nodeNo", x.selectedIndex);
  setCookie("chataddr", str);
}

function callPage() {
  callFile("createchat.php");
  callFile("chataliases.php?c=2");
  var x = getCookie("chatfile");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      clearChat();
    }
  };
  xhttp.open("POST", "xml/" + x, false);
  xhttp.send();
  var s = xhttp.responseXML.firstChild;
  var xsltProcessor = new XSLTProcessor();
  xhttp = new XMLHttpRequest();
  xhttp.open("GET", "xml/chatxml.xsl", false);
  xhttp.send(null);
  console.log(s);  
  xsltProcessor.importStylesheet(s);
  
  myXMLHTTPRequest = new XMLHttpRequest();
  myXMLHTTPRequest.open("GET", "xml/" + x, false);
  myXMLHTTPRequest.send(null);
  
  xmlDoc = myXMLHTTPRequest.responseXML.firstChild;
  var xslTransform = new XslTransform("xml/chatxml.xsl");
  var outputText = xslTransform.transform("xml/" + x);
  document.getElementById("chatpane").innerHTML = ""; 
  document.getElementById("chatpane").append(outputText);
  var x = document.getElementById("in-window");
  x.scroll(0,x.childElementCount*20);
}

function getInbox(no, vthis) {
  if (vthis !== undefined) {
    menuList('orders.php');
    console.log(vthis);
    callFile("toorders.php?c=" + no + "&b=" + vthis);
  }
  else
    callFile("toorders.php?c=" + no);
  var x = getCookie("order");
  var y = getCookie("dir");
  var z = getCookie("file");
  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", x + y + z, false);
  xhttp.send();
  var s = xhttp.responseXML.firstChild;
  var xsltProcessor = new XSLTProcessor();
  xhttp = new XMLHttpRequest();
  xhttp.open("GET", x + "oxml.xsl", false);
  xhttp.send(null);
  console.log(s);  
  xsltProcessor.importStylesheet(s);
  
  myXMLHTTPRequest = new XMLHttpRequest();
  myXMLHTTPRequest.open("GET", x + y + z, false);
  myXMLHTTPRequest.send(null);
  
  xmlDoc = myXMLHTTPRequest.responseXML.firstChild;
  var xslTransform = new XslTransform(x + "oxml.xsl");
  var outputText = xslTransform.transform(x + y + z);
  document.getElementById("chatpane").innerHTML = "";
  document.getElementById("chatpane").append(outputText);
}

function goChat(i,j) {
  if (j == 13) {
    var y = i.cloneNode();
    i.value = "";
    console.log(y.value);
    
    callFile("chat.php?a=" + y.value);
    var x = document.getElementById("in-window");
    x.offsetTop = x.childElementCount*20;
    callPage();
    callFile("chataliases.php?c=1");
  }
}

function clearChat() {
  var x = document.getElementById("in-window");
  x.innerHTML = "";
  return;
}

function honey() {
  //glaze();
  navigator.geolocation.getCurrentPosition(collectXML);
}

function glaze(address) {
  if (address == "")
    return;
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': address }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      //map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
    }
  });
}

function collectXML (position) {
  var t = position.coords;
  var map = new google.maps.Map(
    document.getElementById('map'),
    {center: {lat: position.coords.latitude, lng: position.coords.longitude}, zoom: 13});

  var input;
  var autocomplete;
  //if (null != document.getElementById('addr')) {
    input = document.getElementById('addr');

    autocomplete = new google.maps.places.Autocomplete(input);

    // Specify just the place data fields that you need.
    autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);
  //}
  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  // Change this depending on the name of your PHP or XML file
  downloadUrl('branches.xml', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('links');
    Array.prototype.forEach.call(markers, function(markerElem) {
      var name = markerElem.getAttribute('manager');
      var no = markerElem.getAttribute('store_no');
      console.log("ae" + no);
      var address = markerElem.getAttribute('address');
      if (!address.includes(markerElem.getAttribute('city')))
        address = address + ", " + markerElem.getAttribute('city');
      if (!address.includes(markerElem.getAttribute('state')))
        address = address + ", " + markerElem.getAttribute('state');
      if (!address.includes(markerElem.getAttribute('zip')))
        address = address + ", " + markerElem.getAttribute('zip');
      if (!address.includes(markerElem.getAttribute('country')))
        address = address + ", " + markerElem.getAttribute('country');
      var biz = markerElem.getAttribute('business');
      var type = markerElem.getAttribute('type');
      var point = new google.maps.LatLng(
          parseFloat(markerElem.getAttribute('lat')),
          parseFloat(markerElem.getAttribute('long'))
          );

      var infowincontent = document.createElement('div');
      var strong = document.createElement('strong');
      strong.textContent = name
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement('br'));

      var text = document.createElement('text');
      text.textContent = address
      infowincontent.appendChild(text);
      geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          //map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
          });
          var x = encodeURI(biz);
          var y = encodeURI(no);
          marker.addListener('click', function() {
            
           var infowindow = new google.maps.InfoWindow({
              content: "<p onclick=focusStore(\"" + x + "\",\"" + y + "\");><u>" + name + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br><u>" + biz + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>"
  
            });
            infowindow.open(map, marker);
          });
        }
      });
      glaze(address);
    });
  });
}

function focusStore(name,no) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      
    }
  };

  request.open('GET', "getstore.php?a=" + name + "&b=" + no, true);
  request.send(null);
      menuList('menu.php');
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('POST', url, true);
  request.send(null);
}

function doNothing() {}


function passPOST(url) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
    }
  };
  request.open('GET', url, true);
  request.send(null);
}

var map;
var service;
var infowindow;

function mapView() {
  var p = document.getElementById("page");
  var t = document.getElementById("map");
  var f = document.getElementById("following");
  if (p.index != "-1") {
    f.style.top = t.style.height + "px";
    f.style.index = "-1";
    f.style.style = "margin-top:" + t.style.height + "px;width:100%;z-index:-1;background:url('blacksand.jpg');position:static;";
    p.index = "-1";

    //t.style = "position:relative;z-index:1;";
    t.parentNode.style = "z-index:-1;height:100%;overflow:none;position:fixed;width:100%;";
  }
  else {
    f.style.index = "-1";
    f.style.style = "margin-top:105px;width:100%;z-index:1;background:url('blacksand.jpg');position:static;";
    p.index = "1";
    //t.style = "position:relative;z-index:-2;";
    t.parentNode.style = "z-index:1;height:100%;overflow:none;position:fixed;width:100%;";
  }
  //t.style.height = (0.50 * screen.height) + "px";
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      createMarker(results[i]);
    }
  }
}

function createMarker(place) {
  var marker = new google.maps.Marker({
    map: map,
    name: place.name,
    placeId: place.place_id,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name);
    infowindow.open(map, this);
    });
}

function revitup(i,ts) {
    var rt = 0;
    var card = document.getElementsByTagName("article");
    for (let s = 0 ; s < card.length ; s++) {
        if (card[s].getAttribute("serial") == ts) {
    rt = s;
    break;
        }
    }
    
    var stars = card[rt].getElementsByTagName("c");

    for (let j = 0 ; j < 4 ; j++) {
        stars[j].innerHTML = "&#9734;";
    }

    for (let j = 0 ; j < i ; j++) {
        stars[j].innerHTML = "&#11088;";
    }
}

function review(i,ts) {
  var obj, s
  s = document.createElement("script");
  s.src = "star_rated.php?x=" + i + "&y=" + ts;
  document.body.appendChild(s);
}

function confirm_star(i,ts) {

  if (confirm("You chose " + i + " stars!")) {
    revitup(i,ts);
    review(i,ts);
  }

}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function countCookies() {
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  return ca.length;
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

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
}
//if (document.readyState === 'loading')

  function fixheight() {
    var t = document.getElementsByClassName("horizontal-mobi")[1];
        
    var h = t.childNodes[1];
    //if (h.style.height !== undefined)
    console.log(h);
  }

  function menuslide() {
    if (document.getElementById('menu').style.display == "table-cell") {
      document.getElementById('menu').style.display = "none";
      document.getElementById('page').style.left = "0px";
      document.getElementById('map').style.left = "0px";
    }
    else {
      document.getElementById('menu').style.display = "table-cell";
      document.getElementById('page').style.left = "305px";
      document.getElementById('map').style.left = "295px";
    }
  }

  function fillMenu(i) {
    document.getElementById("menu-article").innerHTML = i.substring(1,i.length-2);
  }
  
  function menuList(i) {
    fetch(i, function() {})
      .then(function(response){
      return response.json();
      })
      .then(function(j) {
        fillMenu(JSON.stringify(j));
      });
      if (i === "newclient.php")
        honey();
  }

//  function fillChat(i) {
  //  document.getElementById("chatpane").style.wordWrap = "true";

    //document.getElementById("chatpane").innerText = i.substring(1,i.length-2);
  //}
  
  function cheriWindow(i) {
    var url = 'fmcht.php?' + i;
    fetch(url, function() {})
      .then(function(response){
      return response.json();
      })
      .then(function(j) {
        fillChat(JSON.stringify(j));
      });
  }
  
  function addNewItem() {
    var h = document.getElementById("preorders");
    var p = h.firstChild.cloneNode(true);
    var x = h.childElementCount;
    h.append(p);
  }

  function removeItem() {
    var h = document.getElementById("preorders");
    if (h.length >= 2)
      h.removeChild(h.lastChild);
    
  }

  function makePreorder() {
    var g = document.getElementsByClassName("inclusions");
    var cnt = g.length;
    console.log(g);
    var z = [];
    var y = [];
    var c;
    for (j = 0; j < cnt ; j++) {
      c = g[j];
      var v = c.getElementsByTagName("input");
      
      z.unshift(v[0].value);
      y.unshift(v[1].value);
    }
    callFile("preorderxml.php?a=" + encodeURI(z) + "&b=" + encodeURI(y));
  }
=======

dojo.provide("XslTransform");

dojo.declare("XslTransform", [],
{
	_xslDoc : null,
	_xslPath : null,

	constructor : function(xslPath) {
		this._xslPath = xslPath;
	},

	transform : function(xmlPath) {
		if (this._xslDoc === null)
			this._xslDoc = this._loadXML(this._xslPath);

		var result = null;
		var xmlDoc = this._loadXML(xmlPath);

		if (dojo.isIE) {
			result = xmlDoc.transformNode(this._xslDoc);
		} else if(typeof XSLTProcessor !== undefined) {
			xsltProcessor = new XSLTProcessor();
	  		xsltProcessor.importStylesheet(this._xslDoc);

	  		var ownerDocument = document.implementation.createDocument("", "", null);
	  		result = xsltProcessor.transformToFragment(xmlDoc, ownerDocument);
		} else {
			alert("Your browser doesn't support XSLT!");
		}

		return result;

	},

	createXMLDocument : function(xmlText) {
		var xmlDoc = null;

		if (dojo.isIE) {
			xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
			xmlDoc.async = false;
			xmlDoc.loadXML(xmlText);
		} else if (window.DOMParser) {
			parser = new DOMParser();
			xmlDoc = parser.parseFromString(xmlText, "text/xml");
		} else {
			alert("Your browser doesn't suppoprt XML parsing!");
		}

		return xmlDoc;
	},

	// Synchronously loads a remote xml file
	_loadXML : function(xmlPath) {
		var getResult = dojo.xhrGet({
			url : xmlPath,
			handleAs : "xml",
			sync: true
		});

		var xml = null;
		// Returns immediately, because the GET is synchronous.
		var xmlData = getResult.then(function (response) {
			xml = response;
		});

		return xml;
	}
});


/////////////
var datarray = [];
var ADDR;
function callFile(str) {

  var xhttp = new XMLHttpRequest();
  xhttp.open("GET", str, false);
  xhttp.send();
}

function listConvo() {
  callFile("chataliases.php?c=1");
  var alias = getCookie("aliases");
  alias = alias.substring(1,alias.length-1);
  console.log(alias);
  alias = alias.split(",");
  var x = document.getElementById("chatters");
  var h = 0;
  
  while (x.childElementCount > h++) {
    x.removeChild(x.firstChild);
  }
  x.options[0] = new Option("You have " + alias.length + " people to chat with!","");

  if (alias.length == 1) {
    x.options[1] = new Option(alias,alias);
  }
  else {
    for (var i = 0 ; i < alias.length ; i++)
      x.options[i+1] = new Option(alias[i].substr(1,alias[i].length-2),alias[i].substr(1,alias[i].length-2));
  }
  callPage();
}

function loginUnsuccessful() {
  var y = getCookie("count");
  y++;
  setCookie("count", y);
  document.getElementById("warning").value = "Wrong Email/Password (" + y + "/3)";
  menuList('login.php');
}

function logout() {
  
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      return;
    }
  };
  xhttp.open("GET", "nologin.php", true);
  xhttp.send();

  localStorage.clear();
}

function unload() {
  if (localStorage.getItem("remember") == false)
    logout();
}

function getOption() {
  var x = document.getElementById("chatters");
  var idx = x.options[x.selectedIndex];
  var str = idx.value;
  if (str[0] === '"')
    str = str.substr(1,str.length-2);
  if (str == "")
    return;
  setCookie("nodeNo", x.selectedIndex);
  setCookie("chataddr", str);
}

function callPage() {
  callFile("createchat.php");
  callFile("chataliases.php?c=2");
  var x = getCookie("chatfile");
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      clearChat();
    }
  };
  xhttp.open("POST", "xml/" + x, false);
  xhttp.send();
  var s = xhttp.responseXML.firstChild;
  var xsltProcessor = new XSLTProcessor();
  xhttp = new XMLHttpRequest();
  xhttp.open("GET", "xml/chatxml.xsl", false);
  xhttp.send(null);
  console.log(s);  
  xsltProcessor.importStylesheet(s);
  
  myXMLHTTPRequest = new XMLHttpRequest();
  myXMLHTTPRequest.open("GET", "xml/" + x, false);
  myXMLHTTPRequest.send(null);
  
  xmlDoc = myXMLHTTPRequest.responseXML.firstChild;
  var xslTransform = new XslTransform("xml/chatxml.xsl");
  var outputText = xslTransform.transform("xml/" + x);
  document.getElementById("navpane").innerHTML = ""; 
  document.getElementById("navpane").append(outputText);
  var x = document.getElementById("in-window");
  x.scroll(0,x.childElementCount*20);
}

function goChat(i,j) {
  if (j == 13) {
    var y = i.cloneNode();
    i.value = "";
    console.log(y.value);
    
    callFile("chat.php?a=" + y.value);
    var x = document.getElementById("in-window");
    x.offsetTop = x.childElementCount*20;
    callPage();
    callFile("chataliases.php?c=1");
  }
}

function clearChat() {
  var x = document.getElementById("in-window");
  x.innerHTML = "";
  return;
}

function honey() {
  //glaze();
  navigator.geolocation.getCurrentPosition(collectXML);
}

function glaze(address) {
  if (address == "")
    return;
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': address }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      //map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        position: results[0].geometry.location
      });
    }
  });
}

function collectXML (position) {
  var t = position.coords;
  var map = new google.maps.Map(
    document.getElementById('map'),
    {center: {lat: position.coords.latitude, lng: position.coords.longitude}, zoom: 13});

  var input;
  var autocomplete;
  //if (null != document.getElementById('addr')) {
    input = document.getElementById('addr');

    autocomplete = new google.maps.places.Autocomplete(input);

    // Specify just the place data fields that you need.
    autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);
  //}
  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  // Change this depending on the name of your PHP or XML file
  downloadUrl('branches.xml', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('links');
    Array.prototype.forEach.call(markers, function(markerElem) {
      var name = markerElem.getAttribute('manager');
      var no = markerElem.getAttribute('store_no');
      console.log("ae" + no);
      var address = markerElem.getAttribute('address');
      if (!address.includes(markerElem.getAttribute('city')))
        address = address + ", " + markerElem.getAttribute('city');
      if (!address.includes(markerElem.getAttribute('state')))
        address = address + ", " + markerElem.getAttribute('state');
      if (!address.includes(markerElem.getAttribute('zip')))
        address = address + ", " + markerElem.getAttribute('zip');
      if (!address.includes(markerElem.getAttribute('country')))
        address = address + ", " + markerElem.getAttribute('country');
      var biz = markerElem.getAttribute('business');
      var type = markerElem.getAttribute('type');
      var point = new google.maps.LatLng(
          parseFloat(markerElem.getAttribute('lat')),
          parseFloat(markerElem.getAttribute('long'))
          );

      var infowincontent = document.createElement('div');
      var strong = document.createElement('strong');
      strong.textContent = name
      infowincontent.appendChild(strong);
      infowincontent.appendChild(document.createElement('br'));

      var text = document.createElement('text');
      text.textContent = address
      infowincontent.appendChild(text);
      geocoder = new google.maps.Geocoder();
      geocoder.geocode({ 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          //map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
          });
          var x = encodeURI(biz);
          var y = encodeURI(no);
          marker.addListener('click', function() {
            
           var infowindow = new google.maps.InfoWindow({
              content: "<p onclick=focusStore(\"" + x + "\",\"" + y + "\");><u>" + name + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br><u>" + biz + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br>"
  
            });
            infowindow.open(map, marker);
          });
        }
      });
      glaze(address);
    });
  });
}

function focusStore(name,no) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      
    }
  };

  request.open('GET', "getstore.php?a=" + name + "&b=" + no, true);
  request.send(null);
      menuList('menu.php');
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
      callback(request, request.status);
    }
  };

  request.open('POST', url, true);
  request.send(null);
}

function doNothing() {}


function passPOST(url) {
  var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      request.onreadystatechange = doNothing;
    }
  };
  request.open('GET', url, true);
  request.send(null);
}

var map;
var service;
var infowindow;

function mapView() {
  var p = document.getElementById("page");
  var t = document.getElementById("map");
  var f = document.getElementById("following");
  if (p.index != "-1") {
    f.style.top = t.style.height + "px";
    f.style.index = "-1";
    f.style.style = "margin-top:" + t.style.height + "px;width:100%;z-index:-1;background:url('blacksand.jpg');position:static;";
    p.index = "-1";

    //t.style = "position:relative;z-index:1;";
    t.parentNode.style = "z-index:-1;height:100%;overflow:none;position:fixed;width:100%;";
  }
  else {
    f.style.index = "-1";
    f.style.style = "margin-top:105px;width:100%;z-index:1;background:url('blacksand.jpg');position:static;";
    p.index = "1";
    //t.style = "position:relative;z-index:-2;";
    t.parentNode.style = "z-index:1;height:100%;overflow:none;position:fixed;width:100%;";
  }
  //t.style.height = (0.50 * screen.height) + "px";
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      createMarker(results[i]);
    }
  }
}

function createMarker(place) {
  var marker = new google.maps.Marker({
    map: map,
    name: place.name,
    placeId: place.place_id,
    position: place.geometry.location
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name);
    infowindow.open(map, this);
    });
}

function revitup(i,ts) {
    var rt = 0;
    var card = document.getElementsByTagName("article");
    for (let s = 0 ; s < card.length ; s++) {
        if (card[s].getAttribute("serial") == ts) {
    rt = s;
    break;
        }
    }
    
    var stars = card[rt].getElementsByTagName("c");

    for (let j = 0 ; j < 4 ; j++) {
        stars[j].innerHTML = "&#9734;";
    }

    for (let j = 0 ; j < i ; j++) {
        stars[j].innerHTML = "&#11088;";
    }
}

function review(i,ts) {
  var obj, s
  s = document.createElement("script");
  s.src = "star_rated.php?x=" + i + "&y=" + ts;
  document.body.appendChild(s);
}

function confirm_star(i,ts) {

  if (confirm("You chose " + i + " stars!")) {
    revitup(i,ts);
    review(i,ts);
  }

}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function countCookies() {
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  return ca.length;
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

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
}
//if (document.readyState === 'loading')

  function fixheight() {
    var t = document.getElementsByClassName("horizontal-mobi")[1];
        
    var h = t.childNodes[1];
    //if (h.style.height !== undefined)
    console.log(h);
  }

  function menuslide() {
    if (document.getElementById('menu').style.display == "table-cell") {
      document.getElementById('menu').style.display = "none";
      document.getElementById('page').style.left = "0px";
      document.getElementById('map').style.left = "0px";
    }
    else {
      document.getElementById('menu').style.display = "table-cell";
      document.getElementById('page').style.left = "305px";
      document.getElementById('map').style.left = "295px";
    }
  }

  function fillMenu(i) {
    document.getElementById("menu-article").innerHTML = i.substring(1,i.length-2);
  }
  
  function menuList(i) {
    fetch(i, function() {})
      .then(function(response){
      return response.json();
      })
      .then(function(j) {
        fillMenu(JSON.stringify(j));
      });
      if (i === "newclient.php")
        honey();
  }

//  function fillChat(i) {
  //  document.getElementById("navpane").style.wordWrap = "true";

    //document.getElementById("navpane").innerText = i.substring(1,i.length-2);
  //}
  
  function cheriWindow(i) {
    var url = 'fmcht.php?' + i;
    fetch(url, function() {})
      .then(function(response){
      return response.json();
      })
      .then(function(j) {
        fillChat(JSON.stringify(j));
      });
  }
  
  function addNewItem() {
    var h = document.getElementById("preorders");
    var p = h.firstChild.cloneNode(true);
    var x = h.childElementCount;
    h.append(p);
  }

  function removeItem() {
    var h = document.getElementById("preorders");
    if (h.length >= 2)
      h.removeChild(h.lastChild);
    
  }

  function makePreorder() {
    var g = document.getElementsByClassName("inclusions");
    var cnt = g.length;
    console.log(g);
    var z = [];
    var y = [];
    var c;
    for (j = 0; j < cnt ; j++) {
      c = g[j];
      var v = c.getElementsByTagName("input");
      
      z.unshift(v[0].value);
      y.unshift(v[1].value);
    }
    callFile("preorderxml.php?a=" + encodeURI(z) + "&b=" + encodeURI(y));
  }
  
  function callOrders(no) {
    callFile("toorders.php?c=" + no);
    
    var x = getCookie("order");
    var xslt = getCookie("dir");
    var fi = getCookie("file");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        clearChat();
      }
    };
    xhttp.open("GET", x + xslt + fi, false);
    xhttp.send();
    var s = xhttp.responseXML.firstChild;
    var xsltProcessor = new XSLTProcessor();
    xhttp = new XMLHttpRequest();
    xhttp.open("GET", x + "oxml.xsl", false);
    xhttp.send(null);
    console.log(s);  
    xsltProcessor.importStylesheet(s);
    
    myXMLHTTPRequest = new XMLHttpRequest();
    myXMLHTTPRequest.open("GET", x + xslt + fi, false);
    myXMLHTTPRequest.send(null);
    console.log(fi);
    xmlDoc = myXMLHTTPRequest.responseXML.firstChild;
    var xslTransform = new XslTransform(x + "oxml.xsl");
    var outputText = xslTransform.transform(x + xslt + fi);
    document.getElementById("navpane").innerHTML = "";
    document.getElementById("navpane").append(outputText);
    var x = document.getElementById("in-window");
    x.scroll(0,x.childElementCount*20);
  }
  
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5


var datarray = [];
var ADDR;

function csvToArray(text) {
  let p = '', row = [''], ret = [row], i = 0, r = 0, s = !0, l;
  for (l of text) {
      if ('"' === l) {
          if (s && l === p) row[i] += l;
          s = !s;
      } else if (',' === l && s) l = row[++i] = '';
      else if ('\n' === l && s) {
          if ('\r' === p) row[i] = row[i].slice(0, -1);
          row = ret[++r] = [l = '']; i = 0;
      } else row[i] += l;
      p = l;
  }
  return ret;
};

function listConvo() {

  var files = getCookie("chatfiles");
  var alias = getCookie("aliases");
  files = files.substring(1,files.length-1);
  alias = alias.substring(1,alias.length-1);
  
  files = files.split(",");
  alias = alias.split(",");
  
  if (files.length === 0)
    return;
  
  var x = document.getElementById("chatters");
  var h = 0;
  
  while (x.childElementCount > h++) {
    x.removeChild(x.firstChild);
  }
  h = 0;
  var v = document.createElement("option");
  
  x.options[0] = new Option("You have " + files.length + " people to chat with!","");
  
  for (var i = 0; i < files.length ; i++) { 
    x.options[i+1] = new Option(alias[i],files[i]);
  }
  
}

function loginUnsuccessful() {
  var y = getCookie("count");
  y++;
  setCookie("count", y);
  document.getElementById("warning").value = "Wrong Email/Password (" + y + "/3)";
  menuList('login.php');
}

function logout() {
  var x = document.getElementById("email").value;
  var y = document.getElementById("password").value;
  
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
  var str = x.options[x.selectedIndex].value
  str = str.substring(1,str.length-1);
  startChat(str);
  setCookie("chatfile", str);
}

function startChat(v) {
  url = "./xml/" + getCookie("chatfile");
  if (v !== undefined)
    url = "./xml/" + v;
    console.log(url);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
          fillChat(this);
      }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
  
}

function findOptions() {
  xhttp = new XMLHttpRequest();
  xhttp.open("GET", "chatxml.php", true);
  xhttp.send();
  
}

  function fillChat(xml) {
    var y, z, i, yLen, xmlDoc, txt;
    xmlDoc = xml.responseXML;
    txt = "";
    if (getCookie("login") !== "true")
      return;
    // Output all chat lines
    z = xmlDoc.getElementsByTagName("messages")[0];
    y = z.childNodes;
    yLen = y.length;
    for (i = 0; i < yLen; i++) { 
      console.log(y[i].getAttribute("user") + " " + getCookie(""));
        if (y[i].getAttribute("user") == getCookie("myemail")) {
          txt += '<div style="opacity:0.5;background:gray;color:white;width:100%">';
          txt += "me: " + y[i].childNodes[0].nodeValue + '</div>';
        }
        else {
          txt += '<div style="opacity:0.5;background:black;color:white;width:100%">';
          txt += getCookie("contact_alias") + ": " + y[i].childNodes[0].nodeValue + "</div><br>";
        }
    }
    var t = document.getElementById("chatwindow");
    t.innerHTML = txt;
    if (document.getElementById("startchat").getAttribute("loaded") == "0") {
      t.scrollTop = t.childElementCount*18;
    }
  }

function goChat(i,j) {
  if (j == 13) {
    var x = document.getElementById("chatwindow");
    var y = i.cloneNode();
    x.innerHTML += '<div style="background:gray;color:white;width:100%">' + y.value + "</div>";
    fetch("chat.php?a=" + y.value);
    x.scrollTop = x.childElementCount*18;
    i.value = "";
  }
  if (document.getElementById("chatwindow").innerHTML == "&nbsp;") {
    startChat();
  }
}

function clearChat() {
  var x = document.getElementById("chatwindow");
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
      menuList('preorder.php');
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
  //  document.getElementById("chatwindow").style.wordWrap = "true";

    //document.getElementById("chatwindow").innerText = i.substring(1,i.length-2);
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
    p.setAttribute("pos", x);
    var t = p.firstChild;
    var i = 0;
    var c = p.firstChild.childElementCount;
    while (p.firstChild.hasChildNodes && i < c && p.firstChild.childNodes[i].tagName != "BUTTON") {
      console.log(p.firstChild.childNodes[i].tagName);
      i++;
    }
    if (p.firstChild.childNodes[i].tagName == "BUTTON") {
      p.firstChild.childNodes[i].setAttribute("pos", x);
      h.appendChild(p);
    }
  }

  function removeItem(i) {
    var x = i.getAttribute("pos");

    var h = document.getElementById("preorders");
    var k = h.childNodes;
    var j = k.length;
    if (x >= j) {
      h.removeChild(k[k.length-1])
    }
    else
      h.removeChild(k[x]);
  }

  function makePreorder() {
    var g = document.getElementsByTagName("input");
    var z = [null];
    var y = [null];
    
    for (i = 0 ; i < g.length ; i++) {
        if (g[i].className == "item")
          z.unshift(g[i].value);
        else {
          y.unshift(g[i].value);
        }
    }
    fetch('preorderxml.php?a=' + encodeURI(z) + "&b=" + encodeURI(y))
    .then(function(response) {
      return response.json();
    })
    .then(function(j) {
      console.log(JSON.stringify(j));
    });
  }
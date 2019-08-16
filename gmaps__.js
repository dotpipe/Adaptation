
var datarray = [];
var ADDR;
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
  /*
  if (countCookies() > 4) {
    var lt = encodeURIComponent(t.latitude);
    var lg = encodeURIComponent(t.longitude);
    console.log(getCookie('addr'));
    var b = encodeURI("marker.php"); //?address=" + getCookie('address') + "&lat=" + lt + "&long=" + lg + "&business=" + getCookie('business') + "&name=" + getCookie('name') + "&type=" + getCookie('type'));
    passPOST(b);
    setCookie('addr',"");
    setCookie('biz',"");
    setCookie('name',"");
    setCookie('type',"");
  }
  */
  var map = new google.maps.Map(
    document.getElementById('map'),
    {center: {lat: position.coords.latitude, lng: position.coords.longitude}, zoom: 13});

  var input;
  var autocomplete;
  if (null != document.getElementById('addr')) {
    input = document.getElementById('addr');

    autocomplete = new google.maps.places.Autocomplete(input);

    // Specify just the place data fields that you need.
    autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);
  }
  var infowindow = new google.maps.InfoWindow();
  var infowindowContent = document.getElementById('infowindow-content');
  infowindow.setContent(infowindowContent);

  // Change this depending on the name of your PHP or XML file
  downloadUrl('stores.xml', function(data) {
    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
      var id = markerElem.getAttribute('id');
      var name = markerElem.getAttribute('name');
      var address = markerElem.getAttribute('address');
      var biz = markerElem.getAttribute('business');
      var type = markerElem.getAttribute('type');
      var point = new google.maps.LatLng(
          parseFloat(markerElem.getAttribute('lat')),
          parseFloat(markerElem.getAttribute('long')));

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
        var x = encodeURI(biz + ", " + address);
        var y = x;
        marker.addListener('click', function() {
          
        var infowindow = new google.maps.InfoWindow({
          content: "<p onclick=focusStore(\"" + y + "\");><u>" + name + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br><u>" + biz + "</u>&nbsp;&nbsp;&nbsp;&nbsp;<br><u>" + type + "</u>&nbsp;&nbsp;&nbsp;&nbsp;</p><br>",

        });
          infowindow.open(map, marker);
          fetch('test.php', function() {})
            .then(function(response){
              return response.json();
            })
            .then(function(myJson) {
              console.log(JSON.stringify(myJson));
              //mapView();
              //call in code to get deals here
            });
              
        });
      }
    });
    glaze(address);
  });
});
}


function focusStore(address) {
  setCookie("addy", address);
  fetch('getstore.php?a=' + getCookie("addy"), function() {})
    .then(function(){
      return;
    })
    .then(function() {
      //console.log(JSON.stringify(myJson));
      menuList('preorder.php');
      //call in code to get deals here
    });
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
    console.log(this);
    fetch('test.php')
    .then(function(response) {
      console.log(response);
      return response.json();
    })
    .then(function(myJson) {
      console.log(JSON.stringify(myJson));
    });
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
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
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
      //  console.log(response.json());
      return response.json();
      })
      .then(function(j) {
        
        fillMenu(JSON.stringify(j));
      });
      if (i === "newclient.php")
        honey();
  }

  function fillChat(i) {
    document.getElementById("chatwindow").style.wordWrap = "true";

    document.getElementById("chatwindow").innerText = i.substring(1,i.length-2);
  }
  
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
    var c = t.childElementCount;
    do {
      console.log(p.firstChild.childNodes[i].tagName);
      i++;
    } while (i <= c && p.firstChild.childNodes[i].tagName != "BUTTON");

    p.firstChild.childNodes[i].setAttribute("pos", x);
    h.appendChild(p);
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
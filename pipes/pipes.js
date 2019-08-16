['click', 'touch', 'tap'].forEach(function(e) {
	window.addEventListener(e, function(ev) {
	var method_thru = "";
	var mode_thru = "";
	var cache_thru = "";
	var cred_thru = "";
	var content_thru = "";
	var redirect_thru = "";
	var refer_thru = "";
	var elem = document.getElementById(ev.target.id);

	
	if (elem === null || elem === undefined) {
		if (ev.target.onclick !== null && ev.target.onclick !== undefined)
			(ev.target.onclick)();
//does not mix with href (but you can still use <a></a>)
		if (ev.target.href !== null && ev.target.href !== undefined)
			window.location.href = ev.target.href;
		return;
	}

//use 'data-pipe' as the classname to include its value
// specify which pipe with pipe="target.id"
	var elem_values = document.getElementsByClassName("data-pipe");
	var elem_qstring = "";

// No 'pipe' means it is generic. This means it is open season for all with this class
	for (var i = 0 ; i < elem_values.length ; i++) {

	//if this is designated as belonging to another pipe, it won't be passed in the url
		if (!elem_values[i].hasAttribute("pipe") || elem_values[i].getAttribute("pipe") == elem.id)
			elem_qstring = elem_qstring + elem_values[i].name + "=" + elem_values[i].value + "&";
	// Multi-select box
		if (elem_values[i].hasAttribute("multiple")) {
			for (var o of elem_values.options) {
				if (o.selected) {
					elem_qstring = elem_qstring + elem_values[i].name + "=" + o.value + "&";
				}
			}
		}
	}

//strip last & char
	if (elem_qstring[elem_qstring.length-1] === "&")
		elem_qstring = elem_qstring.substring(0, elem_qstring.length - 1);

// if thru-pipe isn't used, then use to-pipe
	if (!elem.hasAttribute("ajax")) {
		if (elem.hasAttribute("goto") && elem.getAttribute("goto") !== "")
			window.location.href = elem.getAttribute("goto") + "?" + elem_qstring;
		return;
	}

// communicate properties of Fetch Request
	(!elem.hasAttribute("method")) ? method_thru = "GET" : method_thru = elem.getAttribute("method");
	(!elem.hasAttribute("mode")) ? mode_thru = "no-cors" : mode_thru = elem.getAttribute("mode");
	(!elem.hasAttribute("cache")) ? cache_thru = "no-cache" : cache_thru = elem.getAttribute("cache");
	(!elem.hasAttribute("credentials")) ? cred_thru = "same-origin" : cred_thru = elem.getAttribute("credentials");
// updated "headers" attribute to more friendly "content-type" attribute
	(!elem.hasAttribute("content-type")) ? content_thru = '{"Access-Control-Allow-Origin":"*","Content-Type":"text/html"}' : content_thru = elem.getAttribute("headers");
	(!elem.hasAttribute("redirect")) ? redirect_thru = "manual" : redirect_thru = elem.getAttribute("redirect");
	(!elem.hasAttribute("referrer")) ? refer_thru = "client" : refer_thru = elem.getAttribute("referrer");

	var opts_req = new Request(elem.getAttribute("ajax") + "?" + elem_qstring);
	opts = new Map();
	opts.set("method", method_thru); // *GET, POST, PUT, DELETE, etc.
	opts.set("mode", mode_thru); // no-cors, cors, *same-origin
	opts.set("cache", cache_thru); // *default, no-cache, reload, force-cache, only-if-cached
	opts.set("credentials", cred_thru); // include, same-origin, *omit
	opts.set("content-type", content_thru); // content-type UPDATED**
	opts.set("redirect", redirect_thru); // manual, *follow, error
	opts.set("referrer", refer_thru); // no-referrer, *client
	opts.set('body', JSON.stringify(content_thru));
	const abort_ctrl = new AbortController();
	const signal = abort_ctrl.signal;
	var target__ = null;

	var pipe_back = "";
// This is where the output will go. Indicates id attribute to aim at
	if (elem.hasAttribute("insert-in"))
		target__ = document.getElementById(elem.getAttribute("insert-in"));
// This is where the output will go. Indicates id attribute to aim at
	if (elem.hasAttribute("json")) {
		target__ = document.getElementById(elem.getAttribute("json"));
		pipe_back = "json";
	}
	fetch(opts_req, {signal});
	
	setTimeout(() => abort_ctrl.abort(), 3 * 1000);
	const __grab = async (opts_req, opts) => {
		return fetch(opts_req, opts)
			.then(function(response){
			return response.text().then(function(text) {
// Make sure that the target out-pipe exists still
				if (target__ != null && pipe_back != "json")
					target__.innerHTML = text;
				else if (target__ != null && pipe_back == "json") {
					let v = JSON.parse(text);
					return v;
				}
				return text;
			});
		});
	}

//  Insert a callback function by useing call-pipe
	const getActivity = async (opts_req, opts) => {
		let g = await __grab(opts_req, opts);
		if (elem.hasAttribute("callback")) {
			var t = elem.getAttribute("callback");
			return (t)(g);
		}
		return;
	}
	var s = getActivity(opts_req, opts);

// to-pipe means, go here with current browser window
// Only uses if thru-pipe exists. Unlike above.
	if (elem.hasAttribute("ajax") && elem.hasAttribute("goto"))
		window.location.href = elem.getAttribute("goto");
}, false);
});
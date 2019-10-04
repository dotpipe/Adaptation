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
//does not mix with href (but you can still use <a href="foo"></a> alone)
		if (ev.target.href !== null && ev.target.href !== undefined)
			window.location.href = ev.target.href;
		return;
	}
	
    const urlParams = new URLSearchParams(window.location.search);
    const myParam = urlParams.get('jsn');
    if (myParam !== "1")
        return;
    
    
    const myFunc = urlParams.get('func');
    
    executeFunctionByName(myFunc, elem, ...args)
    
    
    });

});
 
function callPage() {
    callFile("chat/createchat.php");
    callFile("chat/chataliases.php?c=2");
    var x = getCookie("chatfile");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        //clearChat();
      }
    };
    xhttp.open("POST", "xml/" + x, false);
    xhttp.send();
    var s = xhttp.responseXML.firstChild;
    var xsltProcessor = new XSLTProcessor();
    xhttp = new XMLHttpRequest();
    xhttp.open("GET", "xml/chatxml.xsl", false);
    xhttp.send(null);
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

function startTimer(...args) {
    setTimeout(function() {
        callPage();
       }, 1000); //wait one second to run function
}
 
function executeFunctionByName( functionName, context, args ) {
    var args, namespaces, func;

    if( typeof functionName === 'undefined' ) { throw 'function name not specified'; }

    if( typeof eval( functionName ) !== 'function' ) { throw functionName + ' is not a function'; }

    if( typeof context !== 'undefined' ) { 
        if( typeof context === 'object' && context instanceof Array === false ) { 
            if( typeof context[ functionName ] !== 'function' ) {
                throw context + '.' + functionName + ' is not a function';
            }
            args = Array.prototype.slice.call( arguments, 2 );

        } else {
            args = Array.prototype.slice.call( arguments, 1 );
            context = window;
        }

    } else {
        context = window;
    }

    namespaces = functionName.split( "." );
    func = namespaces.pop();

    for( var i = 0; i < namespaces.length; i++ ) {
        context = context[ namespaces[ i ] ];
    }

    return context[ func ].apply( context, args );
}
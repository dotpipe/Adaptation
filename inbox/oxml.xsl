<<<<<<< HEAD

=======
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5
<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
 version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns="http://www.w3.org/TR/REC-html40">
<xsl:output method="html"/>
<xsl:template match="/">
<<<<<<< HEAD
    <style>
    	#td-surround { background:black;border:0px;width:250px; }
    	#in-window { overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;width:100%; }
    </style>
    <xsl:for-each select="preorders/shopper">
        <xsl:variable name="e"><xsl:value-of select="email"/></xsl:variable>
       	<div id="in-window" onfocus="this.style.background='gray'" onblur="this.style.background='black'" style="font-size:12px;background:black;color:lightgray;width:100%">
            <xsl:text>From: </xsl:text>
           	<xsl:value-of select="from"/>
            <xsl:text> - Date: </xsl:text>
            <xsl:value-of select="date"/>
            <xsl:text> - Products: </xsl:text>
            <xsl:value-of select="products"/>
            <xsl:text> - Total Items: </xsl:text>
    		<xsl:value-of select="quantity"/>
			<xsl:text> - Contact: </xsl:text>
			<xsl:value-of select="email"/>
			<i onclick="getInbox(1,'{ $e }')"> look</i>
			<hr/>
       	</div>
    </xsl:for-each>
</xsl:template>
</xsl:stylesheet>
	
=======
  <style>
	#td-surround { background:black;border:0px;height:300px;width:250px; }
	#in-window { border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:300px;width:250px; }
  </style>
  <table>
      	
       <tr><td>
            <a onclick="menuList('inbox.php')" style="text-decoration:none;font-size:15px;color:red">
        	   <xsl:text>Back To Inbox</xsl:text>
            </a>
            <xsl:value-of select="/preorders/items/@from" />
  		    <xsl:text> on </xsl:text>
            <xsl:value-of select="/preorders/items/@day" />
        </td></tr>
        <tr><td id="td-surround">
            <div id="in-window">
                <xsl:for-each select="/preorders">
                	<div>
                	    <xsl:value-of select="../email" />
                      	<xsl:value-of select="items/product" />
                        <xsl:text> Qu: </xsl:text>
                	    <xsl:value-of select="items/@quantity" />
                  	</div>
        	    </xsl:for-each>
    	    </div>
        </td></tr>
	<tr><td>
        <input style="background-color:green;" name="listen" type="radio"><xsl:text> Got it! </xsl:text>
        <input style="color:white;background-color:red;" name="listen" type="radio"><xsl:text> Waiting...<br></xsl:text>
        <input style="background-color:blue;color:white;noshadow:true" type="checkbox"><xsl:text> Busy -- </xsl:test>
        <button style="font-size:18px;background-color:blue;color:white;margin:10px;border-radius:25%">:)</button>';
 	</td></tr>
  </table>
</xsl:template>
</xsl:stylesheet>
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5

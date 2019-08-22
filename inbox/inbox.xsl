<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
 version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns="http://www.w3.org/TR/REC-html40">
<xsl:output method="html"/>
<xsl:template match="/">
  <style>
	#td-surround { background:black;border:0px;height:300px;width:250px; }
	#in-window { border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:300px;width:250px; }
  </style>
  <table>
      	
       <tr><td>
            <a style="text-decoration:none;font-size:15px;color:red">
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
        <select><option name="listen" value="ignore">User Queue</option></select> <input style="background-color:blue;color:white;noshadow:true" type="checkbox"><xsl:text> Busy -- </xsl:test>
        <button style="font-size:14px;background-color:blue;color:white;border-radius:50%">:)</button>';
 	</td></tr>
  </table>
</xsl:template>
</xsl:stylesheet>

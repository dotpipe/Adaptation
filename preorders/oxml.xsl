
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
        <tr><td id="td-surround">
            <xsl:for-each select="preorders/shopper">
            	<div id="in-window" onclick="menuList('orders.php')" style="font-size:12px;background:black;color:white;width:100%">
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
       			</div>
       		</xsl:for-each>
        </td></tr>
	</table>
<xsl:template>
<xsl:stylesheet>
	
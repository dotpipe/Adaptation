<<<<<<< HEAD
<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
		<style>
	#td-surround { background:black;border:0px;width:250px; }
	#in-window { border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:black;background:black;height:300px;width:250px; }
  </style>
		<xsl:for-each select="/preorders">
			<xsl:for-each select="items">
				<div style="width:100%;font-size:13px;background:darkblue;color:lightblue">
					<xsl:value-of select="email"/>
					<xsl:text> </xsl:text>
					<xsl:value-of select="product"/>
					<xsl:text> Qu: </xsl:text>
					<xsl:value-of select="../items/@quantity"/>
				</div>
			</xsl:for-each>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
=======

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
	
>>>>>>> 9f1db909a7dc3f1791b4a1d9f5ab17f6cf8001b5

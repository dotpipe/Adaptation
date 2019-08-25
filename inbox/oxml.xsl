<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
 version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html"/>
<xsl:template match="/">
    <style>
    	#td-surround { background:black;border:0px;width:250px; }
    	.in-window { overflow-wrap:break-word;overflow-y:scroll;color:lightgray;background:black;width:100%; }
    </style>
    <xsl:for-each select="preorders/shopper">
        <xsl:variable name="e"><xsl:value-of select="email"/></xsl:variable>
       	<div class="in-window" onfocus="this.style.background='gray'" onblur="this.style.background='black'" style="font-size:12px;background:black;color:lightgray;width:100%">
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
			<i onmouseover="setCookie('e', '{ $e }')" onclick="getInbox(1,'{ $e }')"> look</i>
			<hr/>
       	</div>
    </xsl:for-each>
</xsl:template>
</xsl:stylesheet>

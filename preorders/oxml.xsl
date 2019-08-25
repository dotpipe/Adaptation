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

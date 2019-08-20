<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
xmlns="http://www.w3.org/TR/REC-html40">
<xsl:output method="html"/>
<xsl:template match="/">
    <xsl:for-each select="messages/msg">
      <div style="font-size:12px;background:black;color:white;width:100%">
      <xsl:value-of select="text/@alias"/>
      <xsl:text>: </xsl:text>
      <xsl:value-of select="text"/></div>
    </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
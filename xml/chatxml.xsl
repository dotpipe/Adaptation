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
	#texter {background:black;height:30px;width:250px; }
	#inputs { font-size:24px;border:2px solid darkblue;width:250px; }
  </style>
  <table>
	<tr> <td>
		<b style="font-size:15px;color:red">
    			<xsl:text>Cheri with </xsl:text>
    			<xsl:value-of select="//messages/msg/@alias" />
      		</b>
      		<xsl:text> : : </xsl:text>
	</td></tr>

	<tr><td colspan="2" id="td-surround">
		<div id="in-window">
    			<xsl:for-each select="messages/msg">
            				<div style="font-size:12px;background:black;color:white;width:100%">
            				<xsl:value-of select="text/@alias"/>
            				<xsl:text>: </xsl:text>
            				<xsl:value-of select="text"/>
            				</div>
    			</xsl:for-each>
  		</div>
	</td></tr>
	<tr> <td>
		<div id="texter">
		<input spellcheck="true" onkeypress='goChat(this,event.keyCode)' id="inputs" type="text" />
		</div>
	</td></tr>
  </table>
</xsl:template>
</xsl:stylesheet>

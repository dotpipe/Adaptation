<?xml-stylesheet type="text/xml" version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html"/>
	<xsl:template match="/">
		<style>
	#td-surround { background:black;border:0px;width:250px; }
	#texter { background:black;height:30px;width:250px; }
	#flag { background:black;height:20px;width:20px;cursor:pointer; }
	#inputs { font-size:24px;border:2px solid darkblue;width:250px; }
	#in-window { border:2px solid darkblue;overflow-wrap:break-word;overflow-y:scroll;color:white;background:black;height:300px;width:250px; }
	.tooltip { position: relative; display: inline-block; border-bottom: 1px dotted black; /* If you want dots under the hoverable text */ }

	/* Tooltip text */
	.tooltip .tooltiptext { margin-left: 20%; visibility: hidden; width: 120px; background-color: white;
		color: #000; text-align: center; padding: 5px 0; border-radius: 6px;
		/* Position the tooltip text - see examples below! */
        position: absolute; z-index: 3; }
        
	.tooltip .tooltiptext { top: -5px; right: 105%; }
	
	/* Show the tooltip text when you mouse over the tooltip container */
	.tooltip:hover .tooltiptext { visibility: visible; }
	.tooltip .tooltiptext::after { content: " "; position: absolute; top: 50%; left: 100%; /* To the right of the tooltip */
		margin-top: -5px; border-width: 5px;
        border-style: solid; border-color: transparent transparent transparent white;
}
   </style>
		<table>
			<tr>
				<td>
					<b style="font-size:15px;color:red">
						<xsl:text>Cheri with </xsl:text>
						<xsl:value-of select="//messages/msg/@alias"/>
					</b>
					<xsl:text> : : </xsl:text>
				</td>
			</tr>
			<tr>
				<td id="td-surround">
					<div id="in-window">
						<xsl:for-each select="messages/msg">
							<p style="display:table-row">
								<div class="tooltip flag" time="{text/@time}" alias="{text/@alias}" style="height:12px;display:table-cell;font-size:12px;background:black;color:white;width:100%">
									<xsl:value-of select="text/@alias"/>
									<xsl:text>: </xsl:text>
									<xsl:value-of select="text"/>
								</div>
								<div id="flag" class="tooltip" style="display:table-cell">
									...
									<span class="tooltiptext" onclick="flagComment(this)">Flag comment</span>
								</div>
							</p>
						</xsl:for-each>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div id="texter">
						<input spellcheck="true" onkeypress="goChat(this,event.keyCode)" id="inputs" type="text"/>
					</div>
				</td>
			</tr>
		</table>
	</xsl:template>
</xsl:stylesheet>

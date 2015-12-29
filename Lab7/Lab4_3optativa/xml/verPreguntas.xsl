<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
	<body>
		<h1 style="text-align: center;">Preguntas</h1>
		<table border="1px solid black"  style="border-collapse: collapse; text-align: center; margin: 5em auto auto auto;">
		<thead>
			<tr style="background-color:  #E1F5A9">
				<th>Tema</th>
				<th>Pregunta</th>
				<th>Complejidad</th>
			</tr>
		</thead>
		<xsl:for-each select="/assessmentItems/assessmentItem">
		<tr>
			<td>
				<font size="3" color="black" face="Verdana">
				<xsl:value-of select='@subject'/> <br/>
				</font>
			</td>
			<td>
				<font size="3" color="black" face="Verdana">
				<xsl:value-of select="itemBody/p"/> <br/>
				</font>
			</td>
			<td>
				<font size="3" color="black" face="Verdana">
				<xsl:value-of select='@complexity'/> <br/>
				</font>
			</td>
			</tr>
		</xsl:for-each>
		</table>
	</body>
</html>
</xsl:template>
</xsl:stylesheet>
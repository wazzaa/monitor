<table border="1" bordercolor="#1c1c1c" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td>Server name</td>
		<td>Address</td>
		<td>Players</td>
		<td>Map</td>
	</tr>
	{content}<!-- analog {content} in DLE -->
	<tr>
		<td><a href="/servers/stats/{id}">{gq_hostname}</a></td>
		<td>{gq_address}:{gq_port}</td>
		<td>{gq_numplayers}/{gq_maxplayers}</td>
		<td>{gq_mapname}</td>
	</tr>
	{/content}<!-- analog {content} in DLE -->	
</table>

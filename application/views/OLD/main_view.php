<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Заголовок странички</title>
<meta name="description" content="{desctiption}" />
<meta name="keywords" content="{keywords}" />
</head>



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
Page generated in:{elapsed_time} s. / Memory usage: {memory_usage} 
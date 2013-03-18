<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{gq_hostname} - статистика сервера</title>
<meta name="description" content="{desctiption}" />
<meta name="keywords" content="{keywords}" />
</head>

<h4>General information:</h4>
<table border="1" bordercolor="#1c1c1c" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td>Server name</td>
		<td>Address</td>
		<td>Players</td>
		<td>Map</td>
	</tr>

	<tr>
		<td>{gq_hostname}</td>
		<td>{gq_address}:{gq_port}</td>
		<td>{gq_numplayers}/{gq_maxplayers}</td>
		<td>{gq_mapname}</td>
	</tr>
</table>

<h4>Players information:</h4>
<table border="1" bordercolor="#FFCC00" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td>Name</td>
		<td>score</td>
		<td>time</td>
		<td>gq_name [debug_data]</td>
		<td>gq_score [debug_data]</td>
		<td>gq_ping [debug_data]</td>

	</tr>
	{players}
	<tr>
		<td>{name}</td>
		<td>{score}</td>
		<td>{time}</td>
		<td>{gq_name}</td>
		<td>{gq_score}</td>
		<td>{gq_ping}</td>
	</tr>
	{/players}	
</table>
<!-- 
<h4>Server variables:</h4>
<table border="1" bordercolor="#asdasd" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td>Setting</td>
		<td>Status</td>

	</tr>
	{settings}
	<tr>
		<td>{name}</td>
		<td>{score}</td>
	</tr>
	{/settings}
</table>
-->

Page generated in:{elapsed_time} s.
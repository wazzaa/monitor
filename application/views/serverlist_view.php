    <table class="tbl-border" border="0" cellpadding="0" cellspacing="1" width="100%">
      <tbody>
        <tr>
          <td colspan="2" class="tbl2">
            <a href="/servers/submit">
              Добавить сервер
            </a>
          </td>
          <td colspan="2" align="center" class="tbl2">
            <a href="http://www.cscl.ru/monitoring/search">
              Foobar
            </a>
          </td>
          <td colspan="2" align="center" class="tbl2">
            <a href="http://www.cscl.ru/monitoring/contact">
              Foobarbaz
            </a>
          </td>
        </tr>
        <tr>
          <td class="forum-caption">
		  Название сервера
          </td>

          <td class="forum-caption" width="150">
            <center>
              Адрес
            </center>
          </td>
          <td class="forum-caption" width="100">
            <center>
              Карта
            </center>
          </td>
          <td class="forum-caption" width="70">
            <center>
              Игроки
            </center>
          </td>
          <td class="forum-caption" width="70">
            <center>
              Голоса
            </center>
          </td>
        </tr>
		{content}
        <tr>
          <td align="left" class="tbl1">
            <a href="/servers/stats/{id}" id="link">
              {gq_hostname}
            </a>
          </td>
          <td class="tbl2" align="center">
            {gq_address}:{gq_port}
          </td>
          <td class="tbl1" align="center">
            {gq_mapname}
          </td>
          <td class="tbl2" align="center">
            {gq_numplayers}/{gq_maxplayers}
          </td>
		

<td class="tbl1" align="center">
<font color="#e79f00">
<b>
V.I.P
<b>
</b>
</b>
</font>
</td>

</tr>
{/content}
<tr>


  </tbody>
  </table>





<!--
<table border="1" bordercolor="#1c1c1c" style="background-color:#FFFFCC" width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td>Server name</td>
		<td>Address</td>
		<td>Players</td>
		<td>Map</td>
	</tr>
	{content}
	<tr>
		<td><a href="/servers/stats/{id}">{gq_hostname}</a></td>
		<td>{gq_address}:{gq_port}</td>
		<td>{gq_numplayers}/{gq_maxplayers}</td>
		<td>{gq_mapname}</td>
	</tr>
	{/content}
</table> -->

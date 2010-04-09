$headinclude
		<font face="{font}" color="{fontcolorwarn}"><b>$message</b></font>
		<br><br>
		<table bgcolor="{tablebordercolor}" cellpadding="3">
			<tr><td bgcolor="{tablec}">SQL-Query (Result: $total total, $num_queries queries)</td></tr>
			<tr><td bgcolor="{tablea}">$sql_query</td></tr>
		</table>

		<br>

$tbl_view_wrap

		<br>

		<!--<div align="left" style="display: block;overflow-x: auto;width: 750px;margin: 0;padding-bottom: 1px;">-->

		<table bgcolor="{tablebordercolor}" cellpadding="3">
$tbl_view_rows
		</table>

		<!--</div>-->

$footinclude
$headinclude
$gui_message2

	<h2>$strCreateFormDetailTitle "$_POST[new_table_name]"</h2>

	<form method="post" action="index.php?show=table_create&db=$_GET[db]&tbl=$_POST[new_table_name]&create=true$SID">
		<input type="hidden" name="numf" value="$_POST[new_table_numf]">
		<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr>
				<td bgcolor="{tablec}">$strField</td>
				<td bgcolor="{tablec}">$strType</td>
				<td bgcolor="{tablec}" align="center">Null</td>
				<td bgcolor="{tablec}">$strDefault</td>
			</tr>

$tbl_list_fields

		</table>
		<br>
		<input type="submit" name="confirm" value="$strCreateFormSubmit"> 
		<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
	</form>

$footinclude
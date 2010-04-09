$headinclude
$gui_message2

		$strInsertRowFormTitle
		<br><br>

		<form method="post" action="index.php?show=table_insert&db=$_GET[db]&tbl=$_GET[tbl]&insert=true$SID">
			<input type="hidden" name="numf" value="$numf">
			<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr bgcolor="{tablec}">
				<td>$strField</td>
				<td>$strType</td>
				<td align="center">$strFunction</td>
				<td align="center">Null</td>
				<td align="center">$strValue</td>
			</tr>

$tbl_list_fields

			</table>
			<br>
			<input type="submit" value="$strInsertSubmit"> 
			<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>
		<hr class="hrclass_main">

$footinclude
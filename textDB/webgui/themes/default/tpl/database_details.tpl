$headinclude
$gui_message2

		<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr bgcolor="{tablec}">
				<td>$strTable</td>
				<td colspan=5 align="center">$strActions</td>
				<td>$strRecord</td>
				<td align="right">$strLastMod</td>
				<td align="right">$strSize</td>
			</tr>

$db_list_tbls

		</table>
		<hr class="hrclass_main">
		<img class="icon" src="$templateroot/img/b_newtbl.png" width="16" height="16" alt=""><img src="$templateroot/img/spacer.png" width="5" height="1" alt=""><b>$strCreateFormTitle</b>
		<br><br>
		<form method="post" action="index.php?show=table_create&db=$_GET[db]$SID">
			$strCreateFormTableName <input size=30 name="new_table_name"><img src="$templateroot/img/spacer.png" width="15" height="1" alt="">$strCreateFormFieldNumber <input size=5 name="new_table_numf">
			<br><br>
			<input type="submit" name="confirm" value="$strCreateFormSubmit">
		</form>

$footinclude
$headinclude
$gui_message2

		<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr bgcolor="{tablec}">
				<td>$strDatabase</td>
				<td colspan="3" align="center">$strActions</td>
				<td>$strTables</td>
				<td>$strRecord</td>
				<td align="right">$strLastMod</td>
				<td align="right">$strSize</td></tr>

$server_list_dbs

		</table>
		<hr class="hrclass_main">
		<img class="icon" src="$templateroot/img/b_newdb.png" width="16" height="16" alt=""><img src="$templateroot/img/spacer.png" width="5" height="1" alt=""><b>$strActionCreateDbsTitle</b>
		<br><br>
		<form method="post" action="index.php?$SID">
			$strCreateFormTableName <input size=30 name="new_db">
			<br><br>
			<input type="submit" name="confirm" value="$strCreateFormSubmit">
		</form>

$footinclude
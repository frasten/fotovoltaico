$headinclude
$gui_message2

		<table bgcolor="{tablebordercolor}" cellpadding=3>
		<tr bgcolor="{tablec}">
			<td>$strField</td>
			<td>$strType</td>
			<td>$strDefault</td>
			<td colspan=4 align="center">$strActions</td>
		</tr>

$tbl_list_fields

		</table>

		<hr class="hrclass_main">
		<img class="icon" src="$templateroot/img/b_insrow.png" width="16" height="16" alt=""><img src="$templateroot/img/spacer.png" width="5" height="1" alt=""><b>$strAddFormTitle</b>
		<br><br>
		<form method="post" action="index.php?show=column_add&db=$_GET[db]&tbl=$_GET[tbl]$SID">
			<input name="field_where" id="where_last" value="last" checked="checked" type="radio" style="padding:0;"><label for="where_last">$strAddFormLast</label>&nbsp;
			<input name="field_where" id="where_first" value="first" type="radio" style="padding:0;"><label for="where_first">$strAddFormFirst</label>&nbsp;
			<input name="field_where" id="where_after" value="after" type="radio" style="padding:0;"><label for="where_after">$strAddFormAfter</label>&nbsp;
			<select name="after_field" onclick="this.form.field_where[2].checked=true" onchange="this.form.field_where[2].checked=true">
$col_option_list
			</select>
			<br><br>
			<input type="submit" name="confirm" value="$strAddFormContinue">
		</form>

$footinclude
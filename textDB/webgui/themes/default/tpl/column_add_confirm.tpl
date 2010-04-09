$headinclude
$gui_message2

	<h2>$strAddFormTitle </h2>

	<form method="post" action="index.php?show=column_add&db=$_GET[db]&tbl=$_GET[tbl]&add=true$SID">
		<input type="hidden" name="field_where" value="$_POST[field_where]"> 
		<input type="hidden" name="after_field" value="$_POST[after_field]">
		<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr>
				<td bgcolor="{tablec}">$strField</td>
				<td bgcolor="{tablec}">$strType</td>
				<td bgcolor="{tablec}" align="center">Null</td>
				<td bgcolor="{tablec}">$strDefault</td>
			</tr>

			<tr>
				<td bgcolor="{tablea}">
					<input size=30 name="new_fname" value="">
				</td>
				<td bgcolor="{tablea}">
					<select name="new_ftype" onChange="typeControl(this.value,'new_fnull','new_fdval');" size=1>
						<option value="str">STR</option>
						<option value="int">INT</option>
						<option value="inc" $disabled>AUTO_INC</option>
					</select>
				</td>
				<td bgcolor="{tablea}">
					<input type="checkbox" name="new_fnull" onClick="nullControl(this.form.new_ftype.value,'new_fnull','new_fdval');" value="NULL">&nbsp;NULL
				</td>
				<td bgcolor="{tablea}">
					<input size=30 name="new_fdval" onBlur="if(this.form.new_ftype.value=='int')checkNumeric(this,',','.','-');" value="">
				</td>
			</tr>

		</table>
		<br>
		<input type="submit" name="confirm" value="$strAddFormSubmit"> 
		<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
	</form>

	<script type="text/javascript">
	<!--
	if (window.attachEvent) window.attachEvent("onload", OptionDisabledSupport.init); // IE specific!
	//-->
	</script>

$footinclude
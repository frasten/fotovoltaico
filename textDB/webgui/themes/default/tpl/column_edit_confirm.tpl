$headinclude
$gui_message2

	<h2>$strEditFormTitle </h2>

	<form method="post" action="index.php?show=column_edit&db=$_GET[db]&tbl=$_GET[tbl]&edit=true$SID">
		<input type="hidden" name="old_fname" value="$_GET[fname]">
		<table bgcolor="{tablebordercolor}" cellpadding=3>
			<tr>
				<td bgcolor="{tablec}">$strField</td>
				<td bgcolor="{tablec}">$strType</td>
				<td bgcolor="{tablec}" align="center">Null</td>
				<td bgcolor="{tablec}">$strDefault</td>
			</tr>

			<tr>
				<td bgcolor="{tablea}">
					<input size=30 name="new_fname" value="$_GET[fname]">
				</td>
				<td bgcolor="{tablea}">
					<select name="new_ftype" onChange="valueControl(this.value,'new_fnull','new_fdval')" size=1>
						<option value="str" $select_str>STR</option>
						<option value="int" $select_int>INT</option>
						<option value="inc" $select_inc $disable_type>AUTO_INC</option>
					</select>
				</td>
				<td bgcolor="{tablea}">
					<select name="new_fnull" onChange="valueControl(this.form.new_ftype.value,'new_fnull','new_fdval')" size=1>
						<option value="NULL">NULL</option>
						<option value="" $selected>NOT_NULL</option>
					</select>
				</td>
				<td bgcolor="{tablea}">
					<input size=30 name="new_fdval" onBlur="if(this.form.new_ftype.value=='int')checkNumeric(this,',','.','-');" value="$defvalue" $disabled>
				</td>
			</tr>

		</table>
		<br>
		<input type="submit" name="confirm" value="$strEditFormSubmit"> 
		<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
	</form>

	<script type="text/javascript">
	<!--
	if (window.attachEvent) window.attachEvent("onload", OptionDisabledSupport.init); // IE specific!
	//-->
	</script>

$footinclude
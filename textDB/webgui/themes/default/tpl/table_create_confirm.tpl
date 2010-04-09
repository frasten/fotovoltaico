$headinclude

		<b>$strCreateFormTitle</b>
		<br><br>
		<form method="post" action="index.php?show=table_create&db=$_GET[db]$SID">
			$strCreateFormTableName <input size=30 name="new_table_name"><img src="$templateroot/img/spacer.png" width="15" height="1" alt="">$strCreateFormFieldNumber <input size=5 name="new_table_numf">
			<br><br>
			<input type="submit" name="confirm" value="$strCreateFormSubmit"> 
			<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>

$footinclude
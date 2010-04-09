$headinclude

		$strColumnDeleteConfirm
		<br><br>
		<form method="post" action="index.php?show=column_delete&db=$_GET[db]&tbl=$_GET[tbl]&col=$_GET[col]&delete=true$SID">
			<input type="submit" name="confirm" value="$strSubmit">
			<input type="button"  onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>

$footinclude
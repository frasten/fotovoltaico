$headinclude

		$strDatabaseDeleteConfirm
		<br><br>
		<form method="post" action="index.php?delete_db=$_GET[db]$SID">
			<input type="submit" name="confirm" value="$strSubmit">
			<input type="button"  onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>

$footinclude
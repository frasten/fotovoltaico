$headinclude

		$strTableDeleteConfirm
		<br><br>
		<form method="post" action="index.php?show=table_delete&db=$_GET[db]&delete_tbl=$_GET[tbl]&delete=true$SID">
			<input type="submit" name="confirm" value="$strSubmit"> 
			<input type="button"  onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>

$footinclude
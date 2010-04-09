$headinclude

		$strTableEmptyConfirm
		<br><br>
		<form method="post" action="index.php?show=table_empty&db=$_GET[db]&empty_tbl=$_GET[tbl]&empty=true$SID">
			<input type="submit" name="confirm" value="$strSubmit"> 
			<input type="button" onClick="javascript:history.go(-1);" name="goback" value="$strCancel">
		</form>

$footinclude
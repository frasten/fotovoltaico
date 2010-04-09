
	<font face="{font}"><h2><img src="$templateroot/img/s_host.png" alt=""> $strServerName: <a href="index.php?show=server_details$SID">$servername</a> <img src="$templateroot/img/item_ltr.png" alt=""> <img src="$templateroot/img/s_db.png" alt=""> $strDatabaseName: <a href="index.php?show=database_details&db=$_GET[db]$SID">$_GET[db]</a> <img src="$templateroot/img/item_ltr.png" alt=""> <img src="$templateroot/img/s_tbl.png" alt=""> $strTableName: <a href="index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID">$_GET[tbl]</a> <img src="$templateroot/img/item_ltr.png" alt=""></h2></font>

		<a href="index.php?show=table_view&db=$_GET[db]&tbl=$_GET[tbl]$SID" title="$strActionView"><img class="icon" src="$templateroot/img/b_browse.png" alt="view"> $strActionView</a>
		<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">|<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">
		<a href="index.php?show=table_insert&db=$_GET[db]&tbl=$_GET[tbl]$SID" title="$strActionInsertRow"><img class="icon" src="$templateroot/img/b_insrow.png" alt="insert"> $strActionInsertRow</a>
		<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">|<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">
		<a href="index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID" title="$strActionStructure"><img class="icon" src="$templateroot/img/b_props.png" alt="$strActionStructure"> $strActionStructure</a>
		<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">|<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">
		<a href="index.php?show=table_empty&db=$_GET[db]&tbl=$_GET[tbl]$SID" title="$strActionEmpty"><img class="icon" src="$templateroot/img/b_empty.png" alt="$strActionEmpty"> $strActionEmpty</a>
		<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">|<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">
		<a href="index.php?show=table_delete&db=$_GET[db]&tbl=$_GET[tbl]$SID" title="$strActionDeleteTblTitle"><img class="icon" src="$templateroot/img/b_deltbl.png" alt="delete"> $strActionDelete</a>

		<hr class="hrclass_main">
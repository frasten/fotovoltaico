
	<font face="{font}"><h2><img src="$templateroot/img/s_host.png" alt=""> $strServerName: <a href="index.php?show=server_details$SID">$servername</a> <img src="$templateroot/img/item_ltr.png" alt=""> <img src="$templateroot/img/s_db.png" alt=""> $strDatabaseName: <a href="index.php?show=database_details&db=$_GET[db]$SID">$_GET[db]</a> <img src="$templateroot/img/item_ltr.png" alt=""></h2></font>

		<a href="index.php?show=table_create&db=$_GET[db]&create_table_form=true$SID" title="$strActionCreateTblTitle"><img class="icon" src="$templateroot/img/b_newtbl.png" alt=""> $strActionCreate</a></li>
		<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">|<img src="$templateroot/img/spacer.png" width="5" height="1" alt="">
		<a href="index.php?show=database_delete&db=$_GET[db]$SID" title="$strActionDeleteDbsTitle"><img class="icon" src="$templateroot/img/b_deldb.png" alt=""> $strActionDelete</a></li>

		<hr class="hrclass_main">
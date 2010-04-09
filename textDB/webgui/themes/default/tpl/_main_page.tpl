$headinclude

		<h1>$strWelcome textDB webGUI $txtdb_WEBGUI_version</h1>

		<b>API &nbsp;version:</b> $api_vers
		<br>
		<b>PHP version:</b> $php_vers

		<hr class="hrclass_main">

		<br>

		<table bgcolor="#E5E5E5" border="0" cellspacing="0" cellpadding=0> 
			<tr><td><img class="icon" src="$templateroot/img/s_host.png" width="16" height="16" alt=""></td><td>Server: $servername via TCP/IP</td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_usrcheck.png" width="16" height="16" alt=""></td><td>$username@$servername</td></tr>
			<tr><td><img class="icon" src="$templateroot/img/s_db.png" width="16" height="16" alt=""></td><td><a href="index.php?show=server_details$SID">$strDatabases</a></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_newdb.png" width="16" height="16" alt=""></td><td>$strActionCreateDbsTitle:</td></tr>
			<tr><td></td><td><form method="post" style="margin:0;" action="index.php?$SID"><input size=20 name="new_db"><input type="submit" name="confirm" value="$strCreateFormSubmit"></form></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_tblops.png" width="16" height="16" alt=""></td><td><a href="index.php?show=table_edit&choose_dir=$DB_ROOT$SID">TB Table Editor (No SQL)</a></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/s_asci.png" width="16" height="16" alt=""></td><td>[ <a href="../.errorlog" target="_blank" title="PHP Text Database Errorlog">Error Log</a> ]</td></tr>
			<tr><td><img class="icon" src="$templateroot/img/php_sym.png" width="16" height="16" alt=""></td><td><a href="includes/phpinfo.php" target="_blank" title="PHP Info">PHP Configuration Info</a></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/s_lang.png" width="16" height="16" alt=""></td><td><form method="post" style="margin:0;" action="index.php?$SID"><select name="set_language" onchange="this.form.submit();">$list_languages</select></form></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/s_theme.png" width="16" height="16" alt=""></td><td><form method="post" style="margin:0;" action="index.php?$SID">$strTemplates: <select name="set_template" onchange="this.form.submit();">$list_templates</select></form></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_docs.png" width="16" height="16" alt=""></td><td><a href="../manual/$lang/html/index.html" target="_blank" title="PHP Text Database API manual">PHP Text Database API manual</a></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_home.png" width="16" height="16" alt=""></td><td><a href="http://www.c-worker.ch" target="_blank" title="PHP Text Database API website">PHP Text Database API website</a></td></tr>
			<tr><td><img class="icon" src="$templateroot/img/b_tipp.png" width="16" height="16" alt=""></td><td>[ <a href="docs/CHANGELOG" target="_blank" title="Changelog">Changelog</a> ] [ <a href="docs/LICENSE" target="_blank" title="License">License</a> ] [ <a href="http://projects.p-act.net/download.php?file=php-txt-db-api-0.3.3-Beta-01_by_p.ACT!.zip" title="Zipfile Package">Package</a> ]</td></tr>
			<tr><td><img class="icon" src="$templateroot/img/s_loggoff.png" width="16" height="16" alt=""></td><td><a href="index.php?logout=1">LOGOUT</a></td></tr>

		</table>

$footinclude
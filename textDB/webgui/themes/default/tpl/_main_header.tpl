<html>

<!-- 
Copyright (c) p.ACT! Web Design 2007, TextDB webGUI version $txtdb_WEBGUI_version
-->

<head>
	<title>TextDB webGUI $txtdb_WEBGUI_version - $servername</title>
	<meta http-equiv="Content-Type" content="text/html; charset=$charset">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="$templateroot/css/style.css" type="text/css">
	<script type="text/javascript" src="scripts/functions.js"></script>
	<!--[if lte IE 7]>
	<script type="text/javascript" src="scripts/ie_hovers.js"></script>
	<script type="text/javascript" src="scripts/ie_selopt.js"></script>
	<![endif]-->
	<script type="text/javascript">
	<!--
	// set name to pageopener
	self.name = 'mainWindow';
	//-->
	</script>
</head>
<body bgcolor="{pagebgcolor}">

<table width="100%" height="96%" bgcolor="{tablebordercolor}">
<tr>
	<td bgcolor="{navibgcolor}" valign="top" width="160"><font face="{font}" color="{fontcolor}">
		<img src="images/spacer.png" width="160" height="10" alt="">
		<img src="images/spacer.png" width="10" height="5" alt="">
		<img src="images/webGUI_logo.jpg" alt=""><br>
		<img src="images/spacer.png" width="10" height="5" alt="">
		<hr class="hrclass_navi">
		<div id="mainlinks">
		<a href="index.php?$SID" title="Home"><img class="icon" src="$templateroot/img/b_home.png" width="16" height="16" alt="Home"></a>
		<a href="index.php?show=sql_window&db=$_GET[db]&tbl=$_GET[tbl]$SID" onClick="launchWindow('index.php?show=sql_window&db=$_GET[db]&tbl=$_GET[tbl]$SID','sqlWindow');return false;" target="_blank" title="SQL Query window"><img class="icon" src="$templateroot/img/b_sqlbox.png" width="16" height="16" alt="SQL Query window"></a>
		<a href="../manual/$lang/html/index.html" target="_blank" title="Php Text Database API manual"><img class="icon" src="$templateroot/img/b_docs.png" width="16" height="16" alt="Php Text Database API manual"></a>
		<a href="../manual/$lang/html/sql_limit.html" target="_blank" title="Php Text Database SQL syntax"><img class="icon" src="$templateroot/img/b_sqlhelp.png" width="16" height="16" alt="Php Text Database SQL syntax"></a>
		</div>
		<hr class="hrclass_navi"><br>
		<img src="images/spacer.png" width="2" height="1" alt="">
		$strDatabases:<br>
		<img src="images/spacer.png" width="1" height="5" alt="">
		<table width="100%" bgcolor="#D0DCE0" cellpadding="0" cellspacing="0">

$list_dbs

		</table>
		<br><hr class="hrclass_navi">
		<font size="1"><center>&copy; 2008 by <a href="http://www.p-act.net/" target="_blank">p-ACT!</center></a></font>
	</font></td>
	<td bgcolor="{mainbgcolor}" valign="top"><font face="{font}" color="{fontcolor}">
$gui_message

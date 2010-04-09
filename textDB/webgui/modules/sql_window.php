<?php
//////////////////////////////////////////////////////////////////////////////////
// Php Textfile DB WebGUI                                                       //
// Copyright 2007 - 2008 by Paul A. Canals y Trocha                             //
// p-ACT! Webdesign, http://www.p-act.net                                       //
//////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
// Redistribution and use in source and binary forms, with or without           //
// modification, are permitted provided that the following conditions are met:  //
// Redistributions of source code must retain the above copyright notice, this  //
// list of conditions and the following disclaimer.                             //
// Redistributions in binary form must reproduce the above copyright notice,    //
// this list of conditions and the following disclaimer in the documentation    //
// and/or other materials provided with the distribution.                       //
// THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"  //
// AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE    //
// IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE   //
// ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE     //
// LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR          //
// CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF         //
// SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS     //
// INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN      //
// CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)      //
// ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF       //
// THE POSSIBILITY OF SUCH DAMAGE.                                              //
//////////////////////////////////////////////////////////////////////////////////

if(!isset($_SESSION)) session_start();

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

$deflang = "lang/".get_languages( header, $default_language );
$posted = "";


#--------------------------------------------------------------------------------#
# ACTION: Lock SQL-Query in session memory
#--------------------------------------------------------------------------------#

if (isset($_POST['query']))
{
	if ($_POST['locked'])
	{
		$_SESSION['sql'] = $_POST['query'];
	}
}

// Call (locked) SQL-Query from session memory
$posted = isset($_SESSION['sql']) ? stripslashes($_SESSION['sql']) : '';


#--------------------------------------------------------------------------------#
# ACTION: UnLock SQL-Query from session memory
#--------------------------------------------------------------------------------#

if (isset($_POST['query']))
{
	if (!$_POST['locked'])
	{
		if (isset($_SESSION['sql'])) unset ($_SESSION['sql']);
	}
}

#--------------------------------------------------------------------------------#

// set locked to true if a query is saved in memory
$locked = isset($_SESSION['sql']) ? 'checked' : '';

// Set query target and initiate query form
if ($_GET['db'] != '')
{
	$detail = "database_details";
	$refers = $detail;
	$target = $_GET['db'];

	if ($_GET['tbl'] != '')
	{
		$select = "SELECT * FROM ".$_GET['tbl']." WHERE LIMIT 0,10";
		$posted = ($posted!='') ? $posted : $select;
		$detail = "table_details";
		$refers = $detail;
		$target = $_GET['tbl'];
	}
}
else {
	$detail = "server_details";
	$refers = $detail;
	$target = $servername;
}

#--------------------------------------------------------------------------------#
# Buildup fieldlist (getColumnNames)
#--------------------------------------------------------------------------------#

// TODO: when table is selected show selectlist with table fields to insert into
//       query textarea.

//if (($_GET['db'] != '') && ($_GET['tbl'] != ''))
//{
	//$db = new Database($_GET['db']);
	//$result = $db->executeQuery("SELECT * FROM ".$_GET['tbl']);
	//$Cnames = $result->getColumnNames();
	//unset($db);
//}
?>
<html>

<!-- 
Copyright (c) p.ACT! Web Design <?php echo date("Y").", TextDB webGUI version ".$txtdb_WEBGUI_version.", ".date("d.m.Y H:i", filemtime(__FILE__))."" . "\n"; ?>
-->

<head>
<title>SQL Query Window - <?php echo $target; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="<?php echo $templateroot; ?>/css/style.css" type="text/css">
<script type="text/javascript" language="JavaScript">
<!--
function notifyOpener() {
	try { if(self.opener || !self.opener.WindowObjectReference) self.opener.WindowObjectReference = self; }
	catch(err) { return true; }
}
setInterval( notifyOpener, 200 );

// Global variable
var u = navigator.userAgent.toLowerCase(); 

function setLock(form,query) {
	form.query.value = query;
	form.submit();
}

// Only works for IE & Mozilla / hide for all others
function renderWrap(title) { 
	if (u.indexOf('msie') > -1 || u.indexOf('gecko') > -1)
	{
		if (u.indexOf('windows') > -1)
		{
			document.write( title );
			document.write('<input');
			document.write(' type="checkbox"');
			document.write(' name="wrap"');
			document.write(' onclick="toggleWrap(this)"');
			document.write(' checked>');

			setTimeout('function(){toggleWrap(this.form)}',1);
		}
	}
}

function setWrap(val) {
	var s = document.forms[0].sql;

	s.wrap = val;

	if (u.indexOf('gecko') != -1) {
		var v = s.value;
		var n = s.cloneNode(false);
		n.setAttribute("wrap", val);
		s.parentNode.replaceChild(n, s);
		n.value = v;
	}
}

function toggleWrap(elm) {
	if (elm.checked)
		setWrap('soft');
	else
		setWrap('off');
}
//-->
</script>
</head>
<body bgcolor="#F5F5F5">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr><td align="left" valign="top">
		<div style="background-color:#E5E5E5;padding:10px;">
			<form name="sqlform" style="padding:0;margin:0;" action="index.php?show=sql_execute&db=<?php echo $_GET['db']; ?>&tbl=<?php echo $_GET['tbl'].$SID; ?>" method="post" target="mainWindow" onsubmit="if(!document.forms[0].reprint.checked)window.close();return true">
			<div style="position:absolute;top:12px;right:17px;"><script type="text/javascript" language="JavaScript">renderWrap('<?php echo $strSqlFormCheckWrap; ?>');</script></div>
			<b><?php echo $strSqlFormTitle; ?><a href="index.php?show=<?php echo $detail; ?>&db=<?php echo $_GET['db'] ?>&tbl=<?php echo $_GET['tbl'].$SID; ?>" target="mainWindow" title="">&nbsp;<?php echo $target; ?></a></b><br>
			<input type="hidden" name="referto" value="<?php echo $refers; ?>">
			<textarea wrap="" class="sqltext" name="sql" rows=8 cols=60><?php echo $posted; ?></textarea><br>
			<input type="checkbox" name="reprint" value="true" checked><?php echo $strSqlFormCheckBoxReprint; ?><br>
			<input type="submit" name="execute" value="<?php echo $strSqlFormSubmit; ?>"></form>
			<div style="position:absolute;top:184px;left:236px;">
			<form name="lock" action="index.php?show=sql_window&db=<?php echo $_GET['db']; ?>&tbl=<?php echo $_GET['tbl'].$SID; ?>" method="post">
			<input type="hidden" name="query" value="">
			<input type="checkbox" name="locked" onClick="setLock(this.form,document.sqlform.sql.value);" value="true" <?php echo $locked; ?>><?php echo $strSqlFormCheckBoxLocked; ?></form>
			</div>
		</div>
	</td></tr>
</table>

<script type="text/javascript" language="JavaScript">
<!--
document.forms[0].sql.select();
document.forms[0].sql.focus();
//-->
</script>

</body>
</html>
<?php
exit;
#--------------------------------------------------------------------------------#
?>
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

//////////////////////////////////////////////////////////////////////////////////
// Version 0.5a, last edited by pACT!, 20-02-2007 18:19 GMT                     //
// changed short tags to comply to PHP 5.0.2 standard                           //
//////////////////////////////////////////////////////////////////////////////////

if(!isset($_SESSION)) session_start();

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

$timeout  = 3600;     // inactivity session timeout length in seconds
$GUIuser  = array();
$doLogin  = true;
$deflang  = "lang/".get_languages( header, $default_language );


#--------------------------------------------------------------------------------#
# Login user/pass
#--------------------------------------------------------------------------------#

$GUIuser[0]['username'] = "admin";
$GUIuser[0]['password'] = "smiccy";

//$GUIuser[1]['username'] = "[name]";
//$GUIuser[1]['password'] = "[pass]";



#--------------------------------------------------------------------------------#
# Check if logout is set
#--------------------------------------------------------------------------------#

if ( isset($_GET['logout']) && $_GET['logout'] == '1' )
{
	if (isset($_SESSION["USERNAME"])) unset($_SESSION["USERNAME"]);
	if (isset($_SESSION["PASSWORD"])) unset($_SESSION["PASSWORD"]);
}

#--------------------------------------------------------------------------------#
# Check Session status
#--------------------------------------------------------------------------------#

if ( isset($_POST['username']) && isset($_POST['password']) )
{	
	$username = $_POST['username'];
	$password = $_POST['password'];

	// avoid unwanted page refresh with POST vars
	unset($_POST['username']);
	unset($_POST['password']);

	$language = $deflang;
	$timestamp = time();
	$phpself = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
	$querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';

	$_SESSION["USERNAME"] = $username;
	$_SESSION["PASSWORD"] = $password;
	$_SESSION["LANGUAGE"] = $language;
	$_SESSION["TIMESTAMP"] = time();
} 
else
{
	$username = isset($_SESSION['USERNAME']) ? $_SESSION['USERNAME'] : '';
	$password = isset($_SESSION['PASSWORD']) ? $_SESSION['PASSWORD'] : '';
	$language = isset($_SESSION['LANGUAGE']) ? $_SESSION['LANGUAGE'] : $deflang;
	$timestamp = isset($_SESSION['TIMESTAMP']) ? $_SESSION['TIMESTAMP'] : '';
	$phpself = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
	$querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
}

if ( $username != '' && $password != '' )
{
	for ($i = 0; $i < count($GUIuser); $i++)
	{
		if ($GUIuser[$i]['username'] == $username && $GUIuser[$i]['password'] == $password)
		{
			// login accepted
			$doLogin = false;
		}
	}

	if (time() - $timestamp > $timeout)
	{
		// session timed out
		$doLogin = true;
	}

	if (!$doLogin)
	{
		$_SESSION['TIMESTAMP'] = time();
	}
}


#--------------------------------------------------------------------------------#
# Inlude language file
#--------------------------------------------------------------------------------#

include_once($language);
include_once($layout);

#--------------------------------------------------------------------------------#
# Login form
#--------------------------------------------------------------------------------#

if ($doLogin) {

?>
<html>
<head>
<title>TextDB webGUI <?php echo $txtdb_WEBGUI_version; ?></title>
<style>
body, p, td, tr, table, input { font-family: verdana, arial, helvetica; color: #0B5979; font-size: 12px;}
.title { font-size: 26px; font-weight: bold;}
</style>
</head>
<body>
<form action="<?php echo $phpself; ?>?<?php echo $querystring; ?>" method="post">
	<table width="100%" height="95%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td align="center" valign="middle">
				<div style="text-align: left; border: solid #0B5979 1px; width: 300px; height: 180px; background-color: #D0DCE0;">
					<table width="300" height="180" cellspacing="5" cellpadding="5" border="0">
					<tr><td valign="top" colspan="2"><span class="title">WebGUI Login</span></td></tr>
					<tr><td width="70"><?php echo $strUser; ?>:</td><td><input name="username"></td></tr>
					<tr><td width="70"><?php echo $strPass; ?>:</td><td><input name="password" type="password"></td></tr>
					<tr><td colspan="2"><input type="submit" name="submitted" value="Login"></td></tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</form>


<SCRIPT LANGUAGE="JavaScript">
<!--
document.forms[0].username.select();
document.forms[0].username.focus();
//-->
</SCRIPT>
</body>
</html>

<?php

exit;
} // login

#--------------------------------------------------------------------------------#
?>

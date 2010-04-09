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

@session_start();

#--------------------------------------------------------------------------------#
# Main Includes
#--------------------------------------------------------------------------------#

include_once("config.php");
include_once("includes/functions.php");
include_once("includes/language_detection.php");
include_once("includes/sql_highlight.php");
include_once("includes/portal.php");
include_once($txtdbapi);


#--------------------------------------------------------------------------------#
# Verify SESSION_USE_TRANS_SID status
#--------------------------------------------------------------------------------#

$SID = ''; if(!ini_get('session.use_trans_sid')) $SID = "&".session_name()."=".session_id();


#--------------------------------------------------------------------------------#
# Initialise variables
#--------------------------------------------------------------------------------#

$api_vers = txtdbapi_version();
$php_vers = phpversion();

// Set servername
$servername = $_SERVER['SERVER_NAME'];

// Set DB root for TB Editor
$DB_ROOT = realpath($DB_DIR);

$gui_message = "";
$jscripts = "";
$list_dbs = "";


#--------------------------------------------------------------------------------#
# USER SUBMIT/SET: set language file
#--------------------------------------------------------------------------------#

if (isset($_POST['set_language']))
{
	$language = $_POST['set_language'];
	$_SESSION['LANGUAGE'] = $language;
}

if (isset($_SESSION['LANGUAGE'])) $language = $_SESSION['LANGUAGE'];

// Set language file for textdbapi manual
$lang = "eng"; if (preg_match('/ger/', $language)) $lang = "de";


#--------------------------------------------------------------------------------#
# USER SUBMIT/SET: set template file
#--------------------------------------------------------------------------------#

if (isset($_POST['set_template']))
{
	$templateroot = $_POST['set_template'];
	$templatepath = $templateroot."/tpl";
	$_SESSION['template_root'] = $templateroot;
	$_SESSION['template_path'] = $templatepath;
}

if (isset($_SESSION['template_root'])) $templateroot = $_SESSION['template_root'];
if (isset($_SESSION['template_path'])) $templatepath = $_SESSION['template_path'];


#--------------------------------------------------------------------------------#
# Create DB
#--------------------------------------------------------------------------------#

if (isset($_POST['new_db']) && $_POST['confirm'] == $strCreateFormSubmit)
{
	$db = new Database(ROOT_DATABASE);
	$query = "CREATE DATABASE ".$_POST['new_db'];

	$message = $strDatabaseCreateMessageFailure;
	$sql_query = stripped_highlight_sql($query);
        
	if ($db->executeQuery($query))
	{
		$_GET['show'] = "database_details";
		$_GET['db'] = $_POST['new_db'];
		$message = $strDatabaseCreateMessageSuccess;
	}
	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");        
	unset($db);
}


#--------------------------------------------------------------------------------#
# Delete DB
#--------------------------------------------------------------------------------#

if (isset($_GET['delete_db']))
{
	if (isset($_POST['confirm'])) if ($_POST['confirm'] == $strSubmit)
	{
		$db = new Database(ROOT_DATABASE);
		$query = "DROP DATABASE ".$_GET['delete_db'];
        
		$message = $strDatabaseDeleteMessageFailure;
		$sql_query = stripped_highlight_sql($query);

		if ($db->executeQuery($query))
		{
			$message = $strDatabaseDeleteMessageSuccess;
		}
		eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
		unset($db);
	}
	else {
		$_GET['show'] = "database_details";
		$_GET['db'] = $_GET['delete_db'];
	}
}


#--------------------------------------------------------------------------------#
# Include Database, Language and Template lists
#--------------------------------------------------------------------------------#

include("includes/list_databases.php");
include("includes/list_languages.php");
include("includes/list_templates.php");


#--------------------------------------------------------------------------------#
# Include Page title
#--------------------------------------------------------------------------------#

if ($_GET['show'] == "server_details")
{
	eval ("\$gui_message .= \"".gettemplate("_main_title_server_bit")."\";");
}

if (isset($_GET['db']) && $_GET['db'] != '')
{
	if (isset($_GET['tbl']) && $_GET['tbl'] != '')
	{
		eval ("\$gui_message .= \"".gettemplate("_main_title_table_bit")."\";");
	}
	else {
		eval ("\$gui_message .= \"".gettemplate("_main_title_database_bit")."\";");
	}
}


#--------------------------------------------------------------------------------#
# Include Page header/footer
#--------------------------------------------------------------------------------#

eval ("\$headinclude = \"".gettemplate("_main_header")."\";");
eval ("\$footinclude = \"".gettemplate("_main_footer")."\";");


#--------------------------------------------------------------------------------#
# Include Main Page
#--------------------------------------------------------------------------------#

$mainpage = "main.php";

if(isset($_GET['show'])) $mainpage = "modules/" . $_GET['show'] . ".php";

include($mainpage);

#--------------------------------------------------------------------------------#
?>
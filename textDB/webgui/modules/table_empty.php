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
// 22-02-2007 BugFix: Fixed losing default values after empty command           //
// 15-02-2007 BugFix: changed ".txt" by TABLE_FILE_EXT                          //
// 15-02-2007 Added Security (PHP DB Files with 404 Header)                     //
//////////////////////////////////////////////////////////////////////////////////

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

$db = new Database($_GET['db']);
$message = "";
$sql_query = "";

#--------------------------------------------------------------------------------#
# Process: Empty Table and return database_details page
#--------------------------------------------------------------------------------#
// 22-02-2007 Fixed losing default values after empty command
if (isset($_GET['empty'])) if ($_GET['empty'] == "true" && $_POST['confirm'] == $strSubmit)
{
	$result = $db->executeQuery("SELECT * FROM ".$_GET['empty_tbl']);

	$colnames = $result->getColumnNames();
	$coltypes = $result->getColumnTypes();
	$coldvals = $result->getColumnDefaultValues();

	$fields = array();

	for ($i = 0; $i < count($colnames); $i++)
	{
		$colname  = $colnames[$i];
		$coltype  = $coltypes[$i];
		$coldval  = $coldvals[$i]; 
		$fields[] = $colname . " " . $coltype . " DEFAULT '" . $coldval . "'";
	}

	$fields = implode(",", $fields);

	$query = "CREATE TABLE ".$_GET['empty_tbl']." (".$fields.")";

	$message = $strTableEmptyMessageFailure;
	$sql_query = highlight_sql("DELETE FROM $_GET[empty_tbl]");

	if(@unlink($DB_DIR.$_GET['db']."/".$_GET['empty_tbl'].TABLE_FILE_EXT)) // BugFix: changed ".txt" by TABLE_FILE_EXT
	{
		$result = $db->executeQuery($query);
		if ($result)
		{
			$message = $strTableEmptyMessageSuccess;
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=database_details&db=$_GET[db]$SID");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Confirm to empty Table, returns table_empty page
#--------------------------------------------------------------------------------#

eval ("dooutput(\"".gettemplate("table_empty_confirm")."\");");


#--------------------------------------------------------------------------------#
# Clean vars from session memory
#--------------------------------------------------------------------------------#

if (isset($_POST['confirm'])) unset($_POST['confirm']);

#--------------------------------------------------------------------------------#
?>
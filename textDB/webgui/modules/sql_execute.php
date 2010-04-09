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

#--------------------------------------------------------------------------------#
# Process: SQL Queries,  returns data and status messages to gui
#--------------------------------------------------------------------------------#

$query = stripslashes($_POST['sql']);

if (strtoupper(substr($query, 0, 6)) == "SELECT")
{
	include('sql_select.php');
}
else {

	if ($_GET['db'] == '')
	{
		$db = new Database(ROOT_DATABASE);
	} else {
		$db = new Database($_GET['db']);
	}

	$singleQueries = splitSql($query);
	$num_queries = count($singleQueries);
	$sql_query = stripped_highlight_sql(preg_replace('/\"/','\'',$query));

	for ($i = 0; $i < $num_queries; $i++)
	{
		$query = $singleQueries[$i];
		$message = $strSqlExecuteMessageFailure;
	
		if ($result = $db->executeQuery($query))
		{
			if ($result)
			{
				$message = $strSqlExecuteMessageSuccess;
			}
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");

	unset ($db);

	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=$_POST[referto]&db=$_GET[db]&tbl=$_GET[tbl]$SID");
	exit();
}
#--------------------------------------------------------------------------------#
?>
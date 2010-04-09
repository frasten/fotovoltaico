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
# Initialise vars
#--------------------------------------------------------------------------------#

$db = new Database($_GET['db']);


#--------------------------------------------------------------------------------#
# Process: Edit Column in Table and return table_details page
#--------------------------------------------------------------------------------#

if (isset($_GET['add'])) if ($_GET['add'] == "true" && $_POST['confirm'] == $strAddFormSubmit)
{
	// set column position (first/last/after)
	if ($_POST['field_where'] == 'after')
	{
		if ($_POST['after_field'] != '') $position = "AFTER " . $_POST['after_field'];
	}
	else
	{
		$position = ($_POST['field_where'] == 'first') ? "FIRST" : "";
	}

	// set default value for column name
	// STR and NULL = 'NULL'
	// INT and NULL = '0'
	// 
	if ($_POST[new_fnull] == 'NULL')
	{
		$fvalue = ($_POST[new_ftype] == 'str') ? 'NULL' : '0';
	} else {
		$fvalue = $_POST[new_fdval];
	}

	$query  = "ALTER TABLE ".$_GET['tbl']." ADD COLUMN (".$_POST['new_fname']." ".$_POST['new_ftype']." DEFAULT '".addslashes($fvalue)."' ".$position.");";

	$singleQueries = splitSql($query);
	$num_queries = count($singleQueries);
	$sql_query = stripped_highlight_sql($query);

	for ($i = 0; $i < $num_queries; $i++)
	{
		$query = $singleQueries[$i];
		$message = $strColumnEditMessageFailure;

		if ($result = $db->executeQuery($query))
		{
			if ($result)
			{
				$message = $strColumnEditMessageSuccess;
			}
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Confirm edit Column in Table, returns column_edit page
#--------------------------------------------------------------------------------#

// disable auto_inc option for all but first column
$disabled = ($_POST['field_where'] != 'first') ? 'disabled' : '';

eval("dooutput(\"".gettemplate("column_add_confirm")."\");");

#--------------------------------------------------------------------------------#
?>
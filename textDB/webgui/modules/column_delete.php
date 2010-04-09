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
# Process: Delete Column from Table and return table_details page
#--------------------------------------------------------------------------------#

if (isset($_GET['delete'])) if ($_GET['delete'] == "true" && $_POST['confirm'] == $strSubmit)
{
	$query = "ALTER TABLE ".$_GET['tbl']." DROP COLUMN ".addslashes($_GET['col']);

	$message = $strColumnDeleteMessageFailure;
	$sql_query = stripped_highlight_sql($query);

	if ($result = $db->executeQuery($query))
	{
		if ($result)
		{
			$message = $strColumnDeleteMessageSuccess;
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Confirm delete Column from Table, returns column_delete page
#--------------------------------------------------------------------------------#

eval("dooutput(\"".gettemplate("column_delete_confirm")."\");");

#--------------------------------------------------------------------------------#
?>
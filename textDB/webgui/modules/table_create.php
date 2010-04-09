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
// 14/02/2008 - Fixed bug where PHP throws an error when $_POST['numf'] < 1     //
// 25/03/2007 - Added primary key value to first table field                    //
//////////////////////////////////////////////////////////////////////////////////

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

$db = new Database($_GET['db']);


#--------------------------------------------------------------------------------#
# Process: Create new Table and return table_details page
#--------------------------------------------------------------------------------#

if (isset($_GET['create'])) if ($_GET['create'] == "true" && isset($_POST['numf']))
{
	$query = "CREATE TABLE ".$_GET['tbl']." (";

	$tmp_fields = array();

	// Bugfix 14-02-2008
	if ($_POST['numf'] < 1) $_POST['numf'] = 1;

	for ($i = 1; $i <= $_POST['numf']; $i++) {
		$fname = "fname".$i;
		$ftype = "ftype".$i;
		$fnull = "fnull".$i;
		$fdval = "fdval".$i;

		// set default value for column name
		// STR and NULL = 'NULL'
		// INT and NULL = '0'
		// 
		if ($_POST[$fnull] == 'NULL')
		{
			$fvalue = ($_POST[$ftype] == 'str') ? 'NULL' : '0';
		} else {
			$fvalue = $_POST[$fdval];
		}
		
		$tmp_fields[] = $_POST[$fname]." ".$_POST[$ftype]." DEFAULT '".$fvalue."'";
	}
	
	$sql_fields = implode(",", $tmp_fields);

	$query .= $sql_fields . ");";

	$message = $strTableCreateMessageFailure;
	$sql_query = stripped_highlight_sql($query);

	if ($result = $db->executeQuery($query))
	{
		if ($result)
		{
			$message = $strTableCreateMessageSuccess;
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Create Table FORM, returns table_create page
#--------------------------------------------------------------------------------#

if (isset($_POST['confirm']) && ($_POST['confirm'] == $strCreateFormSubmit))
{
	$tbl_list_fields = "";
	$gui_message2 = "";

	$phase = "{tablea}";

	$numf = ($_POST['new_table_numf'] < 1) ? 1 : $_POST['new_table_numf'];

	for ($i = 1; $i <= $numf; $i++)
	{
		$fieldname = "fname".$i;
		$fieldtype = "ftype".$i;
		$fieldnull = "fnull".$i;
		$fielddval = "fdval".$i;

		
		if ($i == 1) // primary key (AUTO_INC)
		{
			eval ("\$tbl_list_fields .= \"".gettemplate("table_create_key")."\";");
		}
		else {
			eval ("\$tbl_list_fields .= \"".gettemplate("table_create_bit")."\";");
		}
		$phase = nextPhase($phase);
	}

	eval("dooutput(\"".gettemplate("table_create")."\");");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Confirm Create Table FORM, returns table_create page
#--------------------------------------------------------------------------------#

eval("dooutput(\"".gettemplate("table_create_confirm")."\");");

#--------------------------------------------------------------------------------#
?>
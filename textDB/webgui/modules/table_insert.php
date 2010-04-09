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
// 26-02-2007 Added: Function select options at input                           //
// 26-02-2007 Added: Write DEFAULT value when INSERT field value is empty       //
// 19-02-2007 Added: DEFAULT field value                                        //
// 15-02-2007 Fixed: increment index key value                                  //
//////////////////////////////////////////////////////////////////////////////////

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

$db = new Database($_GET['db']);


#--------------------------------------------------------------------------------#
# Process: Insert new Row into Table and returns table_details page
#--------------------------------------------------------------------------------#

if (isset($_GET['insert'])) if ($_GET['insert'] == "true" && isset($_POST['numf']))
{
	$query = "INSERT INTO ".$_GET['tbl']." SET ";

	$tmp_fields = array();

	$result = $db->executeQuery("SELECT * FROM ".$_GET['tbl']);

	$colnames = $result->getColumnNames();
	$coltypes = $result->getColumnTypes();
	$coldvals = $result->getColumnDefaultValues();

	for ($i = 0; $i < $_POST['numf']; $i++)
	{
		// BugFix: increment index key value
		if ($coltypes[$i] != "inc")
		{
			$dvalue = "field_default_".$i;
			$ffunct = "field_function_".$i;
			$fvalue = "field_value_".$i;

			// 26-02-2007 Added: Write DEFAULT value when INSERT field value is empty
			// set value for column name
			// STR and dvalue=NULL = 'NULL'
			// INT and fvalue=NULL = '0'
			// 
			if($_POST[$dvalue] == 'NULL')
			{
				$input_value = ($coltypes[$i] == 'str') ? 'NULL' : '0';
			} else {
				$input_value = "'" .addslashes($_POST[$fvalue])."'";
			}

			// set function for column value
			if ($_POST[$ffunct] != '')
			{
				$input_value = $_POST[$ffunct]."(".addslashes($_POST[$fvalue]).")";
			}

			$tmp_fields[] = $colnames[$i]."=".$input_value;
		}
	}
	
	$sql_fields = implode(",", $tmp_fields);

	$query .= $sql_fields;

	$message = $strTableInsertMessageFailure;
	$sql_query = stripped_highlight_sql($query);

	if ($result = $db->executeQuery($query))
	{
		if ($result)
		{
			$message = $strTableInsertMessageSuccess;
		}
	}

	eval ("\$gui_message2 .= \"".gettemplate("sql_result_message")."\";");
	$_SESSION['gui_message2'] = $gui_message2;
	header("Location: index.php?show=table_details&db=$_GET[db]&tbl=$_GET[tbl]$SID");
	exit();
}


#--------------------------------------------------------------------------------#
# Process: Insert new row Form, returns table_insert page
#--------------------------------------------------------------------------------#

$tbl_list_fields = "";
$gui_message2 = "";

$phase = "{tablea}";

$result = $db->executeQuery("SELECT * FROM ".$_GET['tbl']);

$colnames = $result->getColumnNames();
$coltypes = $result->getColumnTypes();
$coldvals = $result->getColumnDefaultValues();

$numf = count($colnames);

for ($i = 0; $i < count($colnames); $i++)
{
	$colname = $colnames[$i];
	$coltype = strtoupper($coltypes[$i]);
	$coldval = '';

	$default = addslashes($coldvals[$i]);

	$fieldtype     = "field_type_".$i;
	$fieldfunction = "field_function_".$i;
	$fielddefault  = "field_default_".$i;
	$fieldvalue    = "field_value_".$i;

	$default_value = $default;
	$disabled_dval = ($coltype == 'STR' && $default == 'NULL') ? 'disabled' : '';
	$fnull_checked = ($coltype == 'STR' && $default == 'NULL') ? 'checked' : '';


	if ($coltype == 'STR') eval ("\$coldval = \"".gettemplate("table_insert_null")."\";");
	if ($coltype == 'INC') eval ("\$tbl_list_fields .= \"".gettemplate("table_insert_key")."\";");
	if ($coltype != 'INC') eval ("\$tbl_list_fields .= \"".gettemplate("table_insert_bit")."\";");
	
	$phase = nextPhase($phase);
}

eval("dooutput(\"".gettemplate("table_insert")."\");");

#--------------------------------------------------------------------------------#
?>
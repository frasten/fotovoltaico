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
//                                                                              //
//////////////////////////////////////////////////////////////////////////////////

#--------------------------------------------------------------------------------#
# Initialise vars
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) $gui_message2 = $_SESSION['gui_message2'];

$db = new Database($_GET['db']);


#--------------------------------------------------------------------------------#
# Process: Table Column details, returns table structure page
#--------------------------------------------------------------------------------#

$col_option_list = "";
$phase = "{tablea}";
$tbl_list_fields = "";

$result = $db->executeQuery("SELECT * FROM ".$_GET['tbl']);

$colnames = $result->getColumnNames();
$coltypes = $result->getColumnTypes();
$coldvals = $result->getColumnDefaultValues();

for ($i = 0; $i < count($colnames); $i++)
{
	$colname = $colnames[$i];
	$coltype = strtoupper($coltypes[$i]);

	if ($coldvals[$i] == '')
	{
		$coldval = 'NOT_NULL';
	} else {
		$coldval = $coldvals[$i];
	}

	if ($coltype == 'INC') eval ("\$tbl_list_fields .= \"".gettemplate("table_details_tbl_key")."\";");
	if ($coltype == 'INT') eval ("\$tbl_list_fields .= \"".gettemplate("table_details_tbl_int")."\";");
	if ($coltype == 'STR') eval ("\$tbl_list_fields .= \"".gettemplate("table_details_tbl_str")."\";");	

	// build column list for add column option
	eval ("\$col_option_list .= \"".gettemplate("column_add_optionlist")."\";");

	$phase = nextPhase($phase);
}

if ($tbl_list_fields == "") eval ("\$tbl_list_fields = \"".gettemplate("table_details_tbl_invalid")."\";");
if (!isset($gui_message2)) $gui_message2 = "";
if (!isset($_POST['sql'])) $posted_query = "";

eval("dooutput(\"".gettemplate("table_details")."\");");


#--------------------------------------------------------------------------------#
# Clean vars from session memory
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) unset($_SESSION['gui_message2']);

#--------------------------------------------------------------------------------#
?>
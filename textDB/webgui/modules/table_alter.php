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
# Process: Alter or drop a row in a Table, returns table_detail page
#--------------------------------------------------------------------------------#

$db = new Database($_GET['db']);

$tbl_list_fields = "";
$gui_message2 = "";

$phase = "{tablea}";

$result = $db->executeQuery("SELECT * FROM ".$_GET['tbl']);

$colnames = $result->getColumnNames();
$coltypes = $result->getColumnTypes();

$numf = count($colnames);

for ($i = 0; $i < count($colnames); $i++)
{
	$colname = $colnames[$i];
	$coltype = $coltypes[$i];
	$fieldname = "in_field".$i;

	if (($i == 0) && ($coltype == 'inc'))
	{
		eval ("\$tbl_list_fields .= \"".gettemplate("table_insert_key")."\";");
	} else {
		eval ("\$tbl_list_fields .= \"".gettemplate("table_insert_bit")."\";");
	}

	$phase = nextPhase($phase);
}

eval("dooutput(\"".gettemplate("table_insert")."\");");

#--------------------------------------------------------------------------------#
?>
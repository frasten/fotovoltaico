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
# Initialise Variables
#--------------------------------------------------------------------------------#

$table_size = 0;


#--------------------------------------------------------------------------------#
# Initialise System Message
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) $gui_message2 = $_SESSION['gui_message2'];


#--------------------------------------------------------------------------------#
# Process: Collect DB data and show DB details page
#--------------------------------------------------------------------------------#

$tbl_handle = opendir($DB_DIR . $_GET['db']);
$phase = "{tablea}";
$db_list_tbls = "";

while (false !== ($tbl_file = readdir($tbl_handle)))
{
	if($tbl_file=='.'||$tbl_file=='..') continue;
				
	$extension = substr($tbl_file, -4, 4);

	if ($extension == TABLE_FILE_EXT) { // BugFix: changed ".txt" by TABLE_FILE_EXT
		$basename = substr($tbl_file, 0, strlen($tbl_file) - 4);

		$table_content = file($DB_DIR.$_GET['db']."/".$tbl_file);  // performance improvement by mario
		$table_lastmod = date('d-m-Y H:i', filemtime($DB_DIR.$_GET['db']."/".$tbl_file));
		$table_size = filesize($DB_DIR.$_GET['db']."/".$tbl_file);
		$table_size = convertSize($table_size);
		$num_rows = count($table_content) - 4; // BugFix: Added Security (PHP DB Files with 404 Header) 

		eval ("\$db_list_tbls .= \"".gettemplate("database_details_tbls_bit")."\";");
		$phase = nextPhase($phase);
	}
}

if ($db_list_tbls == "") eval ("\$db_list_tbls = \"".gettemplate("database_details_tbls_empty")."\";");
if (!isset($gui_message2)) $gui_message2 = "";
if (isset($_POST['sql'])) $posted_query = $_POST['sql'];

eval("dooutput(\"".gettemplate("database_details")."\");");


#--------------------------------------------------------------------------------#
# Clean vars from session memory
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) unset($_SESSION['gui_message2']);

#--------------------------------------------------------------------------------#
?>
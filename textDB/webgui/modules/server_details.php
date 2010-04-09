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
// 01-03-2007 Initial version                                                   //
//////////////////////////////////////////////////////////////////////////////////

#--------------------------------------------------------------------------------#
# Initialise Variables
#--------------------------------------------------------------------------------#




#--------------------------------------------------------------------------------#
# Initialise System Message
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) $gui_message2 = $_SESSION['gui_message2'];


#--------------------------------------------------------------------------------#
# Process: Collect Server DB data and show Server DB details page
#--------------------------------------------------------------------------------#

$db_handle = opendir($DB_DIR);
$phase = "{tablea}";
$server_list_dbs = "";

while (false !== ($db_file = readdir($db_handle)))
{
	if($db_file=='.'||$db_file=='.htaccess'||$db_file=='..') continue;

	if(is_dir($DB_DIR.$db_file))
	{
		$databasename = $db_file;
		$db_lastmod = date('d-m-Y H:i', filemtime($DB_DIR.$db_file));
	
		$tbl_handle = opendir($DB_DIR . $db_file);

		// initialise totals
		$total_size = 0;
		$total_rows = 0;
		$total_tabl = 0;
		$table_size = 0;

		while (false !== ($tbl_file = readdir($tbl_handle)))
		{
			if($tbl_file=='.'||$tbl_file=='..') continue;
				
			$extension = substr($tbl_file, -4, 4);

			if ($extension == TABLE_FILE_EXT) // BugFix: changed ".txt" by TABLE_FILE_EXT
			{
				$table_content = file($DB_DIR.$db_file."/".$tbl_file);  // performance improvement by mario
				$total_size = $total_size + filesize($DB_DIR.$db_file."/".$tbl_file);
				$num_rows = count($table_content) - 4; // BugFix: Added Security (PHP DB Files with 404 Header) 
				$total_rows = $total_rows + $num_rows;
				$total_tabl++;
			}
		}
		$total_size = convertSize($total_size);
		eval ("\$server_list_dbs .= \"".gettemplate("server_details_db_bit")."\";");
		$phase = nextPhase($phase);
	}
}

if ($server_list_dbs == "") eval ("\$server_list_dbs = \"".gettemplate("server_details_db_empty")."\";");

eval("dooutput(\"".gettemplate("server_details")."\");");


#--------------------------------------------------------------------------------#
# Clean vars from session memory
#--------------------------------------------------------------------------------#

if (isset($_SESSION['gui_message2'])) unset($_SESSION['gui_message2']);

#--------------------------------------------------------------------------------#
?>
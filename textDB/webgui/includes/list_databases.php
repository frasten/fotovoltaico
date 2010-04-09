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
# Script to enlist all available databases
# fallback included to non-SQL-approach (SQL not implemented!)
#--------------------------------------------------------------------------------#

$db_handle = opendir($DB_DIR);
if (!isset($_GET['db'])) $_GET['db'] = " ";

while (false !== ($db_file = readdir($db_handle)))
{ 

	if($db_file=='.'||$db_file=='..') continue; 
	
	if(is_dir($DB_DIR.$db_file))
	{
		if ($db_file == $_GET['db'])
		{
			// actual DB, show Table list
			eval ("\$list_dbs .= \"".gettemplate("_navi_db_list")."\n\";");

			$tbl_handle = opendir($DB_DIR . $db_file);

			while (false !== ($tbl_file = readdir($tbl_handle)))
			{
				if ($tbl_file=='.'||$tbl_file=='..') continue;
				
				$extension = substr($tbl_file, -4, 4);

				if ($extension == ".php")
				{
					$basename = substr($tbl_file, 0, strlen($tbl_file) - 4);
					eval ("\$list_dbs .= \"".gettemplate("_navi_tbl_list")."\";");
				}
			}

			eval ("\$list_dbs .= \"\";");

		} else {
			// list other non-relevant DB's
			eval ("\$list_dbs .= \"".gettemplate("_navi_db_list")."\";");
		}
	}
}

if ($_GET['db'] == " ") unset($_GET['db']);

#--------------------------------------------------------------------------------#
?>
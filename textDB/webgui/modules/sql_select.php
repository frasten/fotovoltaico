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
# Process: SQL SELECT Query,  returns data and status messages to gui
#--------------------------------------------------------------------------------#

$db = ($_GET['db'] == '') ? new Database(ROOT_DATABASE) : new Database($_GET['db']);

// TODO: to be implemented in the next release
// if (isset($_POST['o'])) $LIMIT_OFFSET = $_POST['o'];
// if (isset($_POST['l'])) $LIMIT_RESULT = $_POST['l'];

$query = isset($_POST['sql']) ? stripslashes($_POST['sql']) : "SELECT * FROM ".$_GET['tbl']." LIMIT ".$LIMIT_OFFSET.",".$LIMIT_RESULT;

$use_limit = stristr($query, "limit") ? true : false;

$singleQueries = splitSql($query);
$num_queries = count($singleQueries);
$sql_query = stripped_highlight_sql(preg_replace('/\"/','\'',$query));

$total = 0;

$tbl_view_rows = "";

for ($j = 0; $j < $num_queries; $j++)
{
	$localTotal = 0;

	$query = $singleQueries[$j];
	$message = $strSqlSelectMessageFailure;

	if ($result = $db->executeQuery($query))
	{
		if ($result)
		{
			$message = $strSqlSelectMessageSuccess;

			$phase = "{tablec}";
			$class = "";

			$tbl_view_cols = "";

			$list_colnames = $result->getColumnNames();
			$numfields = count($list_colnames);

			for ($i = 0; $i < $numfields; $i++)
			{
				$field = $list_colnames[$i];
				eval ("\$tbl_view_cols .= \"".gettemplate("table_view_colbit")."\";");
			}

			eval ("\$tbl_view_rows .= \"".gettemplate("table_view_rowbit")."\";");

			$phase = "{tablea}";
			$class = "row";

			while ($result->next())
			{
				$tbl_view_cols = "";
				$row = $result->getCurrentValues();

				for ($i = 0; $i < count($row); $i++)
				{
					$field = $row[$i];
					eval ("\$tbl_view_cols .= \"".gettemplate("table_view_colbit")."\";");
				}

				eval ("\$tbl_view_rows .= \"".gettemplate("table_view_rowbit")."\";");

				$phase = nextPhase($phase);
				$localTotal++;
			}

			if ($localTotal == 0)
			{
				eval ("\$tbl_view_rows .= \"".gettemplate("table_view_empty")."\";");
			}

			eval ("\$tbl_view_rows .= \"".gettemplate("table_view_endbit")."\";");

			$total += $localTotal;
		}

	} else {
		// Query error: show error message (db or tble not found)
		eval ("\$gui_message2 = \"".gettemplate("sql_result_message")."\";");
		$_SESSION['gui_message2'] = $gui_message2;
		header("Location: index.php?show=$_POST[referto]$SID");
		exit();
	}
}

if (!isset($gui_message2)) $gui_message2 = " ";

eval("dooutput(\"".gettemplate("sql_select_message")."\");");

#--------------------------------------------------------------------------------#
?>
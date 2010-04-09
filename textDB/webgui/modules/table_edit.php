<?php 
//////////////////////////////////////////////////////////////////////////////////
// TBedit.php                                                                   //
// Copyright 2005-2007 by c-worker, http://www.c-worker.ch                      //
// 2007 edited by p-ACT! Webdesign, http://www.p-act.net                        //
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

// Include page header
echo dooutput($headinclude);

// title
echo "\t\t<h2>TDedit Table Editor</h2>\n";

echo "\t\t<font size='1' face='Verdana, Arial'>\n";

// magic quotes
// echo "\t\t<b>magic_quotes_gpc:</b> " .get_magic_quotes_gpc() . "<br>\n";

// version 
echo "\t\t<b>text-db-api version:</b> " . txtdbapi_version() . "<br>\n"; 


// table file 
if(isset($_GET['table_file']) && $_GET['table_file'])
{ 
	$table_file=$_GET['table_file']; 
	$_SESSION['table_file']=$table_file; 
	$_SESSION['mode']='edit_table'; 
} 
else if(isset($_SESSION['table_file']))
{ 
	$table_file=$_SESSION['table_file']; 
} else { 
	$table_file="<none>"; 
} 
echo "\t\t<b>table_file:</b> " . $table_file . "<br>\n"; 


// mode 
if(isset($_POST['mode']))
{ 
	$mode=$_POST['mode']; 
	$_SESSION['mode']=$mode; 
}
else if(!isset($_SESSION['mode']))
{ 
	$mode='choose_table'; 
	$_SESSION['mode']=$mode; 
} else { 
	$mode=$_SESSION['mode']; 
} 
echo "\t\t<b>mode:</b> " . $mode . "</font><br><hr class=\"hrclass_main\">\n"; 

// choose_table 
if($mode=='choose_table')
{ 
	if(isset($_GET['choose_dir']))
	{ 
        	$choose_dir=realpath((sec_stripslashes($_GET['choose_dir']))); 
	}
	else if(isset($_SESSION['choose_dir']))
	{ 
		$choose_dir=$_SESSION['choose_dir']; 
	} else { 
		$choose_dir=$DB_ROOT;
	} 
	$_SESSION['choose_dir']= $choose_dir; 
    
	if(isset($_GET['delete_table']))
	{
		unlink($_GET['delete_table']); 
	}

	if(isset($_GET['rename_table']))
	{ 
		if(isset($_GET['new_name']))
		{ 
			rename($choose_dir . "/" . $_GET['rename_table'],$choose_dir . "/" . $_GET['new_name']); 
		} else { 
			echo "\t\t<form name=\"form_ren\" method=\"get\" action=\"" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID\">\n"; 
			echo "\t\t<input name='new_name' type='text' id='new_name' value='" . $_GET['rename_table'] . "'>\n"; 
			echo "\t\t<input type='hidden' name='rename_table' value='" . $_GET['rename_table'] ."'>\n"; 
			echo "\t\t<input type='submit' name='submit' value='Rename'>\n"; 
			echo "\t\t</form>\n"; 
			echo "\t\t<br>\n"; 
		} 
	} 
    
	if(isset($_GET['copy_table']))
	{ 
		if(isset($_GET['new_name']))
		{ 
			copy($choose_dir . "/" . $_GET['copy_table'],$choose_dir . "/" . $_GET['new_name']); 
		} else { 
			echo "\t\t<form name=\"form_ren\" method=\"get\" action=\"" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID\">\n"; 
			echo "\t\t<input name='new_name' type='text' id='new_name' value='" . $_GET['copy_table'] . "'>\n"; 
			echo "\t\t<input type='hidden' name='copy_table' value='" . $_GET['copy_table'] ."'>\n"; 
			echo "\t\t<input type='submit' name='submit' value='Copy'>\n"; 
			echo "\t\t</form>\n"; 
			echo "\t\t<br>\n"; 
		} 
	} 
    
	if(isset($_GET['create_table']))
	{ 
		if(isset($_GET['new_name']))
		{ 
			$fd=fopen($choose_dir . "/" . $_GET['new_name'],"wb");
			fputs($fd,"column1\nstr\ndef-val\n");
			fclose($fd);
		} else { 
			echo "\t\t<form name=\"form_create\" method=\"get\" action=\"" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID\">\n"; 
			echo "\t\t<input name='new_name' type='text' id='new_name' value='newtable'".TABLE_FILE_EXT.">\n"; 
			echo "\t\t<input type='hidden' name='create_table' value='" . $_GET['create_table'] ."'>\n"; 
			echo "\t\t<input type='submit' name='submit' value='Create'>\n"; 
			echo "\t\t</form>\n"; 
			echo "\t\t<br>\n"; 
		} 
	} 
    
	echo "\t\t<br><b>[<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&choose_dir=".realpath($DB_DIR)."'>Reset directory to DB_DIR: ".realpath($DB_DIR)."</a>]</b>\n";

	if($choose_dir != realpath($DB_DIR))
	{
		echo "\t\t<b>[<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&create_table=1'>Create Table</a>]</b>\n";
	}

	echo "\t\t<br><br>\n"; 

	$handle=opendir ($choose_dir); 

	while ($file = readdir ($handle))
	{ 
		if(($file == ".") || (($choose_dir == realpath($DB_DIR)) && ($file == ".."))) 
			continue; 
		if(is_dir($choose_dir . "/" . $file))
		{ 
			echo "\t\t<b><a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&choose_dir=" . $choose_dir . "/" . $file . "'>$file</a></b><br>\n"; 
		}
		else if (is_file($choose_dir . "/" . $file) && strlen($file)>4 && strtolower(substr($file, strlen($file)-4))==TABLE_FILE_EXT)
		{ 
			echo "<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&table_file=" . $choose_dir . "/" . $file . "'>$file</a>"; 
			echo "&nbsp;&nbsp;&nbsp;&nbsp;[<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&delete_table=" . $choose_dir . "/" . $file ."'>delete</a>]\n"; 
			echo "&nbsp;[<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&rename_table=" . $file ."'>rename</a>]\n"; 
			echo "&nbsp;[<a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&copy_table=" . $file ."'>copy</a>]<br>\n"; 
		} 
    
	} 

	closedir($handle); 
?> 

<?php 

} // end choose table 

else if($mode=='edit_table')
{ 
	echo "\t\t<form name=\"form2\" method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID\">\n"; 
	echo "\t\t<input type='submit' name='submit' value='Save Table'>"; 
	echo "<input type='submit' name='close_table' value='Save and Close Table'>"; 
	echo "<input type='submit' name='abort' value='Abort'>"; 
	echo "<input type='submit' name='append_row' value='Append Row'>\n"; 
	echo "\t\t<br>\n"; 
	echo "\t\t<input type='hidden' name='mode' value='save_table'>"; 

	$fd=fopen($table_file,"rb"); 
		$rp= new ResultSetParser(); 
		$rs=$rp->parseResultSetFromFile($fd); 
	fclose($fd); 

	$colCount=$rs->getRowSize(); 
	$rowCount=$rs->getRowCount(); 
    
	echo "<input type='hidden' name='colCount' value='$colCount'>"; 
	echo "<input type='hidden' name='rowCount' value='$rowCount'>\n"; 
    
	$rs->reset(); 
	echo "\t\t<br><table border='1'>\n"; 
    
	// col names 
	echo "\t\t<tr>\n\t\t\t<td><b>Column names:</b></td>\n"; 
	$names=$rs->getColumnNames(); 
	$colPos=-1; 

	foreach($names as $n)
	{ 
		++$colPos; 
		echo "\t\t\t<td><input name='colName[]' type='text' id='colName[]' value='" . prep_val_show($n) . "'>"; 
		echo "<input type='submit' name='dupCol$colPos' value='Dup'>"; 
		echo "<input type='submit' name='delCol$colPos' value='X'>"; 
		echo "</td>\n"; 
	} 
	echo "\t\t</tr>\n"; 
    
	// col types 
	echo "\t\t<tr>\n\t\t\t<td><b>Column types:</b></td>\n"; 
	$types=$rs->getColumnTypes(); 
	foreach($types as $t)
	{
		echo "\t\t\t<td><input name='colType[]' type='text' id='colType[]' value='" . prep_val_show($t) . "'></td>\n"; 
	} 
	echo "\t\t</tr>\n"; 
    
	// col default values 
	echo "\t\t<tr>\n\t\t\t<td><b>Column default values:</b></td>\n"; 
	$defvals=$rs->getColumnDefaultValues(); 

	foreach($defvals as $d)
	{ 
		echo "\t\t\t<td><input name='colDefVal[]' type='text' id='colDefVal[]' value='" . prep_val_show($d) . "'></td>\n"; 
	} 

	echo "\t\t</tr>\n"; 
	echo "\t\t<tr>\n";    
	echo "\t\t\t<td>&nbsp;</td>\n"; 

	foreach($names as $n)
	{ 
		echo "\t\t\t<td>&nbsp;</td>\n"; 
	} 

	echo "\t\t</tr>\n"; 
    
	while($rs->next())
	{ 
		$pos=$rs->getPos(); 
		echo "\t\t<tr>\n\t\t<td><b>Row " . $pos . ":</b></td>\n"; 
		$vals=$rs->getCurrentValues(); 
		$i=-1; 
		foreach($vals as $val)
		{ 
			++$i; 
			echo "\t\t\t<td><textarea name='vals[$pos][]'>" . prep_val_show($val) . "</textarea></td>\n"; 
			if ($i==(count($vals)-1))
			{ 
				echo "\t\t\t<td nowrap><input type='submit' name='dup$pos' value='Dup'>"; 
				echo "<input type='submit' name='delete$pos' value='X'></td>\n"; 
			} 
			//echo "</td>\n"; 
		} 
		echo "\t\t</tr>\n"; 
	} 
    
	// append 
        echo "\t\t</table>\n"; 
	echo "\t\t<br>\n"; 
	echo "\t\t<input type='submit' name='submit' value='Save Table'>"; 
	echo "<input type='submit' name='close_table' value='Save and Close Table'>"; 
	echo "<input type='submit' name='abort' value='Abort'>"; 
	echo "<input type='submit' name='append_row' value='Append Row'>\n"; 
	echo "\t\t</form>\n"; 

} // end edit teble 

else if($mode=='save_table')
{ 
    
	echo "<br>"; 

	$rs=new ResultSet(); 
	$colName=$_POST['colName']; 
	$colType=$_POST['colType']; 
	$colDefVal=$_POST['colDefVal']; 

	if(isset($_POST['vals'])) 
	{
        	$vals=$_POST['vals']; 
	}

	$rowCount=$_POST['rowCount']; 
	$colCount=$_POST['colCount']; 
    
	if(isset($_POST['abort']))
	{ 
		echo "<br>"; 
		echo "Aborted, klick <a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'> here </a> to continue"; 
		$_SESSION['mode']='choose_table'; 
		unset($_SESSION['table_file']); 
		echo "<meta http-equiv='refresh' content='0;URL=". $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'>"; 
		exit(); 
	} 
        
	$rs->setColumnNames(prep_val_save_arr($colName)); 
	$rs->setColumnTypes(prep_val_save_arr($colType)); 
	$rs->setColumnDefaultValues(prep_val_save_arr($colDefVal)); 
    
	$rs->setColumnAliases(create_array_fill(count($rs->colNames),"")); 
	$rs->setColumnTables(create_array_fill(count($rs->colNames),"")); 
	$rs->setColumnTableAliases(create_array_fill(count($rs->colNames),"")); 
	$rs->setColumnFunctions(create_array_fill(count($rs->colNames),"")); 
	$rs->colFuncsExecuted=create_array_fill(count($rs->colNames),false); 
    
	$rowsSaved=0; 

	for($i=0;$i<$rowCount;++$i)
	{ 
		if(isset($_POST['delete' . $i]))
		{ 
			echo "Row $i deleted!<br>"; 
		} else {    
			if(isset($_POST['dup' . $i]))
			{ 
				echo "Row $i duplicated!<br>"; 
				$rowsSaved++; 
				$rs->appendRow(prep_val_save_arr($vals[$i])); 
			} 
			$rowsSaved++; 
			$rs->appendRow(prep_val_save_arr($vals[$i])); 
		} 
	} 
    
	echo "$rowsSaved Rows saved!<br>"; 
     
	if(isset($_POST['append_row']))
	{ 
		$rs->append(); 
		echo "1 Row appended!<br>"; 
	} 
	echo "colCount: $colCount<br>";
	for($i=0;$i<$colCount;++$i)
	{ 
		if(isset($_POST['dupCol' . $i]))
		{ 
			$rs->duplicateColumn($i); 
			echo "Column $i duplicated!<br>"; 
		} 
	} 
    
	for($i=0;$i<$colCount;++$i)
	{ 
		if(isset($_POST['delCol' . $i]))
		{ 
			$rs->removeColumn($i); 
			echo "Column $i deleted!<br>"; 
		} 
	} 
    
	$fd=fopen($table_file,"wb"); 
		$rp= new ResultSetParser(); 
		$rp->parseResultSetIntoFile($fd,$rs); 
	fclose($fd); 
    
	if(isset($_POST['close_table']))
	{ 
		echo "<br>"; 
		echo "Table saved and closed, klick <a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'> here </a> to continue"; 
		$_SESSION['mode']='choose_table'; 
		unset($_SESSION['table_file']); 
		echo "<meta http-equiv='refresh' content='1;URL=". $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'>"; 
        
	} else { 

		$_SESSION['mode']='edit_table'; 
		echo "<br>"; 
		echo "Table saved, klick <a href='" . $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'> here </a> to continue"; 
		echo "<meta http-equiv='refresh' content='1;URL=". $_SERVER['PHP_SELF'] . "?show=table_edit&$SID'>"; 
	}

} // end save table


function prep_val_show($val) { 
	if($val=="") return "";
	// edited by pACT 04/06/2007 for wider charset compliance
	//return htmlentities($val); 
	return mb_convert_encoding($val,"HTML-ENTITIES","utf-8, iso-8859-1"); 
} 

function prep_val_save($val) { 
	if($val=="") return ""; 
	// edited by pACT 04/06/2007 for wider charset compliance
	//return mb_convert_encoding($val,"utf-8","HTML-ENTITIES");
	return html_decode($val); 
	
} 

function prep_val_save_arr($arr) { 
	$out=array(); 
	for($i=0;$i<count($arr);++$i)
	{ 
		$out[$i]=prep_val_save($arr[$i]); 
	} 
	return $out; 
} 

function html_decode($string) { 
	$string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES))); 
	//$string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string); 
	$string = sec_stripslashes($string); 
	return $string;
}

function sec_stripslashes($str) {
	if(get_magic_quotes_gpc()) {
		return stripslashes($str);
	}
	return $str;
}

// Include page footer
echo dooutput($footinclude);
?>

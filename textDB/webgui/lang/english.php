<?php
/* $Id: english.php,v 1.0.1 2007/03/29 00:23:43 $ */

$charset = 'utf-8';
$allow_recoding = TRUE;

// Localisation settings
$number_thousands_separator = ',';
$number_decimal_separator = '.';

// Shortcuts for Byte, Kilo, Mega, Giga, Tera, Peta, Exa
$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

$day_of_week = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
$month = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

// Language name
$strLanguage = "english - english (UTF-8)";

// Actions
$strActionCreate = "Create";
$strActionCreateDbsTitle = "Create new database";
$strActionCreateTblTitle = "Create new table";
$strActionDelete = "Delete";
$strActionDeleteDbsTitle = "Delete $_GET[db] database";
$strActionDeleteTblTitle = "Delete $_GET[tbl] table";
$strActionEdit = "Edit";
$strActionEmpty = "Empty";
$strActionInsertRow = "Insert";
$strActionInsertRowTitle = "Insert new record into $_GET[tbl] table";
$strActionStructure = "Structure";
$strActionView = "View";

// Buttons
$strButtonFullText = "Deactivate word wrap";
$strButtonPartialText = "Activate word wrap";

// Column Names
$strActions = "Actions";
$strDatabase ="Database";
$strDefault = "Default value";
$strField = "Fieldname";
$strFunction = "Function";
$strLastMod = "Last modified";
$strPrimary = "Primary key";
$strRecord = "Records";
$strRow = "Row";
$strSize = "Size";
$strTable = "Table";
$strTables = "Tables";
$strType = "Datatype";
$strUnique = "Unique value";
$strValue = "Value";

// Confirm messages
$strColumnDeleteConfirm = "Do you really want to <b>delete</b> column <b>$_GET[col]</b> from table <b>$_GET[tbl]</b>?";
$strDatabaseDeleteConfirm = "Do you really want to <b>delete</b> database <b>$_GET[db]</b>?";
$strTableDeleteConfirm = "Do you really want to <b>delete</b> table <b>$_GET[tbl]</b>?";
$strTableEmptyConfirm = "Do you really want to <b>empty</b> table <b>$_GET[tbl]</b>?";

// Database Items
$strColumnName = "Column";
$strDatabaseName = "Database";
$strServerName = "Server";
$strTableName = "Table";

// Create Table Form
$strCreateFormFieldNumber = "Number of fields";
$strCreateFormSubmit = "Create";
$strCreateFormTableName = "Name";
$strCreateFormTitle = "Create new table in $_GET[db] database";
$strCreateFormDetailTitle = "Creation of table";

// Add Column Form
$strAddFormAfter = "After:";
$strAddFormContinue = "Continue";
$strAddFormFirst = "At the beginning";
$strAddFormLast = "At the end";
$strAddFormTitle = "Add new column to table $_GET[tbl]";
$strAddFormSubmit = "Add";

// Edit Column Form
$strEditFormTitle = "Edit column $_GET[fname] from table $_GET[tbl]";
$strEditFormSubmit = "Save";

// Form Generic
$strCancel = "Cancel";
$strSubmit = "Ok";

// Insert (new) Record Form
$strInsertRowFormTitle = "Insert a new record in <b>$_GET[tbl]</b> table:";
$strInsertSubmit = "Insert";

// Login Form (Portal)
$strUser = "Username";
$strPass = "Password";

// SQL-Query Form
$strSqlFormCheckBoxLocked = "Protect SQL-Query from being overwritten";
$strSqlFormCheckBoxReprint = "Show this SQL-Query again";
$strSqlFormSubmit = "Execute";
$strSqlFormTitle = "Run SQL-Queries on:";
$strSqlFormCheckWrap = "Automatic word wrap";

// Info messages
$strDatabaseDetailsEmpty = "There are no tables in this database...";
$strServerDetailsEmpty = "No databases found, root directory is empty...";
$strTableDetailsEmpty = "There are no fields in this table...";
$strTableViewEmpty = "No records found, table is empty...";

// Menu items
$strDatabases = "Databases";
$strTemplates = "Template";

// Query messages
$strColumnDeleteMessageFailure = "Error: Column $_GET[col] could not be deleted!";
$strColumnDeleteMessageSuccess = "Column $_GET[col] was successfully deleted";
$strColumnEditMessageFailure = "Error: Column changes could not be executed!";
$strColumnEditMessageSuccess = "Column changes were succesfully executed";
$strDatabaseCreateMessageFailure = "Query could not be executed!";
$strDatabaseCreateMessageSuccess = "Database $_GET[db] was successfully created";
$strDatabaseDeleteMessageFailure = "Error: Query could not be executed!";
$strDatabaseDeleteMessageSuccess = "Database $_GET[delete_db] was successfully deleted";
$strSqlExecuteMessageFailure = "Query could not be executed!";
$strSqlExecuteMessageSuccess = "Query was successfully executed";
$strSqlSelectMessageFailure = "Error: Tabel $_GET[tbl] not found!";
$strSqlSelectMessageSuccess = "Query was successfully executed";
$strTableCreateMessageFailure = "Error: Table $_GET[tbl] could not be created!";
$strTableCreateMessageSuccess = "Table $_GET[tbl] was successfully created";
$strTableDeleteMessageFailure = "Error: Table $_GET[delete_tbl] could not be deleted!";
$strTableDeleteMessageSuccess = "Table $_GET[delete_tbl] was successfully deleted";
$strTableEmptyMessageFailure = "Error: Table $_GET[empty_tbl] could not be emptied!";
$strTableEmptyMessageSuccess = "Table $_GET[empty_tbl] was successfully emptied";
$strTableInsertMessageFailure = "Error: Record could not be inserted into table $_GET[tbl]!";
$strTableInsertMessageSuccess = "Record was successfully inserted into table $_GET[tbl]";

// Welcome message
$strWelcome = "Welcome to";

?>
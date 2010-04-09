<?php
/* $Id: dutch.php,v 1.0.1 2007/03/29 00:23:43 $ */

$charset = 'utf-8';
$allow_recoding = TRUE;

// Localisation settings
$number_thousands_separator = '.';
$number_decimal_separator = ',';

// Shortcuts for Byte, Kilo, Mega, Giga, Tera, Peta, Exa
$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

$day_of_week = array('Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za');
$month = array('Jan', 'Feb', 'Maa', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

// Language name
$strLanguage = "nederlands - dutch (UTF-8)";

// Actions
$strActionCreate = "Aanmaken";
$strActionCreateDbsTitle = "Nieuwe database aanmaken";
$strActionCreateTblTitle = "Nieuwe tabel aanmaken";
$strActionDelete = "Verwijderen";
$strActionDeleteDbsTitle = "Database $_GET[db] verwijderen";
$strActionDeleteTblTitle = "Tabel $_GET[tbl] verwijderen";
$strActionEdit = "Wijzigen";
$strActionEmpty = "Legen";
$strActionInsertRow = "Invoegen";
$strActionInsertRowTitle = "Niewe rij aan tabel $_GET[tbl] toevoegen";
$strActionStructure = "Structuur";
$strActionView = "Verkennen";

// Buttons
$strButtonFullText = "Automatische terugloop uitschakelen";
$strButtonPartialText = "Automatische terugloop inschakelen";

// Column Names
$strActions = "Acties";
$strDatabase = "Database";
$strDefault = "Default waarde";
$strField = "Veldnaam";
$strFunction = "Functie";
$strLastMod = "Laatst gewijzigd";
$strPrimary = "Primary key";
$strRecord = "Rijen";
$strRow = "Rij";
$strSize = "Grootte";
$strTable = "Tabel";
$strTables = "Tabellen";
$strType = "Datatype";
$strUnique = "Unieke waarde";
$strValue = "Waarde";

// Confirm messages
$strColumnDeleteConfirm = "Weet u zeker dat u kolom <b>$_GET[col]</b> van tabel <b>$_GET[tbl]</b> wilt <b>verwijderen</b>?";
$strDatabaseDeleteConfirm = "Weet u zeker dat u database <b>$_GET[db]</b> wilt <b>verwijderen</b>?";
$strTableDeleteConfirm = "Weet u zeker dat u tabel <b>$_GET[tbl]</b> wilt <b>verwijderen</b>?";
$strTableEmptyConfirm = "Weet u zeker dat u tabel <b>$_GET[tbl]</b> wilt <b>legen</b>?";

// Database Items
$strColumnName = "Kolom";
$strDatabaseName = "Database";
$strServerName = "Server";
$strTableName = "Tabel";

// Create Table Form
$strCreateFormFieldNumber = "Aantal velden";
$strCreateFormSubmit = "Aanmaken";
$strCreateFormTableName = "Naam";
$strCreateFormTitle = "Nieuwe tabel in $_GET[db] database aanmaken";
$strCreateFormDetailTitle = "Tabel aanmaken";

// Add Column Form
$strAddFormAfter = "Na kolom:";
$strAddFormContinue = "Doorgaan";
$strAddFormFirst = "Aan het begin";
$strAddFormLast = "Aan het eind";
$strAddFormTitle = "Nieuwe kolom aan tabel $_GET[tbl] toevoegen";
$strAddFormSubmit = "Toevoegen";

// Edit Column Form
$strEditFormTitle = "Kolom $_GET[fname] van tabel $_GET[tbl] wijzigen";
$strEditFormSubmit = "Wijzigen";

// Form Generic
$strCancel = "Afbreken";
$strSubmit = "Ok";

// Insert (new) Record Form
$strInsertRowFormTitle = "Nieuwe rij aan <b>$_GET[tbl]</b> tabel toevoegen:";
$strInsertSubmit = "Toevoegen";

// Login Form (Portal)
$strUser = "Gebruiker";
$strPass = "Paswoord";

// SQL-Query Form
$strSqlFormCheckBoxLocked = "Beveilig deze SQL-Query tegen overschrijven";
$strSqlFormCheckBoxReprint = "Laat deze SQL-Query hier weer zien";
$strSqlFormSubmit = "Uitvoeren";
$strSqlFormTitle = "SQL-Queries uitvoeren op:";
$strSqlFormCheckWrap = "Automatische terugloop";

// Info messages
$strDatabaseDetailsEmpty = "Geen tabellen gevonden, deze database is leeg...";
$strServerDetailsEmpty = "Geen databases gevonden, database root is leeg...";
$strTableDetailsEmpty = "Geen velden gevonden voor deze tabel...";
$strTableViewEmpty = "Geen regels gevonden, tabel is leeg...";

// Menu items
$strDatabases = "Databases";
$strTemplates = "Thema/Stijl";

// Query messages
$strColumnDeleteMessageFailure = "Error: Kolom $_GET[col] kan niet worden verwijderd!";
$strColumnDeleteMessageSuccess = "Kolom $_GET[col] is successvol verwijderd";
$strColumnEditMessageFailure = "Error: Kolom naam en/of waarden konden niet worden gewijzigd";
$strColumnEditMessageSuccess = "Kolom naam en/of waarden zijn successvol gewijzigd";
$strDatabaseCreateMessageFailure = "Query kon niet worden uitgevoerd!";
$strDatabaseCreateMessageSuccess = "Database $_GET[db] is successvol aangemaakt";
$strDatabaseDeleteMessageFailure = "Query kon niet worden uitgevoerd!";
$strDatabaseDeleteMessageSuccess = "Database $_GET[delete_db] is successvol verwijderd";
$strSqlExecuteMessageFailure = "Query kon niet worden uitgevoerd!";
$strSqlExecuteMessageSuccess = "Query is successvol uitgevoerd";
$strSqlSelectMessageFailure = "Error: Tabel $_GET[tbl] kon niet worden gevonden!";
$strSqlSelectMessageSuccess = "Query is successvol uitgevoerd";
$strTableCreateMessageFailure = "Error: Tabel $_GET[tbl] kon niet worden aangemaakt!";
$strTableCreateMessageSuccess = "Tabel $_GET[tbl] is succesvol aangemaakt";
$strTableDeleteMessageFailure = "Error: Tabel $_GET[delete_tbl] kon niet worden verwijderd!";
$strTableDeleteMessageSuccess = "Tabel $_GET[delete_tbl] is succesvol verwijderd";
$strTableEmptyMessageFailure = "Error: Tabel $_GET[empty_tbl] kon niet worden geleegd!";
$strTableEmptyMessageSuccess = "Tabel $_GET[empty_tbl] is succesvol geleegd";
$strTableInsertMessageFailure = "Error: Rij kon niet worden toegevoegd aan tabel $_GET[tbl]!";
$strTableInsertMessageSuccess = "Rij is successvol toegevoegd aan tabel $_GET[tbl]";

// Welcome message
$strWelcome = "Welkom bij";

?>
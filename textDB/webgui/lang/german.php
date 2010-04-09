<?php
/* $Id: german.php,v 1.0.1 2007/03/29 00:23:43 $ */

$charset = 'utf-8';
$allow_recoding = TRUE;

// Localisation settings
$number_thousands_separator = ',';
$number_decimal_separator = '.';

// Shortcuts for Byte, Kilo, Mega, Giga, Tera, Peta, Exa
$byteUnits = array('Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB');

$day_of_week = array('So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa');
$month = array('Jan', 'Feb', 'M&auml;r', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec');

// Language name
$strLanguage = "deutsch - german (UTF-8)";

// Actions
$strActionCreate = "Erstellen";
$strActionCreateDbsTitle = "Neue Datenbank erstellen";
$strActionCreateTblTitle = "Neue Tabelle erstellen";
$strActionDelete = "L&ouml;schen";
$strActionDeleteDbsTitle = "Datenbank $_GET[db] l&ouml;schen";
$strActionDeleteTblTitle = "Tabelle $_GET[tbl] l&ouml;schen";
$strActionEdit = "&Auml;ndern";
$strActionEmpty = "Leeren";
$strActionInsertRow = "Einf&uuml;gen";
$strActionInsertRowTitle = "Einf&uuml;gen";
$strActionStructure = "Struktur";
$strActionView = "Anzeigen";

// Buttons
$strButtonFullText = "Automatischer Zeilenumbruch ausschalten";
$strButtonPartialText = "Automatischer Zeilenumbruch einschalten";

// Column Names
$strActions = "Aktionen";
$strDatabase = "Datenbank";
$strDefault = "Default Wert";
$strField = "Feldname";
$strFunction = "Funktion";
$strLastMod = "Modifiziert am";
$strPrimary = "Primary key";
$strRecord = "Zeilen";
$strRow = "Zeile";
$strSize = "Gr&ouml;&szlig;e";
$strTable = "Tabelle";
$strTables = "Tabellen";
$strType = "Datatype";
$strUnique = "Einmalige Wert";
$strValue = "Wert";

// Confirm messages
$strColumnDeleteConfirm = "Sind Sie sicher da&szlig; Sie Spalte <b>$_GET[col]</b> von Tabelle <b>$_GET[tbl]</b> l&ouml;schen wollen?";
$strDatabaseDeleteConfirm = "Sind Sie sicher da&szlig; Sie Datenbank <b>$_GET[db]</b> l&ouml;schen wollen?";
$strTableDeleteConfirm = "Sind Sie sicher da&szlig; Sie Tabelle <b>$_GET[tbl]</b> l&ouml;schen wollen?";
$strTableEmptyConfirm = "Sind Sie sicher da&szlig; Sie Tabelle <b>$_GET[tbl]</b> leeren wollen?";

// Database Items
$strColumnName = "Spalte";
$strDatabaseName = "Datenbank";
$strServerName = "Server";
$strTableName = "Tabelle";

// Create Table Form
$strCreateFormFieldNumber = "Anzahl der Felder";
$strCreateFormSubmit = "Erstellen";
$strCreateFormTableName = "Name";
$strCreateFormTitle = "Neue Tabelle in Datenbank $_GET[db] erstellen";
$strCreateFormDetailTitle = "Tabelle erstellen";

// Add Column Form
$strAddFormAfter = "Nach:";
$strAddFormContinue = "Weiter";
$strAddFormFirst = "An den Anfang";
$strAddFormLast = "An das Ende";
$strAddFormTitle = "Eine neue Spalte an der Tabelle $_GET[tbl] zuf&uuml;gen";
$strAddFormSubmit = "Zufügen"; // no html character otherwise submit breaks!

// Edit Column Form
$strEditFormTitle = "Spalte $_GET[fname] von Tabelle $_GET[tbl] &auml;ndern";
$strEditFormSubmit = "Speichern";

// Form Generic
$strCancel = "Abbrechen";
$strSubmit = "Ok";

// Insert (new) Record Form
$strInsertRowFormTitle = "Neue Zeile in <b>$_GET[tbl]</b> Tabelle einf&uuml;gen:";
$strInsertSubmit = "Einf&uuml;gen";

// Login Form (Portal)
$strUser = "Benutzer";
$strPass = "Passwort";

// SQL-Query Form
$strSqlFormCheckBoxLocked = "SQL-Befehl vor &Auml;nderungen sch&uuml;tzen";
$strSqlFormCheckBoxReprint = "SQL-Befehl hier wieder anzeigen";
$strSqlFormSubmit = "Ausf&uuml;hren";
$strSqlFormTitle = "SQL-Befehl(e) ausf&uuml;hren auf:";
$strSqlFormCheckWrap = "Automatischer Zeilenumbruch";

// Info messages
$strDatabaseDetailsEmpty = "Keine Tabellen gefunden, diese Datenbank ist leer...";
$strServerDetailsEmpty = "Keine Datenbanken gefunden...";
$strTableDetailsEmpty = "Keine Felder gefunden in diese Tabelle...";
$strTableViewEmpty = "Keinen Zeilen gefunden, diese Tabelle ist leer...";

// Menu items
$strDatabases = "Datenbanken";
$strTemplates = "Oberfl&auml;che";

// Query messages
$strColumnDeleteMessageFailure = "Fehler: Spalte $_GET[col] konnte nicht gel&ouml;scht werden!";
$strColumnDeleteMessageSuccess = "Spalte $_GET[col] ist erfolgreich gel&ouml;scht";
$strColumnEditMessageFailure = "Error: Spalte &auml;nderungen konnten nicht durchgef&uuml;hrt werden!";
$strColumnEditMessageSuccess = "Spalte &auml;nderungen sind erfolgreich durchgef&uuml;hrt";
$strDatabaseCreateMessageFailure = "SQL-Befehl konnte nicht ausgef&uuml;hrt werden!";
$strDatabaseCreateMessageSuccess = "Datenbank $_GET[db] ist erfolgreich erstellt";
$strDatabaseDeleteMessageFailure = "SQL-Befehl konnte nicht ausgef&uuml;hrt werden!";
$strDatabaseDeleteMessageSuccess = "Datenbank $_GET[delete_db] ist erfolgreich gel&ouml;scht";
$strSqlExecuteMessageFailure = "SQL-Befehl konnte nicht ausgef&uuml;hrt werden!";
$strSqlExecuteMessageSuccess = "SQL-Befehl ist erfolgreich ausgef&uuml;hrt";
$strSqlSelectMessageFailure = "Fehler: Tabelle $_GET[tbl] konnte nicht gefunden werden!";
$strSqlSelectMessageSuccess = "SQL-Befehl ist erfolgreich ausgef&uuml;hrt";
$strTableCreateMessageFailure = "Fehler: Tabelle $_GET[tbl] konnte nicht erstellt werden!";
$strTableCreateMessageSuccess = "Tabelle $_GET[tbl] ist erfolgreich erstellt";
$strTableDeleteMessageFailure = "Fehler: Tabelle $_GET[delete_tbl] konnte nicht gel&ouml;scht werden!";
$strTableDeleteMessageSuccess = "Tabelle $_GET[delete_tbl] ist erfolgreich gel&ouml;scht";
$strTableEmptyMessageFailure = "Fehler: Tabelle $_GET[empty_tbl] konnte nicht geleert werden!";
$strTableEmptyMessageSuccess = "Tabelle $_GET[empty_tbl] ist erfolgreich geleert";
$strTableInsertMessageFailure = "Fehler: Zeile konnte nicht in Tabelle $_GET[tbl] eingef&uuml;gt werden!";
$strTableInsertMessageSuccess = "Zeile ist erfolgreich in Tabelle $_GET[tbl] eingef&uuml;gt";

// Welcome message
$strWelcome = "Wilkommen zu";

?>
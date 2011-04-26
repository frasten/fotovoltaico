<?php

define('DB_DIR', realpath(dirname(__FILE__)) . '/../db/'); // Path relativo a questa directory
define('DB_PROGETTO','fotovoltaico');

define('TBL_DATI','dati');
define('TBL_DATI_MENSILI','dati_mese');

if (!is_dir(DB_DIR)) {
	echo "Directory dei DB inesistente, la creo.\n";
	$ok = mkdir(DB_DIR, 0777);
	if ($ok === false) {
		// Errore nella creazione della directory
		die("Errore nella creazione della directory.\n");
	}
}
require_once(realpath(dirname(__FILE__).'/../textDB/txt-db-api.php'));

if (!is_dir(DB_DIR . '/' . DB_PROGETTO)) {
	echo "Creo il db " . DB_PROGETTO . "\n";
	// Creo il DB
	$db = new Database('');
	$query = "CREATE DATABASE " . DB_PROGETTO;
	$ok = $db->executeQuery($query);
	if (!$ok) {
		// Errore nella creazione del DB
		echo "Errore nella creazione del DB di log.\n";
		echo 'DB: ' . DB_PROGETTO . "\n";
		echo "Query: $query\n";
		echo "Oggetto db:\n";
		print_r($db);
		return false;
	}
	unset($db);
}

$db = new Database(DB_PROGETTO);
// Controllo se la tabella esiste
$query = "LIST TABLES WHERE table = '" . TBL_DATI . "'";
$result = $db->executeQuery($query);
if (!$result) {
	echo "Errore interno.\n";
	return;
}

// Tabella inesistente
if (!$result->getRowCount()) {
	// Creo anche le tabelle
	$query = "CREATE TABLE ".TBL_DATI." (
id inc,
data str,
prod_inverter int,
produzione int,
ceduti int,
consumati int,
prelievo_f1 int,
prelievo_f2 int,
prelievo_f3 int,
tempo str
)";
	$ok = $db->executeQuery($query);
	if (!$ok) {
		// Errore nella creazione della tabella
		echo "Errore nella creazione della tabella.\n";
		echo 'Tabella: ' . TBL_DATI . "\n";
		echo "Query: $query\n";
		echo "Oggetto db:\n";
		print_r($db);
		return false;
	}
}




// Controllo se la tabella esiste
$query = "LIST TABLES WHERE table = '" . TBL_DATI_MENSILI . "'";
$result = $db->executeQuery($query);
if (!$result) {
	echo "Errore interno.\n";
	return;
}

// Tabella inesistente
if (!$result->getRowCount()) {
	// Creo anche le tabelle
	$query = "CREATE TABLE ".TBL_DATI_MENSILI." (
id inc,
anno int,
mese int,
prod_inverter int,
produzione int,
ceduti int,
consumati int,
prelievo_f1 int,
prelievo_f2 int,
prelievo_f3 int
)";
	$ok = $db->executeQuery($query);
	if (!$ok) {
		// Errore nella creazione della tabella
		echo "Errore nella creazione della tabella.\n";
		echo 'Tabella: ' . TBL_DATI_MENSILI . "\n";
		echo "Query: $query\n";
		echo "Oggetto db:\n";
		print_r($db);
		return false;
	}
}


function pulisci_post_numeri($lista_keys) {
	foreach ($lista_keys as $key) {
		$_POST[$key] = preg_replace("/[^0-9.,]/", '', $_POST[$key]);
	}
}
?>

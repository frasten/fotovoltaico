<?php

define('DB_DIR', realpath(dirname(__FILE__)) . '/../db/'); // Path relativo a questa directory
define('DB_FILE', DB_DIR . 'fotovoltaico.db');

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


// Creazione o connessione al database SQLite
try {
    $db = new PDO('sqlite:' . DB_FILE);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Errore durante la connessione al database: " . $e->getMessage());
}


// Creazione tabelle, se inesistenti
$query = "CREATE TABLE IF NOT EXISTS " . TBL_DATI . " (
id INTEGER PRIMARY KEY,
data TEXT NOT NULL,
prod_inverter INTEGER NOT NULL,
produzione INTEGER NOT NULL,
ceduti INTEGER NOT NULL,
consumati INTEGER NOT NULL,
prelievo_f1 INTEGER NOT NULL,
prelievo_f2 INTEGER NOT NULL,
prelievo_f3 INTEGER NOT NULL,
tempo TEXT NOT NULL
)";
try {
    $db->exec($query);
} catch (PDOException $e) {
    die("Errore durante la creazione della tabella '" . TBL_DATI . "': " . $e->getMessage());
}

// Tabella dati mensili
$query = "CREATE TABLE IF NOT EXISTS " . TBL_DATI_MENSILI . " (
id INTEGER PRIMARY KEY,
anno INTEGER NOT NULL,
mese INTEGER NOT NULL,
prod_inverter INTEGER NOT NULL,
produzione INTEGER NOT NULL,
ceduti INTEGER NOT NULL,
consumati INTEGER NOT NULL,
prelievo_f1 INTEGER NOT NULL,
prelievo_f2 INTEGER NOT NULL,
prelievo_f3 INTEGER NOT NULL
)";
try {
    $db->exec($query);
} catch (PDOException $e) {
    die("Errore durante la creazione della tabella '" . TBL_DATI_MENSILI . "': " . $e->getMessage());
}


function pulisci_post_numeri($lista_keys) {
	foreach ($lista_keys as $key) {
		$_POST[$key] = preg_replace("/[^0-9.,]/", '', $_POST[$key]);
	}
}
?>

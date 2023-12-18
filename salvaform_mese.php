<?php

require_once('inc/db.inc.php');

pulisci_post_numeri(array(
'mese',
'anno',
'prod_inverter',
'produzione',
'ceduti',
'consumati',
'prelievo_f1',
'prelievo_f2',
'prelievo_f3',
));


// Salviamo i dati nel database
$query = "INSERT INTO " . TBL_DATI_MENSILI .
	" (anno, mese, prod_inverter, produzione, ceduti, consumati, " .
	"prelievo_f1, prelievo_f2, prelievo_f3) VALUES (" .
	
	"'$_POST[anno]', '$_POST[mese]', '$_POST[prod_inverter]', '$_POST[produzione]', '$_POST[ceduti]', " .
	"'$_POST[consumati]', '$_POST[prelievo_f1]', '$_POST[prelievo_f2]', ".
	"'$_POST[prelievo_f3]'" .
	")";

try {
    $db->exec($query);
} catch (PDOException $e) {
    die("Errore nel salvataggio: " . $e->getMessage() . " <a href='javascript:history.back()'>Torna</a>");
}

require_once('inc/header.inc.php');
echo "Salvataggio effettuato.";
require_once('inc/footer.inc.php');


?>

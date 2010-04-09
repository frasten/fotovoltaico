<?php

require_once('inc/db.inc.php');

pulisci_post_numeri(array(
'prod_inverter',
'produzione',
'ceduti',
'consumati',
'prelievo_f1',
'prelievo_f2',
'prelievo_f3',
));

$gma = explode('/', $_POST['data']);
// Nel formato: AAAA-MM-GG
$newdata = "{$gma[2]}-{$gma[1]}-{$gma[0]}";
if (empty($gma)) {
	header("Location: form.php", false, 302);
	return;
}
$gma = addslashes($gma);

$_POST['tempo'] = addslashes($_POST['tempo']);

// Salviamo i dati nel database
$query = "INSERT INTO " . TBL_DATI .
	" (data, prod_inverter, produzione, ceduti, consumati, " .
	"prelievo_f1, prelievo_f2, prelievo_f3, tempo) VALUES (" .
	
	"'$newdata', '{$_POST['prod_inverter']}', '{$_POST['produzione']}', '{$_POST['ceduti']}', " .
	"'{$_POST['consumati']}', '{$_POST['prelievo_f1']}', '{$_POST['prelievo_f2']}', ".
	"'{$_POST['prelievo_f3']}', '{$_POST['tempo']}'" .
	")";

$ok = $db->executeQuery($query);
if (!$ok) {
	echo "Errore nel salvataggio: ". txtdbapi_get_last_error();
	echo " <a href='javascript:history.back()'>Torna</a>";
	return;
}

require_once('inc/header.inc.php');
echo "Salvataggio effettuato.";
require_once('inc/footer.inc.php');


?>

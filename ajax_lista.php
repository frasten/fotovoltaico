<?php
$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction

// Ricerca
$campoCerca = $_GET['searchField'];
$operatoreCerca = $_GET['searchOper'];
$stringaCerca = $_GET['searchString'];


if(!$sidx) $sidx =1;
$page = addslashes($page);
$limit = intval($limit);
if ($limit <= 0) $limit = 1;
$sidx = addslashes($sidx);
$sord = addslashes($sord);

$oper = $_POST['oper'];

require_once('inc/db.inc.php');
if (!$db) die();

if ($oper == 'edit'):
/***************** EDIT ************************/
$id = intval($_POST['id']);
if (!$id) die("Non fregarmi.");

$query = "SELECT id FROM ". TBL_DATI . " WHERE id='$id' LIMIT 1";
$result = $db->executeQuery($query);
if (!$result || !$result->getRowCount()) die("ID non valido.");

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
if (empty($gma)) die("Data non valida.");
$gma = addslashes($gma);

$_POST[tempo] = addslashes($_POST[tempo]);

echo $query = "UPDATE " . TBL_DATI . " SET ".
	"ceduti='{$_POST[ceduti]}', consumati='{$_POST[consumati]}', " .
	"prod_inverter='{$_POST[prod_inverter]}', produzione='{$_POST[produzione]}', " .
	"data='$newdata', prelievo_f1='{$_POST[prelievo_f1]}', " .
	"prelievo_f2='{$_POST[prelievo_f2]}', prelievo_f3='{$_POST[prelievo_f3]}', " .
	"tempo='{$_POST[tempo]}' " .
	" WHERE id='$id'";
$ok = $db->executeQuery($query);
if (!$ok) die("Errore nel salvataggio.");

// Tutto ok.
echo 0;

else:
/***************** SELECT **********************/
$queryRicerca = '';
if ($campoCerca) {
	$campoCerca = addslashes($campoCerca);
	$stringaCerca = addslashes($stringaCerca);
	switch ($operatoreCerca) {
		case 'eq':
			$op = '=';
			break;
		case 'ne':
			$op = '!=';
			break;
		case 'lt':
			$op = '<';
			break;
		case 'gt':
			$op = '>';
			break;
		case 'le':
			$op = '<=';
			break;
		case 'ge':
			$op = '>=';
			break;
		case 'bw':
			$op = 'LIKE';
			$prestring = '%';
			break;
		case 'ew':
			$op = 'LIKE';
			$poststring = '%';
			break;
		case 'cn':
			$op = 'LIKE';
			$prestring = '%';
			$poststring = '%';
			break;
		default: // TODO: fare gli altri rimanenti
			$op = '=';
			break;
	}
	$queryRicerca = "WHERE $campoCerca $op '$prestring$stringaCerca$poststring'";
}

$result = $db->executeQuery("SELECT COUNT(*) FROM " . TBL_DATI . " $queryRicerca");
$result->next();
$count = $result->getCurrentValueByNr(0);
if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages)
	$page=$total_pages;

// Limite: almeno 0
$start = max($limit*$page - $limit, 0); // do not put $limit*($page - 1)
$query = "SELECT * FROM " . TBL_DATI . " $queryRicerca ORDER BY $sidx $sord LIMIT $start , $limit";
$result = $db->executeQuery( $query );
if (!$result) die("Errore nella query.");

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;

$i=0;
while($result->next()) {
	$row = $result->getCurrentValuesAsHash();
	$responce->rows[$i]['id']=$row[id];
	$amg = explode('-', $row[data]);
	$data = "{$amg[2]}/{$amg[1]}/{$amg[0]}";
	$responce->rows[$i]['cell']=array($data,$row[prod_inverter],$row[produzione],$row[ceduti],$row[consumati],$row[prelievo_f1],$row[prelievo_f2],$row[prelievo_f3],$row[tempo]);
	$i++;
}

echo json_encode($responce);

endif; // Fine scelta operazione da eseguire

?>

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

if ($oper == 'edit' || $oper == 'del'):
$id = intval($_POST['id']);
if (!$id) die("Non fregarmi.");

$query = "SELECT id FROM ". TBL_DATI . " WHERE id='$id' LIMIT 1";
try {
    $result = $db->query($query);
    if (!$result->rowCount())
        throw new Exception("ID non valido.");
} catch (PDOException $e) {
    die("ID non valido.");
}
endif;


if ($oper == 'edit'):
/***************** EDIT ************************/
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
try {
    $db->exec($query);
} catch (PDOException $e) {
    die("Errore nel salvataggio.");
}

// Tutto ok.
echo 0;

elseif ($oper == 'del'):
/****************** DELETE *********************/
$query = "DELETE FROM " . TBL_DATI . " WHERE id = '$id'";

try {
    $db->exec($query);
} catch (PDOException $e) {
    die("Errore nel salvataggio.");
}

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

try {
    $result = $db->query("SELECT COUNT(*) FROM " . TBL_DATI . " $queryRicerca");
} catch (PDOException $e) {
    die("Errore durante l'esecuzione della query SELECT: " . $e->getMessage());
}
$count = $result->fetchColumn();

if( $count > 0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages)
	$page=$total_pages;

// Limite: almeno 0
$start = max($limit*$page - $limit, 0); // do not put $limit*($page - 1)
$query = "SELECT * FROM " . TBL_DATI . " $queryRicerca ORDER BY $sidx $sord LIMIT $start , $limit";
try {
    $result = $db->query( $query );
} catch (PDOException $e) {
    die("Errore durante l'esecuzione della query SELECT: " . $e->getMessage());
}

$response = new stdClass();
$response->page = $page;
$response->total = $total_pages;
$response->records = $count;

$i=0;
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
	$response->rows[$i]['id']=$row['id'];
	$amg = explode('-', $row['data']);
	$data = "{$amg[2]}/{$amg[1]}/{$amg[0]}";
	$response->rows[$i]['cell']=array($data,$row['prod_inverter'],$row['produzione'],$row['ceduti'],$row['consumati'],$row['prelievo_f1'],$row['prelievo_f2'],$row['prelievo_f3'],$row['tempo']);
	$i++;
}

echo json_encode($response);

endif; // Fine scelta operazione da eseguire

?>

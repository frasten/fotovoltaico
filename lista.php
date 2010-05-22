<?php

$CSS[] = 'css/cupertino/jquery-ui.css';
$CSS[] = 'js/jqgrid/css/ui.jqgrid.css';

$JS[] = 'js/jquery.js';
$JS[] = 'js/jquery-ui.js';
$JS[] = 'js/jqgrid/js/i18n/grid.locale-it.js';
$JS[] = 'js/jqgrid/js/jquery.jqGrid.min.js';


require_once('inc/header.inc.php');

?>
<br />
<table id="lista"></table>
<div id="pager"></div>
<script type="text/javascript">
jQuery("#lista").jqGrid({
	url:'ajax_lista.php',
	height: "100%",
	datatype: "json",
	colNames:['Data','Prod Inverter', 'Produzione', 'Ceduti','Autoconsumati','F1','F2','F3','Tempo'],
	colModel:[
		{name:'data',index:'data', width:90, editable: true, editoptions:{size:8}},
		{name:'prod_inverter',index:'prod_inverter', width:100, align:"right", editable: true, editoptions:{size:4}},
		{name:'produzione',index:'produzione', width:80, align:"right", editable: true, editoptions:{size:4}},
		{name:'ceduti',index:'ceduti', width:80, align:"right", editable: true, editoptions:{size:4}},
		{name:'consumati',index:'consumati', width:90, align:"right", editable: true, editoptions:{size:4}},
		{name:'prelievo_f1',index:'prelievo_f1', width:80,align:"right", editable: true, editoptions:{size:4}},
		{name:'prelievo_f2',index:'prelievo_f2', width:80,align:"right", editable: true, editoptions:{size:4}},
		{name:'prelievo_f3',index:'prelievo_f3', width:80,align:"right", editable: true, editoptions:{size:4}},
		{name:'tempo',index:'tempo', width:80,edittype:"select", editable: true, editoptions:{value:"S:Sereno;SN:Variabile;N:Nuvoloso;P:Pioggia;T:Temporale;V:Neve"}}
	],
	rowNum:20,
	rowList:[10,20,30],
	pager: '#pager',
	sortname: 'data',
	viewrecords: true,
	sortorder: "desc",
	caption:"Dati fotovoltaico",
	editurl: "ajax_lista.php"
}).navGrid('#pager',{
	edit:true,
	add:false,
	del:true,
	search:true,
	searchtext:"Cerca",
	refreshtext:"Aggiorna",
	deltext:"Elimina",
	edittext:"Modifica"
});
</script>
<?php

$query = "SELECT consumati, prelievo_f1 as f1, prelievo_f2 as f2, prelievo_f3 as f3 FROM " . TBL_DATI;
$result = $db->executeQuery($query);

$tot = 0;
$max['f1'] = 0;
$max['f2'] = 0;
$max['f3'] = 0;
while ($result->next()) {
	$riga = $result->getCurrentValuesAsHash();
	$tot += $riga['consumati'];
	$max['f1'] = max($max['f1'], $riga['f1']);
	$max['f2'] = max($max['f2'], $riga['f2']);
	$max['f3'] = max($max['f3'], $riga['f3']);
}
$tot2 = $tot + $max['f1'] + $max['f2'] + $max['f3'];
echo "<br /><br />";
echo "Totale autoconsumati: $tot kWh<br />";
echo "Totale autoconsumati+F1+F2+F3: $tot2 kWh";

require_once('inc/footer.inc.php');
?>

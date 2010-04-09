<?php

$JS[] = 'js/jquery.js';
$JS[] = 'js/flot/jquery.flot.min.js';

require_once('inc/header.inc.php');


$query = "SELECT * FROM " . TBL_DATI;
$result = $db->executeQuery($query);
$dati_prod_inverter = array();
$dati_prelievo_f1 = array();
$dati_prelievo_f2 = array();
$dati_prelievo_f3 = array();
$i = 0;
if (function_exists('date_default_timezone_set'))
	date_default_timezone_set('UTC');
while ($result->next()) {
	$riga = $result->getCurrentValuesAsHash();
	$amg = explode('-', $riga[data]);
	$timestamp = mktime(0, 0, 0, $amg[1], $amg[2], $amg[0]) * 1000;
	$dati_prod_inverter[] = array($timestamp, $riga[prod_inverter]);
	$dati_prelievo_f1[] = array($timestamp, $riga[prelievo_f1]);
	$dati_prelievo_f2[] = array($timestamp, $riga[prelievo_f2]);
	$dati_prelievo_f3[] = array($timestamp, $riga[prelievo_f3]);
	$i++;
}

/*
$scalatura = 24; // 1 giorno
$step = 1;
$delta = 6*$scalatura; // limite sopra e sotto la traslazione
$PI = 3.1415;
$arr_media = array();
for ($i = 0; $i < sizeof($dati_prelievo_f1); $i++) {
	$ampiezza = $dati_prelievo_f1[$i][1];
	// Divido altrimenti va in overflow e non gli piacciono key grandi
	$traslazione = $dati_prelievo_f1[$i][0]/(60*60*1000);
	for ($t = $traslazione - $delta; $t <= $traslazione + $delta; $t += $step) {
		if ($t == $traslazione)
			$sinc = $ampiezza;
		else
			$sinc = $ampiezza * sin($PI * ($t-$traslazione) / $scalatura) / ($PI * ($t-$traslazione) / $scalatura);
		$arr_media[$t] += $sinc;
	}
}

$media = array();
foreach ($arr_media as $k => $v) {
	$media[] = array($k*1000*60*60, $v);
}
*/


/* moltiplico un sinc traslato , ampiezza = valore
 * poi sommo tutto.
 * 
 * */


?>
<div id="placeholder" class="grafico"></div>
<script type="text/javascript">
mesiIta = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"];

function getData(date) {
	return date.getDate() + " " + mesiIta[date.getMonth()] + ", " + date.getFullYear();
}

// ** hover tooltip **
function showTooltip(x, y, contents) {
	$('<div id="tooltip">' + contents + '</div>').css({
		top: y + 5,
		left: x + 5
	}).appendTo("body").fadeIn(150);
}

funzioneMouseOver = function (event, pos, item) {
	// ** over an item? **
	if (item) {
		if (!this.previousPoint ||
		this.previousPoint[0] != item.datapoint[0] ||
		this.previousPoint[1] != item.datapoint[1]) {
			this.previousPoint = item.datapoint;
			// hover tooltip
			$("#tooltip").remove();
			var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(0);
			var nomeGrafico = item.series.label;
			var theDateObj = new Date(parseFloat(x));
			var d = getData(theDateObj);
			showTooltip(item.pageX, item.pageY,
				nomeGrafico + "<br />"+
				d +": <strong>" + y + " kW</strong>"
			);
		}
	}
	else {
		$("#tooltip").remove();
		this.previousPoint = null;
	}
};


$(function () {
	var d1 = <?php echo json_encode($dati_prod_inverter); ?>;
	var d2 = <?php echo json_encode($dati_prelievo_f1); ?>;
	var d3 = <?php echo json_encode($dati_prelievo_f2); ?>;
	var d4 = <?php echo json_encode($dati_prelievo_f3); ?>;
	//var d5 = <?php echo json_encode($media); ?>;

	$.plot($("#placeholder"), [
		{label: 'Prelievo F1', data: d2},
		{label: 'Prelievo F2', data: d3},
		{label: 'Prelievo F3', data: d4}/*,
		{label: 'Prelievo F3', data: d5, points: { show: false }}*/
	], {
		series: {
			lines: {show: true/*, fill: true*/},
			points: {show: true},
			colors: ["#edc240", "#ff009c", "#4da74d", "#aaa"]
		},
		grid: {
            backgroundColor: { colors: ["#ddf", "#fff"] },
            hoverable: true
        },
        xaxis: {
			mode: "time",
			minTickSize: [1, "day"],
			monthNames: mesiIta
			/*,
			min: (new Date("1990/01/01")).getTime(),
			max: (new Date("2000/01/01")).getTime()*/
		}

	});

	// Roba per l'hover
	$("#placeholder").bind("plothover", funzioneMouseOver);



});
</script>


<?php

require_once('inc/footer.inc.php');
?>

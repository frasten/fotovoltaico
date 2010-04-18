<?php

$JS[] = 'js/jquery.js';
$JS[] = 'js/flot/jquery.flot.min.js';

require_once('inc/header.inc.php');


$query = "SELECT * FROM " . TBL_DATI . " ORDER BY data ASC";
$result = $db->executeQuery($query);
$dati_prod_inverter = array();
$dati_prod_giornaliera = array();

if (function_exists('date_default_timezone_set'))
	date_default_timezone_set('UTC');

/* produzione precedente, utilizzata per calcolare la prod. giornaliera */
$prod_prec = 0;
$giorno_prec = 0; // giorno precedente
while ($result->next()) {
	$riga = $result->getCurrentValuesAsHash();
	$amg = explode('-', $riga[data]);
	$time_giorno = mktime(0, 0, 0, $amg[1], $amg[2], $amg[0]);
	$delta_giorni = (int) ($time_giorno - $giorno_prec) / (int) (3600 * 24);
	if ($giorno_prec == 0) $delta_giorni = 1;
	$timestamp = $time_giorno * 1000;
	$prod_oggi = $riga[prod_inverter] - $prod_prec;
	$prod_oggi /= $delta_giorni;

	$dati_prod_inverter[] = array($timestamp, $riga[prod_inverter]);
	$dati_prod_giornaliera[] = array($timestamp, $prod_oggi);
	$prod_prec = $riga[prod_inverter];
	$giorno_prec = $time_giorno;
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
 * Lista di grafici:
 * produzione giornaliera
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
	var d1 = <?php echo json_encode($dati_prod_giornaliera); ?>;

	$.plot($("#placeholder"), [
		{label: 'Produzione Inverter giornaliera', data: d1}/*,
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

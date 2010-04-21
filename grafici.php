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
$mese_prec = 0;
$tot_mesi = array();
$ultimo_mese_scorso = 0;
while ($result->next()) {
	$riga = $result->getCurrentValuesAsHash();
	$amg = explode('-', $riga[data]);
	$time_giorno = mktime(0, 0, 0, $amg[1], $amg[2], $amg[0]);
	
	// mese: tot_mesi[ANNO][mese]
	/*
	 * Questo valore viene sovrascritto ad ogni giorno, con il valore
	 * letto sul contatore.
	 * Di conseguenza al cambio di mese il valore che rimane nel mese
	 * precedente sara' l'ultimo del mese.
	 */
	if ($mese_prec != $amg[1]) {
		// Cambio del mese
		if ($mese_prec != 0)
			$ultimo_mese_scorso = $ultima_lettura;
		$mese_prec = $amg[1];
	}
	$ultima_lettura = $riga[prod_inverter];
	$tot_mesi[$amg[0]][$amg[1]] = $ultima_lettura - $ultimo_mese_scorso;

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


$dati_mesi = array();
foreach ($tot_mesi as $anno => $arr_mesi) {
	foreach ($arr_mesi as $mese => $val) {
		$timestamp = mktime(0, 0, 0, $mese, 1, $anno) * 1000;
		$dati_mesi[] = array($timestamp, $val);
	}
}


////// ANDAMENTO MEDIO
$mollosita = 5; // N.B: intero
$scalatura = 24 * $mollosita; // 1 giorno
$step = 1; // In ore, e' la definizione.
$delta = 6 * $scalatura; // E' il semisupporto del sinc, piu' e' grande piu' sara' accurato.
$PI = 3.1415;
$arr_media = array();
/* Aggiungo tot campioni a sinistra e a destra, clonando rispettivamente
 * il primo e l'ultimo valore. Questo per non avere degli zeri prima e dopo,
 * che influiscono sul valore nel grafico. */
for ($i = -$mollosita; $i < sizeof($dati_prod_giornaliera) + $mollosita; $i++) {
	if ($i < 0)
		$indice = 0; // Il primo valore
	else if ($i >= sizeof($dati_prod_giornaliera))
		$indice = sizeof($dati_prod_giornaliera) - 1; // l'ultimo
	else
		$indice = $i; // Quello giusto, il corrente.
	$ampiezza = $dati_prod_giornaliera[$indice][1];
	$ampiezza /= $mollosita;

	$traslazione = $dati_prod_giornaliera[$indice][0];
	// Divido altrimenti va in overflow e non gli piacciono key grandi
	$traslazione /= (60*60*1000);
	// Se sto utilizzando valori fittizi a sx e sd del grafico, li dovro'
	// traslare opportunamente, ognuno di un giorno.
	$traslazione += ($i - $indice) * 24;
	
	// Genero il sinc.
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



/* moltiplico un sinc traslato , ampiezza = valore
 * poi sommo tutto.
 * 
 * Lista di grafici:
 * produzione giornaliera
 * */


?>
<div id="placeholder" class="grafico"></div>
<div id="grafico_mesi" class="grafico"></div>
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
	var d2 = <?php echo json_encode($dati_mesi); ?>;
	var media1 = <?php echo json_encode($media); ?>;

	$.plot($("#placeholder"), [
		{label: 'Andamento medio', data: media1, points: { show: false }, hoverable: false},
		{label: 'Produzione Inverter giornaliera', data: d1}
	], {
		series: {
			lines: {show: true/*, fill: true*/},
			points: {show: true}
		},
		grid: {
            backgroundColor: { colors: ["#ddf", "#fff"] },
            hoverable: true
        },
        xaxis: {
			mode: "time",
			minTickSize: [1, "day"],
			monthNames: mesiIta,
			min: d1[0][0] - (24*60*60*1000), // Un giorno meno del primo giorno
			max: d1[d1.length - 1][0] + (24*60*60*1000)
		},
		colors: ["#A1C4FF", "#EDA840", "#ff009c", "#4da74d", "#aaa"]
	});

	// Roba per l'hover
	$("#placeholder").bind("plothover", funzioneMouseOver);

	/********************************
	          GRAFICO MESI
	*********************************/
	$.plot($("#grafico_mesi"), [
		{label: 'Produzione Inverter mensile', data: d2}
	], {
		series: {
			lines: { show: false, steps: false },
			bars: { show: true, barWidth: 15 * 24 * 60 * 60 * 1000, align: "center" }
		},
		grid: {
            backgroundColor: { colors: ["#ddf", "#fff"] },
            hoverable: true
        },
        xaxis: {
			tickFormatter: function (val, axis) {
				var d = new Date(val);
				return mesiIta[d.getUTCMonth()] + " "  + d.getFullYear();
			},
			mode: "time",
			minTickSize: [1, "month"]
		},
		colors: ["#79f"]
	});

	// Roba per l'hover
	$("#grafico_mesi").bind("plothover", funzioneMouseOver);
});
</script>


<?php

require_once('inc/footer.inc.php');
?>

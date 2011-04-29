<?php

$JS[] = 'js/jquery.js';
$JS[] = 'js/flot/jquery.flot.min.js';
$HEADER[] = '<!--[if IE]><script language="javascript" type="text/javascript" src="js/flot/excanvas.min.js"></script><![endif]-->';

require_once('inc/header.inc.php');

define('RICALCOLA_ANDAMENTO_MEDIO', false);


$query = "SELECT data,produzione FROM " . TBL_DATI . " ORDER BY data ASC";
$result = $db->executeQuery($query);
$dati_prod = array();
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
	$ultima_lettura = $riga[produzione];
	$tot_mesi[$amg[0]][$amg[1]] = $ultima_lettura - $ultimo_mese_scorso;

	$delta_giorni = (int) ($time_giorno - $giorno_prec) / (int) (3600 * 24);
	if ($giorno_prec == 0) $delta_giorni = 1;
	$timestamp = $time_giorno * 1000;
	$prod_oggi = $riga[produzione] - $prod_prec;
	$prod_oggi /= $delta_giorni;

	$dati_prod[] = array($timestamp, $riga[produzione]);
	$dati_prod_giornaliera[] = array($timestamp, $prod_oggi);
	$prod_prec = $riga[produzione];
	$giorno_prec = $time_giorno;
}


/////// ANDAMENTO MENSILE
$dati_mesi = array();
foreach ($tot_mesi as $anno => $arr_mesi) {
	foreach ($arr_mesi as $mese => $val) {
		$timestamp = mktime(0, 0, 0, $mese, 1, $anno) * 1000;
		$dati_mesi[] = array($timestamp, $val);
	}
}

// ANDAMENTO MENSILE BIS

// Questo si basa invece sui dati mensili, da marzo 2011 in poi.
$dati_mesi_new = array();
$query = "SELECT anno,mese,produzione FROM " . TBL_DATI_MENSILI . " ORDER BY anno, mese ASC";
$result = $db->executeQuery($query);
$precedente = -1;
while ($result->next()) {
	$riga = $result->getCurrentValuesAsHash();
	$timestamp = mktime(0, 0, 0, $riga[mese], 1, $riga[anno]) * 1000;

	$produzione = $riga[produzione];

	if ($precedente >= 0) {
		// non sono al primo mese
		$produzione -= $precedente;
	}
	$dati_mesi_new[] = array($timestamp, $produzione);
	$precedente = $riga[produzione];
}


if (RICALCOLA_ANDAMENTO_MEDIO):
////// ANDAMENTO MEDIO
$mollosita = 10; // N.B: intero
$scalatura = 24 * $mollosita; // 1 giorno
$step = 1; // In ore, e' la definizione.
$delta = 6 * $scalatura; // E' il semisupporto del sinc, piu' e' grande piu' sara' accurato.
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
			$sinc = $ampiezza * sin(pi() * ($t-$traslazione) / $scalatura) / (pi() * ($t-$traslazione) / $scalatura);
		$arr_media[$t] += $sinc;
	}
}

$media = array();
foreach ($arr_media as $k => $v) {
	$media[] = array($k*1000*60*60, $v);
}

// La salvo in cache
file_put_contents('andamento_medio.dat', json_encode($media));

else:
$media = json_decode(file_get_contents('andamento_medio.dat'));
endif;


/* moltiplico un sinc traslato , ampiezza = valore
 * poi sommo tutto.
 * 
 * Lista di grafici:
 * produzione giornaliera
 * */


?>
<div id="placeholder" class="grafico"></div>
<div id="grafico_mesi" class="grafico"></div>
<div id="grafico_mesi_new" class="grafico"></div>
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
				d +": <strong>" + y + " kWh</strong>"
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
	var d3 = <?php echo json_encode($dati_mesi_new); ?>;
	var media1 = <?php echo json_encode($media); ?>;

	$.plot($("#placeholder"), [
		{label: 'Andamento medio', data: media1, points: { show: false }, hoverable: false},
		{label: 'Produzione giornaliera', data: d1}
	], {
		series: {
			lines: {show: true/*, fill: true*/},
			points: {show: true}
		},
		legend: {
			position: "nw"
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
		yaxis: {
			min: 0
		},
		colors: ["#A1C4FF", "#EDA840", "#ff009c", "#4da74d", "#aaa"]
	});

	// Roba per l'hover
	$("#placeholder").bind("plothover", funzioneMouseOver);

	/********************************
	          GRAFICO MESI
	*********************************/
	$.plot($("#grafico_mesi"), [
		{label: 'Produzione mensile', data: d2}
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


	/********************************
	          GRAFICO MESI NEW
	*********************************/
	$.plot($("#grafico_mesi_new"), [
		{label: 'Produzione mensile', data: d3}
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
	$("#grafico_mesi_new").bind("plothover", funzioneMouseOver);
});
</script>


<?php

require_once('inc/footer.inc.php');
?>

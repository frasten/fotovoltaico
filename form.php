<?php

$CSS[] = 'css/insertform.css';
$CSS[] = 'css/cupertino/jquery-ui.css';

$JS[] = 'js/jquery.js';
$JS[] = 'js/jquery-ui.js';
$JS[] = 'js/jquery.ui.datepicker-it.js';

require_once('inc/header.inc.php');

?>
<script type="text/javascript">
$(function() {
	$("#data").datepicker($.datepicker.regional['it']);

	$("#divtempo input[type=radio]").change(function(){
		$(this).parent().parent().find(".tempoSelezionato").removeClass("tempoSelezionato");
		$(this).parent().addClass("tempoSelezionato");
	})

	jQuery("td").filter(function(){return this.innerHTML == 'F1'}).addClass("fascia1")
	jQuery("td").filter(function(){return this.innerHTML == 'F2'}).addClass("fascia2")
	jQuery("td").filter(function(){return this.innerHTML == 'F3'}).addClass("fascia3")

	$("input[type='text']").attr("autocomplete", "off");
});
</script>
<form action='salvaform.php' method='post'>
<div class="divData">
	<label for="data">Data:</label>
	<input type='text' id='data' name='data' size="7" value='<?php echo date("d/m/Y"); ?>' />
</div>

<fieldset>
	<legend>Produzione/consumi</legend>
	<ol>
		<li>
			<label for="prod_inverter">Produzione Inverter:</label>
			<input type='text' id='prod_inverter' name='prod_inverter' value='' />
		</li>
		<li>
			<label for="produzione">Produzione:</label>
			<input type='text' id='produzione' name='produzione' value='' />
		</li>
		<li>
			<label for="ceduti">Ceduti:</label>
			<input type='text' id='ceduti' name='ceduti' value='' />
		</li>
		<li>
			<label for="consumati">Autoconsumati:</label>
			<input type='text' id='consumati' name='consumati' value='' />
		</li>
	</ol>
	<div id='divtempo'>
		<h4>Tempo:</h4>
		<ol>
			<li>
				<label for="meteoSereno"><img src="img/meteo/sereno.png" alt="Sereno" title="Sereno" /></label>
				<input type="radio" id="meteoSereno" name="tempo" value="S" />
			</li>
			<li>
				<label for="meteoVariabile"><img src="img/meteo/variabile.png" alt="Variabile" title="Variabile"/></label>
				<input type="radio" id="meteoVariabile" name="tempo" value="NS" />
			</li>
			<li>
				<label for="meteoNuvoloso"><img src="img/meteo/nuvoloso.png" alt="Nuvoloso" title="Nuvoloso"/></label>
				<input type="radio" id="meteoNuvoloso" name="tempo" value="N" />
			</li>
			<li>
				<label for="meteoPioggia"><img src="img/meteo/pioggia.png" alt="Pioggia" title="Pioggia"/></label>
				<input type="radio" id="meteoPioggia" name="tempo" value="P" />
			</li>
			<li>
				<label for="meteoTemporale"><img src="img/meteo/temporale.png" alt="Temporale" title="Temporale"/></label>
				<input type="radio" id="meteoTemporale" name="tempo" value="T" />
			</li>
			<li>
				<label for="meteoNeve"><img src="img/meteo/neve.png" alt="Neve" title="Neve"/></label>
				<input type="radio" id="meteoNeve" name="tempo" value="V" />
			</li>
		</ol>
	</div>
</fieldset>

<fieldset>
	<legend>Prelievi nelle varie fasce</legend>
	<ol>
		<li>
			<label for='prelievo_f1'>F1:</label>
			<input type='text' id='prelievo_f1' name='prelievo_f1' value='' />
		</li>
		<li>
			<label for="prelievo_f2">F2:</label>
			<input type='text' id='prelievo_f2' name='prelievo_f2' value='' />
		</li>
		<li>
			<label for="prelievo_f3">F3:</label>
			<input type='text' id='prelievo_f3' name='prelievo_f3' value='' />
		</li>
	</ol>
	<table>
		<thead>
		<tr>
			<td>Giorno</td><td>0-7</td><td>7-8</td><td>8-19</td><td>19-23</td><td>23-24</td>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>Lun</td><td>F3</td><td>F2</td><td>F1</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Mar</td><td>F3</td><td>F2</td><td>F1</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Mer</td><td>F3</td><td>F2</td><td>F1</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Gio</td><td>F3</td><td>F2</td><td>F1</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Ven</td><td>F3</td><td>F2</td><td>F1</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Sab</td><td>F3</td><td>F2</td><td>F2</td><td>F2</td><td>F3</td>
		</tr>
		<tr>
			<td>Dom</td><td>F3</td><td>F3</td><td>F3</td><td>F3</td><td>F3</td>
		</tr>
		</tbody>
	</table>
</fieldset>

<fieldset class="submit">
	<input type="submit" value="Salva" />
</fieldset>
</form>
<?php require_once('inc/footer.inc.php'); ?>

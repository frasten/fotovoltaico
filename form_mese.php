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

	jQuery("td").filter(function(){return this.innerHTML == 'F1'}).addClass("fascia1")
	jQuery("td").filter(function(){return this.innerHTML == 'F2'}).addClass("fascia2")
	jQuery("td").filter(function(){return this.innerHTML == 'F3'}).addClass("fascia3")

	$("input[type='text']").attr("autocomplete", "off");
});
</script>
<form action='salvaform_mese.php' method='post'>
<div class="divMeseAnno">
	<label for="mese">Mese:</label>
	<select id="mese" name="mese">
		<?php
		$mesi = array('Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
		foreach ($mesi as $n => $m) {
			$corrente = (date("m") == $n+1 ? ' selected="selected"' : '');
			printf("<option value='%d' %s>%s</option>\n", ($n+1), $corrente, $m);
		}
		?>
	</select>
	<label for="anno">Anno:</label>
	<input type='text' id='anno' name='anno' size="7" value='<?php echo date("Y"); ?>' />
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

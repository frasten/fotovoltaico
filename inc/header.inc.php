<?php

require_once('db.inc.php');

$CSS[] = 'css/stili.css';

if (!$TITOLO) $TITOLO = "Fotovoltaico";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?php echo $TITOLO;?></title>
<?php
	if (is_array($CSS)) {
		foreach ($CSS as $file) {
			echo "\t<link rel='stylesheet' type='text/css' href='$file' />\n";
		}
	}

	if (is_array($JS)) {
		foreach ($JS as $file) {
			echo "\t<script type='text/javascript' src='$file'></script>\n";
		}
	}

	if (is_array($HEADER)) {
		foreach ($HEADER as $line) {
			echo "\t$line\n";
		}
	}
?>
</head>
<body>
	<ul id="nav">
		<li><a href='lista.php'>Lista</a></li>
		<li><a href='form.php'>Inserimento</a></li>
		<li><a href='grafici.php'>Grafici</a></li>
	</ul>

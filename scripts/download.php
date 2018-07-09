<?php
	$arquivo= $_GET['baixar'];
	header("Content-type: application/save");
	header("Content-Length:".filesize($arquivo));
	header('Content-Disposition: attachment; filename="' . $arquivo. '"');
	readfile("$arquivo");
?>
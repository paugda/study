<?php
$db = new SQLite3('dietetyk.db'); //tworzenie bazy danych

$kategorie = array(
	'pieczywo',
	'nabiał',
	'mięso',
	'warzywa'
); //kategorie produktów
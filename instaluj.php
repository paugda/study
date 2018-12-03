<?php
require_once('config.php'); //wczytanie bazy danych 
$db->exec("DROP TABLE IF EXISTS users");
$db->exec("CREATE TABLE IF NOT EXISTS users (id_user INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login TEXT, haslo TEXT)");
$db->exec("INSERT OR IGNORE INTO users (id_user, login, haslo) VALUES (1, 'admin', '".md5('12345')."')");


$db->exec("DROP TABLE IF EXISTS products");
$db->exec("CREATE TABLE IF NOT EXISTS products (id_product INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(100), kcal INTEGER, category VARCHAR(50))");
$db->exec("INSERT OR IGNORE INTO products (name, kcal, category) VALUES ('marchewka', 10, 'warzywa'), ('masło', 200, 'nabiał'), ('karkówka', 150, 'mięso'), ('bułka', 70, 'pieczywo'), ('kurczak', 300, 'mięso'), ('seler', 15, 'warzywa')");


echo 'Instalacja przebiegła pomyślnie! Login: <b>admin</b> Hasło: <b>12345</b><br/><a href="index.php">Strona główna</a>';
?>
<?php
 $f = fopen(__DIR__ . '/.env', 'r');
 $lines = explode("\n", fread($f, filesize(__DIR__ . '/.env')));
 $env = [];
 foreach($lines as $line){
     [$key, $value] = explode('=', $line);
     $env[$key] = $value;
 }

$sql = "CREATE TABLE
  entities (
    id varchar(64) NOT NULL,
    text text NOT NULL,
    number int NOT NULL,
    date date NOT NULL,
    file varchar(25) NOT NULL DEFAULT '',
    createdAt datetime NOT NULL,
    PRIMARY KEY (`id`)
  )";

$pdo = new PDO("mysql:dbname={$env['DATABASE_NAME']};host={$env['HOST']}", $env['DATABASE_USER'], $env['DATABASE_PASSWORD']);
$pdo->query($sql);
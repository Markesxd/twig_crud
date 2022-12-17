<?php

namespace Rafael\TwigCrud\Database;

use PDO;

class Connection
{

    private PDO $pdo;

    public function __construct()
    {
        global $env;
        $this->pdo = new PDO("mysql:dbname={$env['DATABASE_NAME']};host={$env['HOST']}", $env['DATABASE_USER'], $env['DATABASE_PASSWORD']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 

    public function add(string $table, array $data)
    {
        $keys = array_keys($data);
        $names = '(' . implode(', ', $keys) . ')';
        foreach($keys as &$key){
            $key = ':' . $key;
        }
        $values = '(' . implode(', ', $keys) . ')';
        $sql = "INSERT INTO $table $names VALUES $values";
        $this->pdo->prepare($sql)->execute($data);
    }

    public function retrieve(string $table, int $page, ?int $limit = 5)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM $table LIMIT $offset,$limit";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function retrieveOne(string $table, string $id)
    {
        $sql = "SELECT * FROM $table WHERE id='$id'";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    public function remove(string $table, $id)
    {
        $sql = "DELETE FROM $table WHERE id=:id";
        $this->pdo->prepare($sql)->execute(['id' => $id]);
    }

    public function alter(string $table, $id, array $data)
    {
        $keys = array_keys($data);
        $valuesArray = [];
        foreach($keys as $key){
            $valuesArray[] = "$key=:$key ";
        }
        $values = implode(', ', $valuesArray);
        $sql = "UPDATE $table SET $values WHERE id=:id";
        $this->pdo->prepare($sql)->execute($data);
    }
}
<?php

namespace Rafael\TwigCrud\Model;

use DateTimeImmutable;
use Rafael\TwigCrud\Database\Connection;

class Entity
{
    private static string $table = 'entities';

    private string $id;
    private string $text;
    private int $number;
    private ?DateTimeImmutable $date;
    private string $file;
    private ?DateTimeImmutable $createdAt;

    public function create(): self
    {
        $connection = new Connection;
        $this->id = bin2hex(random_bytes(32));
        $data = $this->getData();
        $this->createdAt = new DateTimeImmutable();
        $data['createdAt'] = $this->createdAt->format('Y-m-d');
        $connection->add(self::$table, $data);
        return $this;
    }

    public function remove(string $id): self
    {
        $connection = new Connection;
        $connection->remove('entities', $this->id);
        return $this;
    }

    public function edit(): self
    {
        $connection = new Connection;
        $connection->alter(self::$table, $this->id, $this->getData());
        return $this;
    }

    public function setAll(array $properties): self
    {
        $this->id = $properties['id'] ?? '-';
        $this->text = $properties['text'] ?? '';
        $this->number = $properties['number'] ?? 0;
        $this->date = $properties['date'] === null ? null : new DateTimeImmutable($properties['date']);
        $this->file = $properties['file'] ?? '';
        return $this;
    }

    private function getData(): array
    {
        $data = [];
        $data['id'] = $this->id;
        $data['text'] = $this->text;
        $data['number'] = $this->number;
        $data['date'] = $this->date->format('Y-m-d');
        $data['file'] = $this->file;
        return $data;
    }

    public function handleFile(): self
    {
        if($_FILES['file']['error'] === 4){
            $this->file = '';
            return $this;
        } else if($_FILES['file']['error'] !== 0){
            //handle error here
            return $this;
        }

        $fileName = bin2hex(random_bytes(10)) . '.' . explode('.', ($_FILES['file']['name']))[1];
        $this->file = $fileName;
        move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . "/../Database/Uploads/$fileName");
        return $this;
    }

    public function changeFile(): self
    {
        if($_FILES['file']['error'] === 4){
            return $this;
        }
        $connection = new Connection;
        $oldFileName = $connection->retrieveOne(self::$table, $this->id)['file'];
        if($oldFileName === ''){
            $this->handleFile();
            return $this;
        }
        $fileName = explode('.', $oldFileName)[0] . '.' . explode('.', ($_FILES['file']['name']))[1];
        move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . "/../Database/Uploads/$fileName");
        $this->file = $fileName;
        return $this;
    }

    public function removeFile(): self
    {
        $connection = new Connection;
        $fileName = $connection->retrieveOne(self::$table, $this->id)['file'];
        unlink(__DIR__. "/../Database/Uploads/$fileName");
        return $this;
    }

    public static function getEntitiesAsArray(?int $page = 1): array
    {
        $connection = new Connection;
        $data = $connection->retrieve(self::$table, $page);
        foreach($data as &$cell){
            $cell['date'] = (new DateTimeImmutable($cell['date']))->format('d/m/Y');
        }
        return $data;
    }

    public static function getEntityAsArray(string $id): array
    {
        $connection = new Connection;
        $data = $connection->retrieveOne(self::$table, $id);
        $data['date'] = (new DateTimeImmutable($data['date']))->format('d/m/Y');
        return $data;
    }
}
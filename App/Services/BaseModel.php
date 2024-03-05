<?php

namespace App\Services;

require "../../vendor/autoload.php";
require "../../bootstrap/init.php";

use Medoo\Medoo;
use Exception;

class BaseModel
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct($table)
    {
        $this->table = $table;
        try {
            global $databaseCongif;
            $this->connection = new Medoo(['type' => $databaseCongif['type'], 'host' => $databaseCongif['host'], 'database' => $databaseCongif['dbName'], 'username' => $databaseCongif['username'], 'password' => $databaseCongif['password']]);
        } catch (Exception $error) {
            echo $error->getMessage();
        }
    }
    # create function
    public function create(array $data): int
    {
        $this->connection->insert($this->table, $data);
        return $this->connection->id();
    }
    # get all items function
    public function getAll(): array
    {
        return $this->connection->select($this->table, '*');
    }

    public function get(array $culomns, array $where): array
    {
        return $this->connection->select($this->table, $culomns, $where);
    }
    # find by id
    public function find(int $id): object
    {
        $result = $this->connection->get($this->table, '*', [$this->primaryKey => $id]);
        return (object)$result;
    }
}

<?php

namespace App\Models\Contract;

use Medoo\Medoo;

class MysqlBaseModel extends BaseModel
{
    public function __construct($id = null)
    {
        try {
            $this->connection = new Medoo([
                'type' => 'mysql',
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASS']
            ]);
        } catch (\PDOException $pe) {
            echo "Error Connecting to the database: " . $pe->getMessage();
        }

        if ($id != null) {
            return $this->find($id);
        }
    }

    public function create(array $data): int
    {
        $this->connection->insert($this->table, $data);
        return $this->connection->id();
    }

    public function find(int $id): object
    {
        $result = $this->connection->get($this->table, '*', [$this->primaryKey => $id]);
        if (is_null($result))
            return (object)null;
        foreach ($result as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    public function get($columns, array $where): array
    {
        $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
        $start = ($page - 1) * $this->pageSize;
        $where['LIMIT'] = [$start, $this->pageSize];
        return $this->connection->select($this->table, $columns, $where);
    }

    public function getAll(): array
    {
        return $this->get('*', []);
    }

    public function update(array $data, array $where): int
    {
        $result = $this->connection->update($this->table, $data, $where);
        return $result->rowCount();
    }

    public function save(): int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->update($this->attributes, [$this->primaryKey => $record_id]);
    }

    public function delete(array $where): int
    {
        $result = $this->connection->delete($this->table, $where);
        return $result->rowCount();
    }

    public function remove(): int
    {
        $record_id = $this->{$this->primaryKey};
        return $this->delete([$this->primaryKey => $record_id]);
    }

    public function select($columns = '*', array $where = []): array
    {
        return $this->connection->select($this->table, $columns, $where);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->attributes)) {
            return null;
        }
        $this->attributes[$key] = $value;
    }
}

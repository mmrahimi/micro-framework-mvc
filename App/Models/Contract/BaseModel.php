<?php

namespace App\Models\Contract;

abstract class BaseModel implements CrudInterface
{
    protected $connection;
    protected $table;
    protected $primaryKey = 'id';
    protected $pageSize = 10;
    protected $attributes = [];

    public function getAttribute($key): mixed
    {
        if (!$key || !array_key_exists($key, $this->attributes)) {
            return null;
        }
        return $this->attributes[$key];
    }
}

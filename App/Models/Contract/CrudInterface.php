<?php

namespace App\Models\Contract;

interface CrudInterface
{
    public function create(array $data): int;

    public function find(int $id): object;

    public function get($columns, array $where): array;

    public function update(array $data, array $where): int;

    public function delete(array $where): int;
}

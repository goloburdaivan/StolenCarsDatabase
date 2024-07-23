<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface Searchable
{
    public function search(array $args): LengthAwarePaginator;
}

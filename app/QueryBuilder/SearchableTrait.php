<?php

namespace App\QueryBuilder;

use App\Constants\App;
use Illuminate\Pagination\LengthAwarePaginator;

trait SearchableTrait
{
    public function search(array $args): LengthAwarePaginator
    {
        return $this->searchQuery($args)->paginate(App::PER_PAGE);
    }

    public function searchQuery(array $args): static
    {
        return $this->latest();
    }
}

<?php

namespace App\QueryBuilder;

use App\Models\Auto;
use Illuminate\Database\Eloquent\Builder;

class AutoQueryBuilder extends Builder
{
    use SearchableTrait;

    public function searchQuery(array $args): static
    {
        if (!empty($args['color'])) {
            $this->where('color', $args['color']);
        }

        if (!empty($args['brand'])) {
            $this->whereIn('brand', $args['brand']);
        }

        if (!empty($args['model'])) {
            $this->whereIn('model', $args['model']);
        }

        if (!empty($args['year'])) {
            $this->whereIn('year', $args['year']);
        }

        if (!empty($args['q'])) {
            $this->whereFullText(Auto::FULLTEXT_SEARCH_FIELDS, $args['q']);
        }

        return $this->orderBy($args['sort_by'] ?? 'id', $args['sort_type'] ?? 'desc');
    }
}

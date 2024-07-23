<?php

namespace App\DTO;

use App\Contracts\CastsToFillable;

class AutoDTO implements CastsToFillable
{
    public function __construct(
      public ?string $brand,
      public ?string $model,
      public ?int $year,
    ) {
    }

    public function toFillable(): array
    {
        return [
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
        ];
    }
}

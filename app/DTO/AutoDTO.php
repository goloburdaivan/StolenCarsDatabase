<?php

namespace App\DTO;

class AutoDTO
{
    public function __construct(
      public ?string $brand,
      public ?string $model,
      public ?int $year,
    ) {
    }
}

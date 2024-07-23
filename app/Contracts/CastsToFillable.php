<?php

namespace App\Contracts;

interface CastsToFillable
{
    public function toFillable(): array;
}

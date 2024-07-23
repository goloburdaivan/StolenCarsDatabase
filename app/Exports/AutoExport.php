<?php

namespace App\Exports;

use App\Models\Auto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class AutoExport implements FromCollection
{
    public function __construct(
        private array $filters
    ) {
    }

    public function collection()
    {
        return Auto::query()->search($this->filters);
    }
}

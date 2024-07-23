<?php

namespace App\Repository;

use App\Exceptions\AutoMakeUpdateException;
use App\Models\AutoMake;
use Illuminate\Database\Eloquent\Collection;

class AutoMakesRepository
{
    /**
     * @throws AutoMakeUpdateException
     */
    public function create(array $data): AutoMake
    {
        $make = new AutoMake();

        return $this->update($make, $data);
    }

    /**
     * @throws AutoMakeUpdateException
     */
    public function update(AutoMake $make, array $data): AutoMake
    {
        $make->fill($data);

        if (!$make->save()) {
            throw new AutoMakeUpdateException("Error on updating auto model!");
        }

        return $make;
    }

    public function findByMakeId(string $makeId): ?AutoMake
    {
        return AutoMake::query()->where('make_id', $makeId)->first();
    }

    public function autoCompleteByName(string $name): Collection
    {
        return AutoMake::query()->where('name', 'like', '%' . $name . '%')->get();
    }
}

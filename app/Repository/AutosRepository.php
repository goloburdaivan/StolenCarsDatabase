<?php

namespace App\Repository;

use App\Events\AutoUpdatedEvent;
use App\Exceptions\AutoUpdateException;
use App\Models\Auto;

class AutosRepository
{
    /**
     * @throws AutoUpdateException
     */
    public function create(array $data): Auto
    {
        unset(
            $data['brand'],
            $data['model'],
            $data['year'],
        );

        $auto = new Auto();

        return $this->update($auto, $data);
    }

    /**
     * @throws AutoUpdateException
     */
    public function update(Auto $auto, array $data): Auto
    {
        $auto->fill($data);

        $originalValues = $auto->getOriginal();
        $changedValues = $auto->getDirty();

        if (!$auto->save()) {
            throw new AutoUpdateException("Error while saving auto to database");
        }

        event(new AutoUpdatedEvent($auto, $originalValues, $changedValues));

        return $auto;
    }

    public function remove(Auto $auto): Auto
    {
        $auto->delete();

        return $auto;
    }
}

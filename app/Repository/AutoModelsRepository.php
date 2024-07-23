<?php

namespace App\Repository;

use App\Exceptions\AutoModelUpdateException;
use App\Models\AutoModel;

class AutoModelsRepository
{
    /**
     * @throws AutoModelUpdateException
     */
    public function create(array $data): AutoModel
    {
        $model = new AutoModel();

        return $this->update($model, $data);
    }

    /**
     * @throws AutoModelUpdateException
     */
    public function update(AutoModel $model, array $data): AutoModel
    {
        $model->fill($data);

        if (!$model->save()) {
            throw new AutoModelUpdateException("Error on updating auto model!");
        }

        return $model;
    }

    public function findByModelId(string $modelId): ?AutoModel
    {
        return AutoModel::query()->where('model_id', $modelId)->first();
    }
}

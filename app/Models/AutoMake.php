<?php

namespace App\Models;

use App\Constants\Time;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Collection<int, AutoModel> $models
 */
class AutoMake extends Model
{
    use HasFactory;

    protected $fillable = [
        'make_id',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime:' . Time::TIME_FORMAT,
        'updated_at' => 'datetime:' . Time::TIME_FORMAT,
    ];

    public function models(): HasMany
    {
        return $this->hasMany(AutoModel::class, 'make_id', 'make_id');
    }
}

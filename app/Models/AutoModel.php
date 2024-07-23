<?php

namespace App\Models;

use App\Constants\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id,
 * @property int $model_id
 * @property int $make_id
 * @property string $name
 */
class AutoModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'make_id',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime:' . Time::TIME_FORMAT,
        'updated_at' => 'datetime:' . Time::TIME_FORMAT,
    ];

    public function make(): BelongsTo
    {
        return $this->belongsTo(AutoMake::class, 'make_id', 'make_id');
    }
}

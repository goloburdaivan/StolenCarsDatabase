<?php

namespace App\Models;

use App\Constants\Time;
use App\QueryBuilder\AutoQueryBuilder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $vin_code
 * @property string $plate_number
 * @property string $color
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static AutoQueryBuilder query()
 */
class Auto extends Model
{
    use HasFactory;

    public const FULLTEXT_SEARCH_FIELDS = [
        'vin_code',
        'plate_number',
        'name',
    ];

    protected $fillable = [
        'vin_code',
        'plate_number',
        'brand',
        'model',
        'year',
        'color',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime:' . Time::TIME_FORMAT,
        'updated_at' => 'datetime:' . Time::TIME_FORMAT,
    ];


    /**
     * @param $query
     * @return AutoQueryBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new AutoQueryBuilder($query);
    }
}

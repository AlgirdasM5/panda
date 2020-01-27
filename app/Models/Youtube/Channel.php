<?php

namespace App\Models\Youtube;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Channel
 * @package App\Models\Youtube
 * @method static Channel updateOrCreate(array $find, array $data)
 * @property string $id
 */
class Channel extends Model
{
    const TARGET_ID = 'UCfar0VRbYG12IlPgy0peMTA';

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
    ];
}

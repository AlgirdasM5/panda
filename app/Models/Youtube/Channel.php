<?php

namespace App\Models\Youtube;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Channel
 * @package App\Models\Youtube
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

    protected $keyType = 'string';

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'channel_id', 'id');
    }
}

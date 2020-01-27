<?php

namespace App\Models\Youtube;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 * @package App\Models\Youtube
 * @method static Video updateOrCreate(array $find, array $data)
 * @property string $id
 * @property string $channel_id
 * @property string title
 * @property array $tags
 * @property Carbon $published_at
 */
class Video extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'channel_id',
        'title',
        'tags',
        'published_at',
    ];
}

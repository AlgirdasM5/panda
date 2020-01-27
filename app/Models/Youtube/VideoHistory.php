<?php

namespace App\Models\Youtube;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VideoHistory
 * @package App\Models\Youtube
 * @property string $id
 * @property string $video_id
 * @property int $view_count
 */
class VideoHistory extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'video_id',
        'view_count',
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = new Carbon();
        });
    }
}

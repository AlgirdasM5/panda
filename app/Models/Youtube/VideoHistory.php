<?php

namespace App\Models\Youtube;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class VideoHistory
 * @package App\Models\Youtube
 * @property string $id
 * @property string $video_id
 * @property int $view_count
 * @property Carbon $created_at
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

    /**
     * @return BelongsTo
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}

<?php

namespace App\Models\Youtube;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Video
 * @package App\Models\Youtube
 * @property string $id
 * @property string $channel_id
 * @property string title
 * @property array $tags
 * @property Carbon $published_at
 * @property integer $first_hour_views
 * @property integer $aggregated_views
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

    protected $keyType = 'string';

    /**
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function histories(): HasMany
    {
        return $this->hasMany(VideoHistory::class, 'video_id', 'id');
    }

    /**
     * @param string $id
     * @return \Illuminate\Support\Collection
     */
    public function getHistoriesById(string $id): \Illuminate\Support\Collection
    {
        return $this
            ->newQuery()
            ->selectRaw('video_histories.*')
            ->join('video_histories', 'videos.id', '=', 'video_histories.video_id')
            ->where('videos.id', '=', $id)
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getWithFirstHourViews(): \Illuminate\Support\Collection
    {
        return $this->all()->map(function ($item) {
            $sum = 0;

            /** @var Video $item */
            foreach ($item->getHistoriesById($item->id) as $history) {
                /** @var VideoHistory $history */
                if (new Carbon($history->created_at) < new Carbon($item->published_at)) {
                    $sum += $history->view_count;
                }
            }

            $item->first_hour_views = $sum;

            return $item;
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function aggregated(): \Illuminate\Support\Collection
    {
        $withFirstHour = $this->getWithFirstHourViews();

        $median = $withFirstHour->median('first_hour_views');

        $aggregated = $withFirstHour->map(function ($item) use ($median) {
            $item->aggregated_views = $item->first_hour_views / $median;

            return $item;
        });

        return $aggregated;
    }
}

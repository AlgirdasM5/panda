<?php

namespace App\Models\Youtube;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class Video
 * @package App\Models\Youtube
 * @property string $id
 * @property string $channel_id
 * @property string title
 * @property string $tags
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
     * @return VideoHistory|object|null
     */
    protected function lastHistory(string $id): ?object
    {
        // plain SQL as requested:
        // "SELECT video_histories.*
        // FROM videos
        // JOIN video_histories ON video_histories.video_id = videos.id
        // WHERE videos.id = {{ $id }}
        // ORDER BY video_histories.id DESC
        // LIMIT 1"

        return $this
            ->newQuery()
            ->selectRaw('video_histories.*')
            ->join('video_histories', 'videos.id', '=', 'video_histories.video_id')
            ->where('videos.id', '=', $id)
            ->orderByDesc('video_histories.id')
            ->limit(1)
            ->first();
    }

    /**
     * @param string $tagsNeedle
     * @return Collection
     */
    protected function getFilteredWithViews(string $tagsNeedle): Collection
    {
        return $this->all()->map(function ($item) use ($tagsNeedle) {
            if (!empty($tagsNeedle) && strpos($item->tags, $tagsNeedle) === false) {
                return false;
            }

            /** @var Video $item */
            $history = $item->lastHistory($item->id);

            $item->first_hour_views
                = new Carbon($history->created_at) < new Carbon($item->published_at)
                ? $history->view_count
                : 0;

            return $item;
        })->reject(function ($value) {
            return $value === false;
        });
    }

    /**
     * @param string $tagsNeedle
     * @param string $viewNeedle
     * @return Collection
     */
    public function getAggregated(string $tagsNeedle, string $viewNeedle): Collection
    {
        $withFirstHour = $this->getFilteredWithViews($tagsNeedle);

        $median = $withFirstHour->median('first_hour_views');

        $aggregated = $withFirstHour->map(function ($item) use ($median, $viewNeedle) {
            $item->aggregated_views = $median ? $item->first_hour_views / $median : 0;

            if ($viewNeedle !== '' && strpos((string)$item->aggregated_views, $viewNeedle) === false) {
                return false;
            }

            return $item;
        })->reject(function ($value) {
            return $value === false;
        });

        return $aggregated;
    }
}

<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\Video;
use Carbon\Carbon;
use Google_Service_YouTube_Video;
use Google_Service_YouTube_VideoSnippet;
use Exception;
use Illuminate\Support\Collection;

class VideoFactory
{
    /**
     * @var string
     */
    protected $channelId;

    /**
     * @var Google_Service_YouTube_Video
     */
    protected $response;

    /**
     * @throws Exception
     */
    public function create()
    {
        $model = new Video();

        $snippet = $this->response->getSnippet();
        $map = $this->map($snippet);

        $model->newQuery()->updateOrCreate([
            'id' => $this->response->getId(),
        ], $map->toArray());
    }

    /**
     * @param Google_Service_YouTube_VideoSnippet $snippet
     * @return Collection
     * @throws Exception
     */
    protected function map(Google_Service_YouTube_VideoSnippet $snippet): Collection
    {
        return collect([
            'id' => $this->response->getId(),
            'published_at' => new Carbon($snippet->getPublishedAt()),
            'tags' => $snippet->getTags() ? implode(',', $snippet->getTags()) : '',
            'title' => $snippet->getTitle(),
            'channel_id' => $this->channelId,
        ]);
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId)
    {
        $this->channelId = $channelId;
    }

    /**
     * @param Google_Service_YouTube_Video $response
     */
    public function setResponse(Google_Service_YouTube_Video $response)
    {
        $this->response = $response;
    }
}

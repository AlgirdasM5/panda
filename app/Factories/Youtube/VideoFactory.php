<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\Video;
use Carbon\Carbon;
use Google_Service_YouTube_Video;
use Exception;

class VideoFactory
{
    /**
     * @var Google_Service_YouTube_Video
     */
    protected $video;

    /**
     * @return Video
     * @throws Exception
     */
    public function create(): Video
    {
        $model = new Video();

        $snippet = $this->video->getSnippet();

        $model->setId($this->video->getId());
        $model->setPublishedAt(new Carbon($snippet->getPublishedAt()));
        $model->setTags($snippet->getTags() ?: []);
        $model->setTitle($snippet->getTitle());
        $model->setChannelId($snippet->getChannelId());
        $model->setCreatedAt(new Carbon());

        return $model;
    }

    /**
     * @param Google_Service_YouTube_Video $video
     */
    public function setVideo(Google_Service_YouTube_Video $video)
    {
        $this->video = $video;
    }
}

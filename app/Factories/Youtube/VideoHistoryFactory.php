<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\VideoHistory;
use Carbon\Carbon;
use Google_Service_YouTube_Video;
use Exception;

class VideoHistoryFactory
{
    /**
     * @var Google_Service_YouTube_Video
     */
    protected $video;

    /**
     * @return VideoHistory
     * @throws Exception
     */
    public function create(): VideoHistory
    {
        $model = new VideoHistory();

        $model->setVideoId($this->video->getId());
        $model->setViewCount($this->video->getStatistics()->getViewCount());
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

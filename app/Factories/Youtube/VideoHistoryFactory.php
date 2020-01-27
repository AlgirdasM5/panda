<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\VideoHistory;
use Google_Service_YouTube_Video;

class VideoHistoryFactory
{
    /**
     * @var Google_Service_YouTube_Video
     */
    protected $response;

    /**
     *
     */
    public function create()
    {
        $model = new VideoHistory([
            'video_id' => $this->response->getId(),
            'view_count' => $this->response->getStatistics()->getViewCount(),
        ]);

        $model->save();
    }

    /**
     * @param Google_Service_YouTube_Video $response
     */
    public function setResponse(Google_Service_YouTube_Video $response)
    {
        $this->response = $response;
    }
}

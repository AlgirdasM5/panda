<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\YoutubeResource;
use App\Models\Youtube\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class YoutubeApiController extends Controller
{
    /**
     * @var Video
     */
    private $video;

    /**
     * YoutubeApiController constructor.
     * @var Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * @param Request $request
     * @return ResourceCollection
     */
    public function getStats(Request $request): ResourceCollection
    {
        $result = $this->video
            ->aggregated()
        ;

        return YoutubeResource::collection($result);
    }
}

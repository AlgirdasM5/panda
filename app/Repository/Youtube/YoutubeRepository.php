<?php

namespace App\Repository\Youtube;

use App\Models\Youtube\Channel;
use App\Service\Youtube\YoutubeService;
use Google_Service_YouTube_PlaylistItemListResponse;
use Google_Service_YouTube_VideoListResponse;
use JMS\Serializer\Serializer;

class YoutubeRepository
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var YoutubeService
     */
    private $youtubeService;

    /**
     * YoutubeRepository constructor.
     * @param Serializer $serializer
     * @param YoutubeService $youtubeService
     */
    public function __construct(Serializer $serializer, YoutubeService $youtubeService) {
        $this->serializer = $serializer;
        $this->youtubeService = $youtubeService;
    }

    /**
     * @param string $id
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getPlaylistItemsById($id = Channel::TARGET_ID): Google_Service_YouTube_PlaylistItemListResponse
    {
        $response = $this->youtubeService->getPlaylistItems('contentDetails', ['playlistId' => $id]);

        return $response;
    }

    /**
     * @param string $id
     * @return Google_Service_YouTube_VideoListResponse
     */
    public function getVideoInfoById($id = 'iw-gHTZhuKg,qkIrXWvOX5E'): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->youtubeService->getVideoInfo('snippet,statistics', ['id' => $id]);

        return $response;
    }
}

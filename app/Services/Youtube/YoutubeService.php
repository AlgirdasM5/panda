<?php

namespace App\Services\Youtube;

use Google_Service_YouTube_PlaylistItemListResponse;
use Google_Service_YouTube_PlaylistListResponse;
use Google_Service_YouTube_VideoListResponse;

class YoutubeService extends AbstractYoutubeService
{
    /**
     * @param string $part
     * @param array $filter
     * @return Google_Service_YouTube_PlaylistListResponse
     */
    public function getPlaylists(string $part, array $filter): Google_Service_YouTube_PlaylistListResponse
    {
        $response = $this->getService()->playlists->listPlaylists($part, $filter);

        return $response;
    }

    /**
     * @param string $part
     * @param array $filter
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getPlaylistItems(string $part, array $filter): Google_Service_YouTube_PlaylistItemListResponse
    {
        $response = $this->getService()->playlistItems->listPlaylistItems($part, $filter);

        return $response;
    }

    /**
     * @param string $part
     * @param array $filter
     * @return Google_Service_YouTube_VideoListResponse
     */
    public function getVideoInfo(string $part, array $filter): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->getService()->videos->listVideos($part, $filter);

        return $response;
    }
}

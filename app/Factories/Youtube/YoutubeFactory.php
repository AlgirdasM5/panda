<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\Video;
use App\Services\Youtube\YoutubeService;
use Exception;
use Google_Service_YouTube_PlaylistItemListResponse;
use Google_Service_YouTube_PlaylistListResponse;
use Google_Service_YouTube_VideoListResponse;

class YoutubeFactory
{
    const MAX_RESULTS = 50;

    /**
     * @var YoutubeService
     */
    private $youtubeService;

    /**
     * @var ChannelFactory
     */
    private $channelFactory;

    /**
     * @var VideoFactory
     */
    private $videoFactory;

    /**
     * @var VideoHistoryFactory
     */
    private $videoHistoryFactory;

    /**
     * YoutubeFactory constructor.
     * @param YoutubeService $youtubeService
     * @param ChannelFactory $channelFactory
     * @param VideoFactory $videoFactory
     * @param VideoHistoryFactory $videoHistoryFactory
     */
    public function __construct(
        YoutubeService $youtubeService,
        ChannelFactory $channelFactory,
        VideoFactory $videoFactory,
        VideoHistoryFactory $videoHistoryFactory
    ) {
        $this->youtubeService = $youtubeService;
        $this->channelFactory = $channelFactory;
        $this->videoFactory = $videoFactory;
        $this->videoHistoryFactory = $videoHistoryFactory;
    }

    /**
     * @param array $ids
     * @throws Exception
     */
    public function scrapeVideosByChannels(array $ids)
    {
        foreach ($ids as $id) {
            $videoIds = $this->handleChannel($id);
            $videos = $this->getVideosByIds($videoIds);

            $this->handleVideos($videos, $id);
            $this->handleVideoHistory($videos);
        }
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    protected function handleChannel(string $id): array
    {
        $playlist = $this->getPlaylistItemsById(implode(',', $this->getPlaylistItems($id)));

        $this->channelFactory->setId($id);
        $this->channelFactory->setResponse($playlist);
        $this->channelFactory->create();

        $videoIds = $this->channelFactory->getVideoIds();

        return $videoIds;
    }

    /**
     * @param string $channelId
     * @return Video[]
     * @throws Exception
     */
    protected function getPlaylistItems(string $channelId): array
    {
        $list = [];

        $playlist = $this->getPlaylistByChannelId($channelId);

        foreach ($playlist->getItems() as $playlist) {
            $list[] = $playlist->getId();
        }

        return $list;
    }

    /**
     * @param Google_Service_YouTube_VideoListResponse $videos
     * @param string $channelId
     * @throws Exception
     */
    protected function handleVideos(Google_Service_YouTube_VideoListResponse $videos, string $channelId)
    {
        foreach ($videos->getItems() as $item) {
            $this->videoFactory->setChannelId($channelId);
            $this->videoFactory->setResponse($item);
            $this->videoFactory->create();
        }
    }

    /**
     * @param Google_Service_YouTube_VideoListResponse $videos
     * @throws Exception
     */
    protected function handleVideoHistory(Google_Service_YouTube_VideoListResponse $videos)
    {
        foreach ($videos->getItems() as $item) {
            $this->videoHistoryFactory->setResponse($item);
            $this->videoHistoryFactory->create();
        }
    }

    /**
     * @param string $id
     * @return Google_Service_YouTube_PlaylistListResponse
     */
    public function getPlaylistByChannelId(string $id): Google_Service_YouTube_PlaylistListResponse
    {
        $response = $this->youtubeService->getPlaylists(
            'id',
            ['channelId' => $id, 'maxResults' => self::MAX_RESULTS]
        );

        return $response;
    }

    /**
     * @param string $id
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getPlaylistItemsById(string $id): Google_Service_YouTube_PlaylistItemListResponse
    {
        $response = $this->youtubeService->getPlaylistItems(
            'snippet,contentDetails',
            ['playlistId' => $id, 'maxResults' => self::MAX_RESULTS]
        );

        return $response;
    }

    /**
     * @param array $videoIds
     * @return Google_Service_YouTube_VideoListResponse
     */
    public function getVideosByIds(array $videoIds): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->youtubeService->getVideoInfo(
            'snippet,statistics',
            ['id' => implode(',', $videoIds), 'maxResults' => self::MAX_RESULTS]
        );

        return $response;
    }
}

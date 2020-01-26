<?php

namespace App\Repositories\Youtube;

use App\Factories\Youtube\ChannelFactory;
use App\Factories\Youtube\VideoFactory;
use App\Factories\Youtube\VideoHistoryFactory;
use App\Models\Youtube\Channel;
use App\Models\Youtube\Video;
use App\Services\Youtube\YoutubeService;
use Exception;
use Google_Service_YouTube_PlaylistItemListResponse;
use Google_Service_YouTube_VideoListResponse;

class YoutubeRepository
{
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
     * YoutubeRepository constructor.
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
     * @param string $id
     * @throws Exception
     */
    public function scrapeVideosByChannel(string $id = Channel::TARGET_ID)
    {
        $channel = $this->getChannel($id);
        $videos = $this->getVideosByIds($channel->getVideoIds());
        $videoList = $this->getVideoList($videos);
        $historyList = $this->getVideoHistoryList($videos);
    }

    /**
     * @param string $id
     * @return Channel
     * @throws Exception
     */
    protected function getChannel(string $id): Channel
    {
        $playlist = $this->getPlaylistItemsById($id);

        $this->channelFactory->setId($id);
        $this->channelFactory->setResponse($playlist);

        $channel = $this->channelFactory->create();

        return $channel;
    }

    /**
     * @param Google_Service_YouTube_VideoListResponse $videos
     * @return Video[]
     * @throws Exception
     */
    protected function getVideoList(Google_Service_YouTube_VideoListResponse $videos): array
    {
        $list = [];

        foreach ($videos->getItems() as $item) {
            $this->videoFactory->setVideo($item);

            $list[] = $this->videoFactory->create();
        }

        return $list;
    }

    /**
     * @param Google_Service_YouTube_VideoListResponse $videos
     * @return Video[]
     * @throws Exception
     */
    protected function getVideoHistoryList(Google_Service_YouTube_VideoListResponse $videos): array
    {
        $list = [];

        foreach ($videos->getItems() as $item) {
            $this->videoHistoryFactory->setVideo($item);

            $list[] = $this->videoHistoryFactory->create();
        }

        return $list;
    }

    /**
     * @param string $id
     * @return Google_Service_YouTube_PlaylistItemListResponse
     */
    public function getPlaylistItemsById(string $id): Google_Service_YouTube_PlaylistItemListResponse
    {
        $response = $this->youtubeService->getPlaylistItems('snippet,contentDetails', ['playlistId' => $id]);

        return $response;
    }

    /**
     * @param array $ids
     * @return Google_Service_YouTube_VideoListResponse
     */
    public function getVideosByIds(array $ids): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->youtubeService->getVideoInfo('snippet,statistics', ['id' => implode(',', $ids)]);

        return $response;
    }
}

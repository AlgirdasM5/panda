<?php

namespace App\Repositories\Youtube;

use App\Factories\Youtube\ChannelFactory;
use App\Factories\Youtube\VideoFactory;
use App\Factories\Youtube\VideoHistoryFactory;
use App\Models\Youtube\Channel;
use App\Models\Youtube\Video;
use App\Models\Youtube\VideoHistory;
use App\Services\Youtube\YoutubeService;
use Exception;
use Google_Service_YouTube_PlaylistItemListResponse;
use Google_Service_YouTube_PlaylistListResponse;
use Google_Service_YouTube_VideoListResponse;
use Illuminate\Support\Facades\DB;

class YoutubeRepository
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
     * @param array $ids
     * @throws Exception
     */
    public function scrapeVideosByChannels(array $ids)
    {
        $channelList = [];
        $videoList = [];
        $historyList = [];

        foreach ($ids as $id) {
            $channel = $this->getChannel($id);
            $videos = $this->getVideosByIds($channel->getVideoIds());

            $channelList[] = $channel;
            $videoList = array_merge($videoList, $this->getVideoList($videos, $id));
            $historyList = array_merge($historyList, $this->getVideoHistoryList($videos));
        }

        $this->saveData($channelList, $videoList, $historyList);
    }

    /**
     * @param Channel[] $channelList
     * @param Video[] $videoList
     * @param VideoHistory[] $historyList
     */
    protected function saveData(array $channelList, array $videoList, array $historyList)
    {
        DB::table('channel')->insertOrIgnore(collect($channelList)->map(function ($channel) {
            /** @var Channel $channel */
            return [
                'id' => $channel->getId(),
            ];
        })->toArray());

        DB::table('video')->insertOrIgnore(collect($videoList)->map(function ($video) {
            /** @var Video $video */
            return [
                'id' => $video->getId(),
                'channel_id' => $video->getChannelId(),
                'title' => $video->getTitle(),
                'tags' => implode(',', $video->getTags()),
                'published_at' => $video->getPublishedAt(),
            ];
        })->toArray());

        DB::table('video_history')->insert(collect($historyList)->map(function ($history) {
            /** @var VideoHistory $history */
            return [
                'video_id' => $history->getVideoId(),
                'view_count' => $history->getViewCount(),
            ];
        })->toArray());
    }

    /**
     * @param string $id
     * @return Channel
     * @throws Exception
     */
    protected function getChannel(string $id): Channel
    {
        $playlist = $this->getPlaylistItemsById(implode(',', $this->getPlaylists($id)));

        $this->channelFactory->setId($id);
        $this->channelFactory->setResponse($playlist);

        $channel = $this->channelFactory->create();

        return $channel;
    }

    /**
     * @param string $channelId
     * @return Video[]
     * @throws Exception
     */
    protected function getPlaylists(string $channelId): array
    {
        $list = [];

        $playlists = $this->getPlaylistsByChannelId($channelId);

        foreach ($playlists->getItems() as $playlist) {
            $list[] = $playlist->getId();
        }

        return $list;
    }

    /**
     * @param Google_Service_YouTube_VideoListResponse $videos
     * @param string $channelId
     * @return Video[]
     * @throws Exception
     */
    protected function getVideoList(Google_Service_YouTube_VideoListResponse $videos, string $channelId): array
    {
        $list = [];

        foreach ($videos->getItems() as $item) {
            $this->videoFactory->setChannelId($channelId);
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
     * @return Google_Service_YouTube_PlaylistListResponse
     */
    public function getPlaylistsByChannelId(string $id): Google_Service_YouTube_PlaylistListResponse
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
     * @param array $ids
     * @return Google_Service_YouTube_VideoListResponse
     */
    public function getVideosByIds(array $ids): Google_Service_YouTube_VideoListResponse
    {
        $response = $this->youtubeService->getVideoInfo(
            'snippet,statistics',
            ['id' => implode(',', $ids), 'maxResults' => self::MAX_RESULTS]
        );

        return $response;
    }
}

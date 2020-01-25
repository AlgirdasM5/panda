<?php

namespace App\Repository;

use App\Models\Youtube\Channel;
use App\Service\Youtube\YoutubeService;
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
     * @param string $channel
     * @return string
     */
    public function getChannelInfo($channel = Channel::TARGET): string
    {
        $response = $this->youtubeService->getChannelInfo($channel);

        return $response;
    }
}

<?php

namespace App\Service\Youtube;

class YoutubeService extends AbstractYoutubeService
{
    /**
     * @param string $channel
     * @return string
     */
    public function getChannelInfo($channel): string
    {
        $response = $this->getService()->channels->listChannels($channel);

        return $response;
    }
}

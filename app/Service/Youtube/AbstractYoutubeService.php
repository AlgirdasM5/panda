<?php

namespace App\Service\Youtube;

use Google_Client;
use Google_Service_YouTube;

abstract class AbstractYoutubeService
{
    const APPLICATION_NAME = 'panda';

    /**
     * @var Google_Client
     */
    private $client;

    /**
     * @var Google_Service_YouTube
     */
    private $service;

    /**
     * @return Google_Client
     */
    private function getClient(): Google_Client
    {
        if (!$this->client) {
            $this->client = new Google_Client();
            $this->client->setApplicationName(self::APPLICATION_NAME);
            $this->client->setDeveloperKey(config('services.youtube.key'));
        }

        return $this->client;
    }

    /**
     * @return Google_Service_YouTube
     */
    protected function getService(): Google_Service_YouTube
    {
        if (!$this->service) {
            $this->service = new Google_Service_YouTube($this->getClient());
        }

        return $this->service;
    }
}

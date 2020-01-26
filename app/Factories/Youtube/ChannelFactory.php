<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\Channel;
use Carbon\Carbon;
use Google_Service_YouTube_PlaylistItem;
use Google_Service_YouTube_PlaylistItemListResponse;
use Exception;

class ChannelFactory
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var Google_Service_YouTube_PlaylistItemListResponse
     */
    protected $response;

    /**
     * @return Channel
     * @throws Exception
     */
    public function create(): Channel
    {
        $model = new Channel();
        $model->setId($this->id);
        $model->setCreatedAt(new Carbon());

        /** @var Google_Service_YouTube_PlaylistItem $item */
        foreach ($this->response->getItems() as $item) {
            $model->addVideoId($item->getContentDetails()->getVideoId());
        }

        return $model;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }
    /**
     * @param Google_Service_YouTube_PlaylistItemListResponse $response
     */
    public function setResponse(Google_Service_YouTube_PlaylistItemListResponse $response)
    {
        $this->response = $response;
    }
}

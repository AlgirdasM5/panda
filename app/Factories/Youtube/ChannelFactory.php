<?php

namespace App\Factories\Youtube;

use App\Models\Youtube\Channel;
use Google_Service_YouTube_PlaylistItem;
use Google_Service_YouTube_PlaylistItemListResponse;
use Exception;
use Illuminate\Support\Collection;

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
     * @var Channel
     */
    protected $model;

    /**
     * ChannelFactory constructor.
     * @param Channel $model
     */
    public function __construct(Channel $model)
    {
        $this->model = $model;
    }

    /**
     * @throws Exception
     */
    public function create()
    {
        $model = new Channel();

        $map = $this->map();

        $model->newQuery()->updateOrCreate([
            'id' => $this->id,
        ], $map->toArray());
    }

    /**
     * @return Collection
     */
    protected function map(): Collection
    {
        return collect([
            'id' => $this->id,
        ]);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getVideoIds(): array
    {
        $videoIds = [];

        /** @var Google_Service_YouTube_PlaylistItem $item */
        foreach ($this->response->getItems() as $item) {
            $videoIds[] = $item->getContentDetails()->getVideoId();
        }

        return $videoIds;
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

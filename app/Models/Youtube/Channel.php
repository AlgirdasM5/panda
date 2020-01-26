<?php

namespace App\Models\Youtube;

class Channel
{
    const TARGET_ID = 'UUpRmvjdu3ixew5ahydZ67uA';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $videoIds = [];

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getVideoIds(): array
    {
        return $this->videoIds;
    }

    /**
     * @param array $videoIds
     */
    public function setVideoIds(array $videoIds)
    {
        $this->videoIds = $videoIds;
    }

    /**
     * @param string $videoId
     */
    public function addVideoId(string $videoId)
    {
        $this->videoIds[] = $videoId;
    }
}

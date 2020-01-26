<?php

namespace App\Models\Youtube;

class VideoHistory
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $videoId;

    /**
     * @var integer
     */
    protected $viewCount;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getVideoId(): string
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     */
    public function setVideoId(string $videoId)
    {
        $this->videoId = $videoId;
    }

    /**
     * @return int
     */
    public function getViewCount(): int
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     */
    public function setViewCount(int $viewCount)
    {
        $this->viewCount = $viewCount;
    }
}

<?php

namespace App\Models\Youtube;

use Carbon\Carbon;

class Video
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $channelId;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * @var Carbon
     */
    protected $publishedAt;

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
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     */
    public function setChannelId(string $channelId)
    {
        $this->channelId = $channelId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return Carbon
     */
    public function getPublishedAt(): Carbon
    {
        return $this->publishedAt;
    }

    /**
     * @param Carbon $publishedAt
     */
    public function setPublishedAt(Carbon $publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }
}

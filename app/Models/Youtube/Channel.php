<?php

namespace App\Models\Youtube;

use JMS\Serializer\Annotation as JMS;

class Channel
{
    const TARGET = 'UCffUJFx_KxLu-MQdvBZkCCg';

    /**
     * @JMS\Type("integer")
     *
     * @var integer
     */
    protected $id;

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
}

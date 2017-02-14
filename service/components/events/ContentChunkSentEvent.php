<?php

namespace service\components\events;

use yii\base\Event;

/**
 * Event object for content chunk sent related events
 */
class ContentChunkSentEvent extends Event
{
    //Stream object
    public $stream;
    //Content (chunk of content)
    public $content;
    //Content chunk size
    public $bytes;
    //True if HTTP request is partial
    public $isPartial;
}

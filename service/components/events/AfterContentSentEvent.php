<?php

namespace service\components\events;

use yii\base\Event;

/**
 * Event object for after download\stream events
 */
class AfterContentSentEvent extends Event
{
    //Number of bytes sended to client
    public $bytes_sended;
    //Content provider id
    public $provider_id;
    //Content provider name
    public $provider_name;
    //Content link
    public $content_link;
    //Content name
    public $content_name;
    //Total content size
    public $content_size;
    //Client user id
    public $user_id;
}

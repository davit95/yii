<?php

namespace service\components\events;

use yii\base\Event;

/**
 * Event object for used credentials related events
 */
class CredentialUsedEvent extends Event
{
    //Content provider id
    public $content_provider_id;
    //Content provider name
    public $content_provider_name;
    //Credential id
    public $credential_id;
    //User id
    public $user_id;
    //Times credential was used
    public $times_used = 1;
}

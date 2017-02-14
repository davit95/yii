<?php

namespace service\components\behaviors;

use Yii;
use yii\base\Behavior;

/**
 * Allows to add debug messages
 *
 * @see service\controllers\DbgController
 */
class DebugBehavior extends Behavior
{
    private $debugMessages = [];

    /**
     * Returns array of debug messages
     *
     * @return array
     */
    public function getDebugMessages()
    {
        return $this->debugMessages;
    }

    /**
     * Adds new debug message
     *
     * @param string $label
     * @param string $message
     */
    public function addDebugMessage($label, $message)
    {
        $this->debugMessages[$label] = $message;
    }

}

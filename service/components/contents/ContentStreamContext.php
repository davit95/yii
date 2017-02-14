<?php

namespace service\components\contents;

use yii\base\Component;

abstract class ContentStreamContext extends Component
{
    protected $context;

    /**
     * Initializes new stream context
     *
     * @return @void
     */
    public function __construct()
    {
        $this->context = stream_context_create();
    }

    /**
     * Returns stream context
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->context;
    }

    /**
     * Returns stream context option
     *
     * @param string $wrapper
     * @param string $option
     * @return mixed|null
     */
    public function getOption($wrapper, $option)
    {
        $options = stream_context_get_options($this->getResource());

        return isset($options[$wrapper][$option]) ? $options[$wrapper][$option] : null;
    }

    /**
     * Sets stream context option
     *
     * @param string $wrapper
     * @param string $option
     * @param string $value
     * @return boolean
     */
    public function setOption($wrapper, $option, $value)
    {
        return stream_context_set_option($this->getResource(), $wrapper, $option, $value);
    }

    /**
     * Adds value to option. Does not overwrite current option value
     *
     * @param string $wrapper
     * @param string $option
     * @param boolean
     */
    public function addOption($wrapper, $option, $value)
    {
        $optVal = $this->getOption($wrapper, $option);

        if (!is_array($optVal) && $optVal !== null) {
            $optVal = [$optVal];
        }

        if ($optVal !== null) {
            $optVal[] = $value;
        } else {
            $optVal = $value;
        }

        $this->setOption($wrapper, $option, $optVal);
    }

    /**
     * Unsets stream context option
     *
     * @param string $wrapper
     * @param string $option
     */
    public function unsetOption($wrapper, $option)
    {
        $opts = stream_context_get_options($this->getResource());

        if (isset($opts[$wrapper][$option])) {
            unset($opts[$wrapper][$option]);
            return true;
        } else {
            return false;
        }
    }
}

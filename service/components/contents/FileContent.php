<?php

namespace service\components\contents;

class FileContent extends Content
{
    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context =  new FileContentStreamContext();
        return $context;
    }

    /**
     * @inheritdoc
     */
    public function createStream(ContentStreamContext $context = null, $mode = 'r+', $params = [])
    {
        if ($context === null) {
            $context = $this->createStreamContext();
        }
        return new FileContentStream($this->url, $context, $mode, $params);
    }

}

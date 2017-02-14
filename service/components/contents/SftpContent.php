<?php

namespace service\components\contents;

class SftpContent extends Content
{
    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context =  new SftpContentStreamContext();
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
        return new SftpContentStream($this->url, $context, $mode, $params);
    }

}

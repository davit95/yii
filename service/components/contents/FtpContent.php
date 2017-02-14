<?php

namespace service\components\contents;

class FtpContent extends Content
{
    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context = new FtpContentStreamContext();
        return $context;
    }

    /**
     * @inheritdoc
     */
    public function createStream(ContentStreamContext $context = null, $mode = 'r', $params = [])
    {
        if ($context === null) {
            $context = $this->createStreamContext();
        }
        if ($mode == 'w') {
            $context->setOption('ftp', 'overwrite', true);
        }
        return new FtpContentStream($this->url, $context, $mode, $params);
    }

}

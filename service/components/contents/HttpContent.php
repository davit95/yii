<?php

namespace service\components\contents;

class HttpContent extends ProviderContent
{
    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context =  new HttpContentStreamContext();
        $context->setOption('http', 'method', 'GET');
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
        return new HttpContentStream($this->url, $context, $mode, $params);
    }

}

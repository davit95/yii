<?php

use frontend\helpers\ContentHelper;

?>
<li>
    <img src="/images/arrow_up.jpg"/>
    <span class="tx-blue"><a href="<?= $unrestrainedLink->getInnerDownloadLink() ?>"><?= $unrestrainedLink->getShortenedContentName() ?></a></span>
    <span class="tx-blue right col-md-3 ta-right"><?= $unrestrainedLink->formattedContentSize ?></span>
</li>

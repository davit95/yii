<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\UnrestrainedLink;

/**
 * Handles link related CLI tasks
 */
class LinkController extends Controller
{
    /**
     * Removes unrestrained links which are older than [[$olderThan]] days
     *
     * @param integer $olderThan number of days
     * @return integer
     */
    public function actionRemoveExpiredLinks($olderThan = 3)
    {
        $expiration = time() - $olderThan * 24 * 60 * 60;

        UnrestrainedLink::deleteAll(['<=', 'created', $expiration]);

        return 0;
    }
}

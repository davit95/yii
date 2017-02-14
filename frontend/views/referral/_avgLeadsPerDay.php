<?php

use common\models\ReferralJournal;

$user = Yii::$app->user->identity;

if ($startDate == null || $endDate == null) {
    $daysInMonth = date('t', time());
    $startDate = strtotime(date('Y-m-01', time()));
    $endDate = strtotime(date('Y-m-'.$daysInMonth, time()));
}

if ($refLink instanceof common\models\ReferralLink) {
    $refLinkId = $refLink->id;
} else if (is_numeric($refLink)) {
    $refLinkId = $refLink;
} else {
    $refLinkId = null;
}

$avgLeadsPerDay = ReferralJournal::getAvgActionOccuranceByOwner($user, $startDate, $endDate, $refLinkId, 'buy_premium');

?>
<div class="left">Leads per day generated </div>
<div class="right"><?= $avgLeadsPerDay ?></div>

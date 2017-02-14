<?php

use common\models\ReferralLink;
use common\models\ReferralJournal;

$user = Yii::$app->user->identity;

if ($startDate == null || $endDate == null) {
    $daysInMonth = date('t', time());
    $startDate = strtotime(date('Y-m-01', time()));
    $endDate = strtotime(date('Y-m-'.$daysInMonth, time()));
}

if ($refLink instanceof ReferralLink) {
    $refLinkId = $refLink->id;
} else if (is_numeric($refLink)) {
    $refLinkId = $refLink;
} else {
    $refLinkId = null;
}

$stats = ReferralJournal::getActionOccurancePerDayByOwner($user, $startDate, $endDate, $refLinkId, null, true);

$labels = array();
$data = array();

foreach ($stats as $date => $value) {
    $labels[] = '""';
    $data[] = (int)$value;
}

?>
<canvas id="referral-chart"></canvas>
<script type="text/javascript">
    (function () {
        var cnvs = document.getElementById('referral-chart');
        if (typeof cnvs != 'undefined') {
            var data = {
                labels: [<?= implode(',', $labels) ?>],
                datasets: [
                    {
                        label: "Referral data",
                        fillColor: "rgba(28,84,161,1)",
                        strokeColor: "rgba(28,84,161,1)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
                        data: [<?= implode(',', $data) ?>]
                    },
                ],
            };
            var refChart = new Chart(cnvs.getContext('2d')).Bar(data,{showTooltips: false, responsive: true, scaleShowGridLines: false});
        }
    })();
</script>

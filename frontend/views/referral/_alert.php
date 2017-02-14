<?php

switch ($type) {
    case 'info':
        $class = 'alert-info';
        break;
    case 'success':
        $class = 'alert-success';
        break;
    case 'error':
        $class = 'alert-danger';
        break;
    default:
        $class = 'alert-info';
}

?>
<div class="alert <?= $class ?>">
    <?php
        if (is_array($message)) {
            foreach ($message as $messageText) {
                echo $messageText."\n";
            }
        } else {
            echo $message;
        }
    ?>
</div>

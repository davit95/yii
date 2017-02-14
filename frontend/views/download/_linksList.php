<?php

$links = (isset($links)) ? $links : [];

?>
<ul id="links-list" class="gray-list">
    <?php foreach ($links as $link): ?>
        <?php
            if (isset($pending) && $pending) {
                echo $this->render('_pendingLink', ['link' => $link, 'password' => $password]);
            }
        ?>
    <?php endforeach; ?>
    <?php
        if (isset($error) && $error) {
            echo $this->render('_linksListError', ['message' => $message]);
        }
    ?>
    <?php if (isset($pending) && $pending): ?>
        <script type="text/javascript">
            (function unrestrainLinks () {
                var links = $('#links-list > .pending-link');
                if (links.length) {
                    var link = links.first();
                    var data = {};
                    data.link = link.data('link');
                    if (typeof link.data('password') != 'undefined') {
                        data.password = link.data('password');
                    }
                    $.ajax({
                        url: '/download/unrestrain-link',
                        method: 'POST',
                        data: data,
                        success: function (resp) {
                            if (typeof resp != 'undefined') {
                                if (typeof resp.linkHtml != 'undefined') {
                                    link.replaceWith(resp.linkHtml);
                                    unrestrainLinks();
                                }
                                if (typeof resp.success != 'undefined') {
                                    if (!resp.success && typeof resp.linksListHtml != 'undefined') {
                                        $('#links-list').replaceWith(resp.linksListHtml);
                                    }
                                }
                            }
                        }
                    });
                }
            })();
        </script>
    <?php endif; ?>
</ul>

$(function() {
    /**
     * Earnings per day section filter
     */
    $(".datepicker").datepicker({dateFormat: "yy-mm-dd"});
    $('.earnings-per-day #apply-filter').on('click', function (e) {
        e.preventDefault();

        $('#earnings-filter-error-container').html('');

        var refLinkId = $('select[name="refLinkId"]').val();
        var startDate = $('input[name="startDate"]').val();
        var endDate = $('input[name="endDate"]').val();

        $.ajax({
            url: '/referral/render-earnings',
            method: 'GET',
            data: {
                'link': refLinkId,
                'startDate': startDate,
                'endDate': endDate
            },
            success: function (resp) {
                if (typeof resp != undefined) {
                    if (typeof resp.success != undefined) {
                        if (typeof resp.chartHtml != 'undefined') {
                            $('#referral-chart').parent().html(resp.chartHtml);
                        }
                        if (typeof resp.chartHtml != 'undefined') {
                            $('#avg-clicks-per-day-section').html(resp.avgClicksPerDayHtml);
                        }
                        if (typeof resp.chartHtml != 'undefined') {
                            $('#avg-leads-per-day-section').html(resp.avgLeadsPerDayHtml);
                        }
                        if (!resp.success) {
                            if (typeof resp.chartHtml != 'undefined') {
                                $('#earnings-filter-error-container').html(resp.errorHtml);
                            }
                        }
                    }
                }
            }
        });
    });

    /**
     * Per-page select change
     */
    $('select[name="per-page"]').on('change', function () {
        if (location.search.length && location.search.indexOf('per-page') == -1) {
            location.search += '&per-page=' + encodeURIComponent($(this).val());
        } else {
            location.search = '?per-page=' + encodeURIComponent($(this).val());
        }
    });

    /**
     * Download. Links list
     */
    $('#submit-links').on('click', function () {
        var links = $('textarea[name="links"]');
        var pass = $('input[name="password"]')
        if (links.length) {
            var data = {};
            data.links = links.val();
            if (pass.length && pass.val().trim() != '') {
                data.password = pass.val();
            }
            $.ajax({
                url: '/download/links-list',
                method: 'GET',
                data: data,
                success: function (resp) {
                    if (typeof resp != undefined) {
                        if (typeof resp.success != undefined) {
                            if (typeof resp.linksListHtml != undefined) {
                                $('#links-list').replaceWith(resp.linksListHtml);
                            }
                        }
                    }
                }
            });
        }
    });

    /**
     * Download. Clear links
     */
    $('#clear-links').on('click', function (e) {
        e.preventDefault();
        $('textarea[name="links"]').val('');
        $('#links-list').children().remove();
    });

    /**
     * My downloads delete unrestrained link
     */
    $('.js-delete-link').on('click', function (e) {
        e.preventDefault();

        var $this = $(this);
        var linkId = $this.data('id');

        if (typeof linkId != 'undefined') {
            $.ajax({
                url: '/my-downloads/delete-unrestrained-link',
                method: 'POST',
                data: {
                    'id': linkId
                },
                success: function (resp) {
                    if (typeof resp != undefined) {
                        if (typeof resp.success != undefined && resp.success) {
                            $this.parents('.cf').remove();
                        }
                    }
                }
            });
        }
    });
});

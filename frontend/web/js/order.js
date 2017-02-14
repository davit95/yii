$(document).ready(function () {
    //Render order form for given payment method
    $('.js-payment-method-select').on('change', function (e) {
        var url = $(this).val();

        var $form = $('.order-form');
        if ($form.length) {
            $form.remove();
        }

        if (typeof url != 'undefined' && url != '') {
            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: function () {
                    //Disable checkout button
                    $('.js-submit-order-form').attr('disabled', true).addClass('disabled');
                },
                success: function (resp) {
                    if (typeof resp != 'undefined') {
                        if (resp.success) {
                            if (typeof resp.form != 'undefined') {
                                $('.checkout-form-wrapper').append(resp.form);
                                //Enable checkout button
                                $('.js-submit-order-form').attr('disabled', false).removeClass('disabled');
                            }
                        }
                    }
                }
            });
        }
    });

    //Submit order form
    $('.js-submit-order-form').on('click', function (e) {
        var $form = $('.order-form');

        if ($form.length) {
            $form.submit();
        }
    });
});

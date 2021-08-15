(function ($)
{
    let csrf_token = $('meta[name="csrf-token"]').attr('content');
    let base_url = $('meta[name="base-url"]').attr('content');
    $.get_state_list = function get_state_list(callerElement, AffectedElement) {
        AffectedElement.empty();

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrf_token } });
        $.ajax({
            url: base_url + '/master/ajax/states',
            type: 'POST',
            data: {'country_id': callerElement.val() },
            dataType: 'json',
            success: function (res) {
                if (res.response === "success") {
                    let option = $($.parseHTML(`<option value="">Select State</option>`));
                    AffectedElement.append(option);
                    $.each(res.data, function (key, item){
                        let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                        AffectedElement.append($option);
                    });
                }
                else {
                    if (res.response === "validation_error") {
                        $.validation_errors(res);
                    }
                    else {
                        toast('error', res.message, 'top-right');
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.swal(textStatus, errorThrown, 'error');
            }
        });
    };

    $.get_city_list = function get_city_list(callerElement, AffectedElement)
    {
        AffectedElement.empty();
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrf_token } });
        $.ajax({
            url: base_url + '/master/ajax/cities',
            type: 'POST',
            data: {'state_id': callerElement.val() },
            dataType: 'json',
            success: function (res) {
                if (res.response === 'success') {
                    let option = $($.parseHTML(`<option value="">Select City</option>`));
                    AffectedElement.append(option);
                    $.each(res.data, function (key, item) {
                        let $option = $($.parseHTML(`<option value="${item.id}">${item.name}</option>`));
                        AffectedElement.append($option);
                    });

                }
                else {
                    if (res.response === "validation_error") {
                        $.validation_errors(res);
                    }
                    else {
                        toast('error', res.message, 'top-right');
                    }
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                $.swal(textStatus, errorThrown, 'error');
            }
        });
    };
})(jQuery);

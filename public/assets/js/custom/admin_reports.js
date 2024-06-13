var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function(){
    $(document).on('click', '#run', function(e){
        e.preventDefault();
        var formData = {};
        $('#reportsDetailForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        $.ajax({
            url: BASE_URL + '/' + $("#route").val() + '/report/' + $("#reportId").val() + '/run',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#run").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.from').text('');
                $('.to').text('');
                if(data.status == 500) {
                    if(data.messages.from) {
                        $('.from').text(data.messages.from);
                    }
                    if(data.messages.to) {
                        $('.to').text(data.messages.to);
                    }
                } else {
                    $('.reportTable').remove();
                    $('.dateForm').after(data.loans);
                }
            },
            complete: function () {
                $("#run").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });
});

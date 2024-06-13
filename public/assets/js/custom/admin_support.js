$(document).ready(function() {
    client_id = $('#client_id').val();
    $('.loan-client').hide();
    $('.loan-client-'+client_id).show();

    $("#message").focus();
});

$(document).on('change', '#client_id', function () {
    $('#loan_id').prop('selectedIndex',0);
    client_id = $(this).val();
    $('.loan-client').hide();
    $('.loan-client-'+client_id).show();
});

$(document).on('click', '#save-support, #send-message', function() {
    $('.loader').show();
});

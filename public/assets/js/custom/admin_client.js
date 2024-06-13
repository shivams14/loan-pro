var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function () {
    $('#js-payment-method-multiple').select2();
});

jQuery(document).on('change', '#member_country_name', function () {
    $.ajax({
        url: BASE_URL + '/admin/getState',
        type: "POST",
        datatype: 'json',
        data: {countryId: $(this).val(), _token: CSRF_TOKEN},
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (data) {
            $('#member_state_name').html(data);
        },
        complete: function () {
            $('.loader').fadeOut();
        },
    });
});

$(document).on("click", "#btn-open-family-member-modal", function () {
    var userId = $('#user_id').val();
    // $('#form_add_family_member')[0].reset();
    $(':input', '#form_add_family_member').not(':button, :submit, :reset').val('').removeAttr('checked').removeAttr('selected');
    $("#member_dob").datepicker("destroy");
    $("#member_celular").val('on');
    $('#member_state_name').html('<option value="">Select State</option>');
    $('#family_member_id').val(0);
    $('#user_id').val(userId);
    $('#memberModal').modal('show');

    // Create a new input element
    var newDobField = $("<input>").attr({ type: "text", id: "member_dob", readonly: true, name: 'member_dob', class: 'form-control', placeholder: 'yyyy-mm-dd' });

    // Replace the existing input element with the new one
    $("#member_dob").replaceWith(newDobField);

    $("#member_dob").datepicker({
        format: "yyyy-mm-dd",
        endDate: "today",
        autoclose: true // to close picker once date is selected
    });
});

$(window).click(function () {
    if($('#memberModal').hasClass('show')) {
        // 
    } else {
        $('.member_title_name').text('');
        $('.member_first_name').text('');
        $('.member_last_name').text('');
        $('.member_dob').text('');
        $('.member_email').text('');
        $('.member_phone_number').text('');
        $('.member_state_name').text('');
    }
});

$(document).on("click", "#btn-family-member-add", function (e) {
    e.preventDefault();
    var formData = {};
    $('#form_add_family_member').serializeArray().map(function (x) { formData[x.name] = x.value; });
    formData._token = CSRF_TOKEN;
    $.ajax({
        url: BASE_URL + '/admin/client/ajax-client-add-member',
        type: "POST",
        datatype: 'json',
        data: formData,
        beforeSend: function () {
            $("#btn-family-member-add").attr('disabled', 'disabled');
            // $('.spinner-border').show(); // this is not in use because its div is commented in client/form.blade.php
            $('.loader').show();
        },
        success: function (data) {
            $('.member_title_name').text('');
            $('.member_first_name').text('');
            $('.member_last_name').text('');
            $('.member_dob').text('');
            $('.member_email').text('');
            $('.member_phone_number').text('');
            $('.member_country_name').text('');
            $('.member_state_name').text('');
            if(data.status == 500) {
                if(data.messages.member_title_name) {
                    $('.member_title_name').text(data.messages.member_title_name);
                }
                if(data.messages.member_first_name) {
                    $('.member_first_name').text(data.messages.member_first_name);
                }
                if(data.messages.member_last_name) {
                    $('.member_last_name').text(data.messages.member_last_name);
                }
                if(data.messages.member_dob) {
                    $('.member_dob').text(data.messages.member_dob);
                }
                if(data.messages.member_email) {
                    $('.member_email').text(data.messages.member_email);
                }
                if(data.messages.member_phone_number) {
                    $('.member_phone_number').text(data.messages.member_phone_number);
                }
                if(data.messages.member_country_name) {
                    $('.member_country_name').text(data.messages.member_country_name);
                }
                if(data.messages.member_state_name) {
                    $('.member_state_name').text(data.messages.member_state_name);
                }
            } else {
                $.alert(data.message);
                $('#memberModal').modal('hide');
                setTimeout(function(){
                    location.reload()
                }, 3000);
            }
        },
        complete: function () {
            $("#btn-family-member-add").removeAttr('disabled');
            // $('.spinner-border').fadeOut();
            $('.loader').fadeOut();
        },
    });
});

function openFamilyEditModal(id)
{
    var jsonEncode = { _token: CSRF_TOKEN, "id": id };

    $.ajax({
        url: BASE_URL + '/admin/client/ajax-find-family-member',
        type: "POST",
        datatype: 'json',
        data: jsonEncode,
        beforeSend: function () {
            $('.loader').show();
        },
        success: function (data) {
            $('#form_add_family_member').html(data);
            $('#memberModal').modal('show');
            $("#member_dob").datepicker({
                format: "yyyy-mm-dd",
                endDate: "today",
                autoclose: true // to close picker once date is selected
            });
        },
        complete: function () {
            $('.loader').fadeOut();
        },
    });
}

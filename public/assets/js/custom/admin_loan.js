var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

/* Loan calculations */

function calculate() {
    // Extracting value in the amount
    // section in the variable
    const amount = $("#amount_financed").val();
    // Extracting value in the interest
    // rate section in the variable
    const rate = $("#interest_rate").val();
    // Extracting value in the months
    // section in the variable
    const duration = $("#duration").val();
    let term = $("#term").val();

    /* if(amount == '') {
        console.log('Amount financed empty!')
    }
    if(rate == '') {
        console.log('Interest rate empty!')
    }
    if(duration == '') {
        console.log('Duration empty!')
    }
    if(term == '') {
        console.log('term empty!')
    }

    return false; */

    if(term == 1){
        /* yearly calculate */
        term = 12;
    } else {
        /* monthly calculate */
        term = 1;
    }

    if(rate != '' && duration != '' && rate != 0 && duration != 0){
        const months = duration * term;

        // Calculating interest
        const interest = rate / 12 / 100;

        // Calculating interest per month
        const monthlyInterest = amount * interest;

        // Calculating total payment
        const monthlyPayment = monthlyInterest * (Math.pow(1 + interest, months)) / (Math.pow(1 + interest, months) - 1);

        $("#monthly_payment").val(monthlyPayment.toFixed(2));
    } else {
        $("#monthly_payment").val('');
    }
}

$(document).on('keyup', '#total_adjustments', function () {
    var sales_price = $('#sales_price').val();
    var down_payment = $('#down_payment').val();
    var amount_financed = sales_price - down_payment - $(this).val();
    $('#amount_financed').val(amount_financed.toFixed(2));
    calculate();
});

$(document).on('keyup', '#down_payment', function () {
    var sales_price = $('#sales_price').val();
    var total_adjustments = $('#total_adjustments').val();
    var amount_financed = sales_price - $(this).val() - total_adjustments;
    $('#amount_financed').val(amount_financed.toFixed(2));
    calculate();
});

$(document).on('keyup', '#sales_price', function () {
    var down_payment = $('#down_payment').val();
    var total_adjustments = $('#total_adjustments').val();
    var amount_financed = $(this).val() - down_payment - total_adjustments;
    $('#amount_financed').val(amount_financed.toFixed(2));
    calculate();
});

/* Escrow calculations */
$(document).on('keyup', '#escrow_insurance', function () {
    var escrow_city_taxes = parseFloat($('#escrow_city_taxes').val());
    var escrow_county_taxes = parseFloat($('#escrow_county_taxes').val());
    if(isNaN(escrow_city_taxes)) {
        escrow_city_taxes = 0.00;
    }
    if(isNaN(escrow_county_taxes)) {
        escrow_county_taxes = 0.00;
    }
    var escrow_payment_amount = parseFloat($(this).val()) + escrow_city_taxes + escrow_county_taxes;
    $('#escrow_payment_amount').val('');
    if(!isNaN(escrow_payment_amount)) {
        $('#escrow_payment_amount').val(escrow_payment_amount.toFixed(2));
    }
});

$(document).on('keyup', '#escrow_city_taxes', function () {
    var escrow_insurance = parseFloat($('#escrow_insurance').val());
    var escrow_county_taxes = parseFloat($('#escrow_county_taxes').val());
    if(isNaN(escrow_insurance)) {
        escrow_insurance = 0.00;
    }
    if(isNaN(escrow_county_taxes)) {
        escrow_county_taxes = 0.00;
    }
    var escrow_payment_amount = parseFloat($(this).val()) + escrow_insurance + escrow_county_taxes;
    $('#escrow_payment_amount').val('');
    if(!isNaN(escrow_payment_amount)) {
        $('#escrow_payment_amount').val(escrow_payment_amount.toFixed(2));
    }
});

$(document).on('keyup', '#escrow_county_taxes', function () {
    var escrow_insurance = parseFloat($('#escrow_insurance').val());
    var escrow_city_taxes = parseFloat($('#escrow_city_taxes').val());
    if(isNaN(escrow_insurance)) {
        escrow_insurance = 0.00;
    }
    if(isNaN(escrow_city_taxes)) {
        escrow_city_taxes = 0.00;
    }
    var escrow_payment_amount = parseFloat($(this).val()) + escrow_insurance + escrow_city_taxes;
    $('#escrow_payment_amount').val('');
    if(!isNaN(escrow_payment_amount)) {
        $('#escrow_payment_amount').val(escrow_payment_amount.toFixed(2));
    }
});


$('#late_fee_charge_type').change(function(){
    var val = $(this).val();
    if(val == 1) {
        $('.fixed-late-fee').show();
        $('.percentage-late-fee').hide();
    }/*  else if(val == 2) {
        $('.fixed-late-fee').hide();
        $('.percentage-late-fee').show();
    }  */else {
        $('.late_fee_amount').text('');
        $('#late_fee_amount').val('');
        $('.fixed-late-fee').hide();
        $('.percentage-late-fee').hide();
    }
});

$(document).ready(function(){
    // $("#loanForm")[0].reset();
    $('.second').hide();
    $('.third').hide();
    $('.fourth').hide();
    $('.fifth').hide();
    $('.sixth').hide();
    var selectedVal = $('#late_fee_charge_type').val();
    if(selectedVal == 1) {
        $('.fixed-late-fee').show();
        $('.percentage-late-fee').hide();
    }/*  else if(selectedVal == 2) {
        $('.fixed-late-fee').hide();
        $('.percentage-late-fee').show();
    } */ else {
        $('.late_fee_amount').text('');
        $('#late_fee_amount').val('');
        $('.fixed-late-fee').hide();
        $('.percentage-late-fee').hide();
    }

    /* Loan calculation on load */
    var sales_price = $('#sales_price').val();
    var down_payment = $('#down_payment').val();
    var total_adjustments = $('#total_adjustments').val();
    var amount_financed = sales_price - down_payment - total_adjustments;
    if(amount_financed != 0 && !isNaN(amount_financed)) {
        $('#amount_financed').val(amount_financed.toFixed(2));
    }

    /* Escrow calculation on load */
    var escrow_insurance = $('#escrow_insurance').val();
    var escrow_city_taxes = $('#escrow_city_taxes').val();
    var escrow_county_taxes = $('#escrow_county_taxes').val();
    var escrow_payment_amount = escrow_insurance + escrow_city_taxes + escrow_county_taxes;
    $('#escrow_payment_amount').val('');
    if(!isNaN(escrow_payment_amount)) {
        $('#escrow_payment_amount').val(Math.round(escrow_payment_amount).toFixed(2));
    }

    /* First Step */
    $(document).on('click', '#first', function(e){
        e.preventDefault();
        var formData = {};
        $('#loanForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/loan/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#first").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.loan_status').text('');
                $('.loan_type_id').text('');
                $('.inventory_id').text('');
                $('.client_id').text('');
                $('.loan_label').text('');
                if(data.status == 500) {
                    if(data.messages.loan_status) {
                        $('.loan_status').text(data.messages.loan_status);
                    }
                    if(data.messages.loan_type_id) {
                        $('.loan_type_id').text(data.messages.loan_type_id);
                    }
                    if(data.messages.inventory_id) {
                        $('.inventory_id').text(data.messages.inventory_id);
                    }
                    if(data.messages.client_id) {
                        $('.client_id').text(data.messages.client_id);
                    }
                    if(data.messages.loan_label) {
                        $('.loan_label').text(data.messages.loan_label);
                    }
                } else {
                    $.ajax({
                        url: BASE_URL + '/admin/inventory/getInventory/' + $('#inventory_id').val(),
                        type: "GET",
                        datatype: 'json',
                        beforeSend: function () {
                            // $("#first").attr('disabled', 'disabled');
                            // $('.loader').show();
                        },
                        success: function (data) {
                            let inventoryPrice = data.data.total_price;
                            if(data.status == 200) {
                                $('.first').hide();
                                $('.second').show();
                                $('#first_step').remove();
                                $('.second').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
                                $('.first-step').removeClass('active');
                                $('.second-step').addClass('active');

                                if(inventoryPrice !== '') {
                                    $('#sales_price').val(parseFloat(inventoryPrice).toFixed(2));
                                } else {
                                    $('#sales_price').val('');
                                    $('#sales_price').removeAttr('readonly');
                                }
                            }
                        },
                        complete: function () {
                            // $("#first").removeAttr('disabled');
                            // $('.loader').fadeOut();
                        },
                    });
                }
            },
            complete: function () {
                $("#first").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Second Step */
    $(document).on('click', '#second-back', function(e){
        e.preventDefault();
        $('.second').hide();
        $('.first').show();
        $('#second_step').remove();
        $('.first').prepend('<input type="hidden" name="current_step" value="1" id="first_step">');
        $('.second-step').removeClass('active');
        $('.first-step').addClass('active');
    });
    $(document).on('click', '#second', function(e){
        e.preventDefault();
        var formData = {};
        $('#loanForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/loan/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#second").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.closing_date').text('');
                $('.first_payment_date').text('');
                $('.days_untill_late').text('');
                $('.late_fee_application').text('');
                $('.late_fee_charge_type').text('');
                $('.late_fee_amount').text('');
                if(data.status == 500) {
                    if(data.messages.closing_date) {
                        $('.closing_date').text(data.messages.closing_date);
                    }
                    if(data.messages.first_payment_date) {
                        $('.first_payment_date').text(data.messages.first_payment_date);
                    }
                    if(data.messages.days_untill_late) {
                        $('.days_untill_late').text(data.messages.days_untill_late);
                    }
                    if(data.messages.late_fee_application) {
                        $('.late_fee_application').text(data.messages.late_fee_application);
                    }
                    if(data.messages.late_fee_charge_type) {
                        $('.late_fee_charge_type').text(data.messages.late_fee_charge_type);
                    }
                    if(data.messages.late_fee_amount) {
                        $('.late_fee_amount').text(data.messages.late_fee_amount);
                    }
                } else {
                    $('.second').hide();
                    $('.third').show();
                    $('#second_step').remove();
                    $('.third').prepend('<input type="hidden" name="current_step" value="3" id="third_step">');
                    $('.second-step').removeClass('active');
                    $('.third-step').addClass('active');
                }
            },
            complete: function () {
                $("#second").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Third Step */
    $(document).on('click', '#third-back', function(e){
        e.preventDefault();
        $('.third').hide();
        $('.second').show();
        $('#third_step').remove();
        $('.second').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
        $('.third-step').removeClass('active');
        $('.second-step').addClass('active');
    });
    $(document).on('click', '#third', function(e){
        e.preventDefault();
        var formData = {};
        $('#loanForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/loan/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#third").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.sales_price').text('');
                $('.down_payment').text('');
                $('.total_adjustments').text('');
                $('.amount_financed').text('');
                $('.interest_rate').text('');
                $('.interest_schedule').text('');
                $('.duration').text('');
                $('.term').text('');
                $('.monthly_payment').text('');
                $('.extra_payment_application').text('');
                if(data.status == 500) {
                    if(data.messages.sales_price) {
                        $('.sales_price').text(data.messages.sales_price);
                    }
                    if(data.messages.down_payment) {
                        $('.down_payment').text(data.messages.down_payment);
                    }
                    if(data.messages.total_adjustments) {
                        $('.total_adjustments').text(data.messages.total_adjustments);
                    }
                    if(data.messages.amount_financed) {
                        $('.amount_financed').text(data.messages.amount_financed);
                    }
                    if(data.messages.interest_rate) {
                        $('.interest_rate').text(data.messages.interest_rate);
                    }
                    if(data.messages.interest_schedule) {
                        $('.interest_schedule').text(data.messages.interest_schedule);
                    }
                    if(data.messages.duration) {
                        $('.duration').text(data.messages.duration);
                    }
                    if(data.messages.term) {
                        $('.term').text(data.messages.term);
                    }
                    if(data.messages.monthly_payment) {
                        $('.monthly_payment').text(data.messages.monthly_payment);
                    }
                    if(data.messages.extra_payment_application) {
                        $('.extra_payment_application').text(data.messages.extra_payment_application);
                    }
                } else {
                    $('.third').hide();
                    $('.fourth').show();
                    $('#third_step').remove();
                    $('.fourth').prepend('<input type="hidden" name="current_step" value="4" id="fourth_step">');
                    $('.third-step').removeClass('active');
                    $('.fourth-step').addClass('active');
                }
            },
            complete: function () {
                $("#third").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Fourth Step */
    $(document).on('click', '#fourth-back', function(e){
        e.preventDefault();
        $('.fourth').hide();
        $('.third').show();
        $('#fourth_step').remove();
        $('.third').prepend('<input type="hidden" name="current_step" value="3" id="third_step">');
        $('.fourth-step').removeClass('active');
        $('.third-step').addClass('active');
    });
    $(document).on('click', '#fourth', function(e){
        e.preventDefault();
        var formData = {};
        $('#loanForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/loan/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#fourth").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                if(data.status == 500) {
                    // Then will show the required fields if any. For now, there is no required fields as it has only one field.
                } else {
                    $('.fourth').hide();
                    $('.fifth').show();
                    $('#fourth_step').remove();
                    $('.fifth').prepend('<input type="hidden" name="current_step" value="5" id="fifth_step">');
                    $('.fourth-step').removeClass('active');
                    $('.fifth-step').addClass('active');
                }
            },
            complete: function () {
                $("#fourth").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Fifth Step */
    $(document).on('click', '#fifth-back', function(e){
        e.preventDefault();
        $('.fifth').hide();
        $('.fourth').show();
        $('#fifth_step').remove();
        $('.fourth').prepend('<input type="hidden" name="current_step" value="4" id="fourth_step">');
        $('.fifth-step').removeClass('active');
        $('.fourth-step').addClass('active');
    });
    $(document).on('click', '#fifth', function(e){
        e.preventDefault();
        var formData = {};
        $('#loanForm').serializeArray().map(function (x) { formData[x.name] = x.value; });

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/loan/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#fifth").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.escrow_first_month_payment_amount').text('');
                $('.escrow_insurance').text('');
                $('.escrow_city_taxes').text('');
                $('.escrow_county_taxes').text('');
                $('.escrow_payment_amount').text('');
                if(data.status == 500) {
                    if(data.messages.escrow_first_month_payment_amount) {
                        $('.escrow_first_month_payment_amount').text(data.messages.escrow_first_month_payment_amount);
                    }
                    if(data.messages.escrow_insurance) {
                        $('.escrow_insurance').text(data.messages.escrow_insurance);
                    }
                    if(data.messages.escrow_city_taxes) {
                        $('.escrow_city_taxes').text(data.messages.escrow_city_taxes);
                    }
                    if(data.messages.escrow_county_taxes) {
                        $('.escrow_county_taxes').text(data.messages.escrow_county_taxes);
                    }
                    if(data.messages.escrow_payment_amount) {
                        $('.escrow_payment_amount').text(data.messages.escrow_payment_amount);
                    }
                } else {
                    /* Adding the values in tables to show in review step */
                    var total_monthly_payment = parseFloat($("#monthly_payment").val());
                    var escrow_payment_amount = parseFloat($("#escrow_payment_amount").val());
                    var amount_financed = parseFloat($("#amount_financed").val());
                    var total_monthly_payment_escrow = total_monthly_payment + escrow_payment_amount;
                    var duration = parseInt($("#duration").val());
                    var term = parseInt($("#term").val());
                    if(term == 1) {
                        duration = duration * 12;
                    }
                    var escrow_first_month_payment_amount = parseFloat($("#escrow_first_month_payment_amount").val()) * duration;
                    var total_payment = total_monthly_payment_escrow * duration + escrow_first_month_payment_amount;
                    var total_interest = (total_monthly_payment * duration) - amount_financed;

                    $('#label').text($("#loan_label").val());
                    $('#type').text($("#loan_type_id option:selected").text());
                    $('#status').text($("#loan_status option:selected").text());
                    $('#inventory').text($("#inventory_id option:selected").text());
                    $('#client').text($("#client_id option:selected").text());
                    $('#comm').text($("#communication option:selected").text());

                    $('#sale-price').text('$' + Math.round($("#sales_price").val()).toFixed(2));
                    $('#down-payment').text('$' + Math.round($("#down_payment").val()).toFixed(2));
                    $('#adjustment').text('$' + Math.round($("#total_adjustments").val()).toFixed(2));
                    $('#loan-amount').text('$' + Math.round(amount_financed).toFixed(2));

                    $('#interest-rate').text(Math.round($("#interest_rate").val()).toFixed(2) + '%');
                    $('#interest-schedule').text($("#interest_schedule option:selected").text());
                    $('#monthly-payment').html('$' + Math.round(total_monthly_payment_escrow).toFixed(2) +'<br>(inc. Escrow Payment Amount)');
                    $('#total-payment').html('$' + Math.round(total_payment).toFixed(2) +'<br>(inc. Escrow Payment Amount)');
                    $('#total-interest').html('$' + Math.round(total_interest).toFixed(2));
                    $('#closing-date').text(moment($("#closing_date").val()).format('DD MMM, YYYY'));

                    $('#payment-date').text(moment($("#first_payment_date").val()).format('DD MMM, YYYY'));
                    $('#till-late').text($("#days_untill_late").val());
                    $('#fee-application').text($("#late_fee_application option:selected").text());
                    $('#charge-type').text($("#late_fee_charge_type option:selected").text());

                    $('#fee-fixed').text('$' + Math.round($("#late_fee_amount").val()).toFixed(2));
                    $('#first-month-payment-amount').text('$' + Math.round($("#escrow_first_month_payment_amount").val()).toFixed(2));
                    $('#escrow-payment-amount').text('$' + Math.round(escrow_payment_amount).toFixed(2));
                    $('#application-step').text($("#escrow_application_step option:selected").text());

                    /* Showing the review table */
                    $('.fifth').hide();
                    $('.sixth').show();
                    $('#fifth_step').remove();
                    $('.fifth-step').removeClass('active');
                    $('.sixth-step').addClass('active');
                }
            },
            complete: function () {
                $("#fifth").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Sixth Step */
    $(document).on('click', '#sixth-back', function(e){
        e.preventDefault();
        $('.sixth').hide();
        $('.fifth').show();
        $('.fifth').prepend('<input type="hidden" name="current_step" value="5" id="fifth_step">');
        $('.sixth-step').removeClass('active');
        $('.fifth-step').addClass('active');
    });
    $(document).on('click', '#sixth', function(e){
        e.preventDefault();
        $('#loanConfirmModal').modal('show');
        $("#btn-save-loan").click(function(){
            $("#btn-save-loan").attr('disabled', 'disabled');
            $('.loader').show();
            $("#loanForm").submit();
        });
    });

    /* Pay Loan Admin */
    $(window).click(function () {
        if($('#updateLoanEntryModal').hasClass('show')) {
            // 
        } else {
            $('.paid_date').text('');
            $('.received_amount').text('');
        }
    });
    $(document).on('click', '#pay-loan-admin', function(e){
        $("#paid_date").datepicker("destroy");

        $('#form-update-loan-entry')[0].reset();
        $('#updateLoanEntryModal').modal('show');
        $('#loan_entry_id').val($(this).attr('loan-entry-id'));
        $("#payment_amount").val($(this).attr('paymentAmount'));
        $("#received_amount").val($(this).attr('paymentAmount'));

        // Create a new input element
        var newPaymentDateField = $("<input>").attr({ type: "text", id: "paid_date", readonly: true, name: 'paid_date', class: 'form-control', placeholder: 'yyyy-mm-dd' });

        // Replace the existing input element with the new one
        $("#paid_date").replaceWith(newPaymentDateField);

        var paymentDate = new Date($(this).attr('paymentDate'));
        $("#paid_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: paymentDate,
            autoclose: true // to close picker once paid date is selected
        });
    });
    $(document).on('click', '#btn-update-loan-entry', function(e){
        e.preventDefault();
        var formData = {};
        $('#form-update-loan-entry').serializeArray().map(function (x) { formData[x.name] = x.value; });
        formData._token = CSRF_TOKEN;
        $.ajax({
            url: BASE_URL + '/admin/loanEntry/' + $('#loan_entry_id').val(),
            type: "PATCH",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#btn-update-loan-entry").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.paid_date').text('');
                $('.received_amount').text('');
                if(data.status == 500) {
                    if(data.message.paid_date) {
                        $('.paid_date').text(data.message.paid_date);
                    }
                    if(data.message.received_amount) {
                        $('.received_amount').text(data.message.received_amount);
                    }
                } else {
                    $.alert(data.message);
                    $('#updateLoanEntryModal').modal('hide');
                    setTimeout(function(){
                        location.reload()
                    }, 3000);
                }
            },
            complete: function () {
                $("#btn-update-loan-entry").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Complete the Loan */
    $(document).on('click', '#complete-loan', function(e){
        e.preventDefault();
        $('#completeLoanModal').modal('show');

        $("#btn-complete-loan").click(function(){
            $("#btn-complete-loan").attr('disabled', 'disabled');
            $('.loader').show();
            $("#complete-loan-form").submit();
        });
    });

    /* Pay Loan Customer */
    $(window).click(function () {
        if($('#performPaymentModal').hasClass('show')) {
            // 
        } else {
            $('.payment_date').text('');
            $('.total_amount').text('');
            $('.card_number').text('');
            $('.month').text('');
            $('.year').text('');
            $('.cvv').text('');
        }
    });
    $(document).on('click', '#pay-loan-customer', function(e){
        $('#form-perform-payment')[0].reset();
        $('#performPaymentModal').modal('show');
        $('#loan_entry_id').val($(this).attr('loan-entry-id'));
        $("#total_payment").val($(this).attr('paymentAmount'));
        $("#total_amount").val($(this).attr('paymentAmount'));
    });
    $(document).on('click', '#btn-perform-payment', function(e){
        e.preventDefault();
        var formData = {};
        $('#form-perform-payment').serializeArray().map(function (x) { formData[x.name] = x.value; });
        formData._token = CSRF_TOKEN;
        $.ajax({
            url: BASE_URL + '/customer/loan/' + $('#loan_id').val() + '/payment',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#btn-perform-payment").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.total_amount').text('');
                $('.card_number').text('');
                $('.month').text('');
                $('.year').text('');
                $('.cvv').text('');
                if(data.status == 500) {
                    if(data.message.total_amount) {
                        $('.total_amount').text(data.message.total_amount);
                    }
                    if(data.message.card_number) {
                        $('.card_number').text(data.message.card_number);
                    }
                    if(data.message.month) {
                        $('.month').text(data.message.month);
                    }
                    if(data.message.year) {
                        $('.year').text(data.message.year);
                    }
                    if(data.message.cvv) {
                        $('.cvv').text(data.message.cvv);
                    }
                } else {
                    $.alert(data.message);
                    $('#performPaymentModal').modal('hide');
                    setTimeout(function(){
                        location.reload()
                    }, 3000);
                }
            },
            complete: function () {
                $("#btn-perform-payment").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Update Escrow */
    $(window).click(function () {
        if($('#updateEscrowModal').hasClass('show')) {
            // 
        } else {
            $('.date').text('');
            $('.first_month_payment_amount').text('');
            $('.insurance').text('');
            $('.city_taxes').text('');
            $('.county_taxes').text('');
            $('.payment_amount').text('');
        }
    });
    $(document).on('click', '#update-escrow', function(e){
        $('#form-update-escrow')[0].reset();
        $('#updateEscrowModal').modal('show');
        var escrow_first_month_payment_amount = parseFloat($("#first_month_payment_amount").val());
        var escrow_insurance = parseFloat($("#escrow_insurance").val());
        var escrow_city_taxes = parseFloat($("#escrow_city_taxes").val());
        var escrow_county_taxes = parseFloat($("#escrow_county_taxes").val());
        var escrow_payment_amount = parseFloat($("#escrow_payment_amount").val());

        $("#first_month_payment_amount").val(escrow_first_month_payment_amount.toFixed(2));
        $("#escrow_insurance").val(escrow_insurance.toFixed(2));
        $("#escrow_city_taxes").val(escrow_city_taxes.toFixed(2));
        $("#escrow_county_taxes").val(escrow_county_taxes.toFixed(2));
        $("#escrow_payment_amount").val(escrow_payment_amount.toFixed(2));
    });
    $(document).on('click', '#btn-update-escrow', function(e){
        e.preventDefault();
        var formData = {};
        $('#form-update-escrow').serializeArray().map(function (x) { formData[x.name] = x.value; });
        formData._token = CSRF_TOKEN;
        $('.date').text('');
        $('.first_month_payment_amount').text('');
        $('.insurance').text('');
        $('.city_taxes').text('');
        $('.county_taxes').text('');
        $('.payment_amount').text('');
        $.ajax({
            url: BASE_URL + '/admin/loan/updateEscrow',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#btn-update-escrow").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                if(data.status == 500) {
                    if(data.message.date) {
                        $('.date').text(data.message.date);
                    }
                    if(data.message.first_month_payment_amount) {
                        $('.first_month_payment_amount').text(data.message.first_month_payment_amount);
                    }
                    if(data.message.insurance) {
                        $('.insurance').text(data.message.insurance);
                    }
                    if(data.message.city_taxes) {
                        $('.city_taxes').text(data.message.city_taxes);
                    }
                    if(data.message.county_taxes) {
                        $('.county_taxes').text(data.message.county_taxes);
                    }
                    if(data.message.payment_amount) {
                        $('.payment_amount').text(data.message.payment_amount);
                    }
                } else {
                    $.alert(data.message);
                    $('#updateEscrowModal').modal('hide');
                    setTimeout(function(){
                        location.reload()
                    }, 3000);
                }
            },
            complete: function () {
                $("#btn-update-escrow").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Pay Bank Loan */
    $(window).click(function () {
        if($('#bankLoanEntryModal').hasClass('show')) {
            // 
        } else {
            $('.payment_date_bank_loan').text('');
            $('.paid_amount').text('');
        }
    });
    $(document).on('click', '#pay-bank-loan', function(e){
        $("#payment_date").datepicker("destroy");

        $('#form-update-bank-loan-entry')[0].reset();
        $('#bankLoanEntryModal').modal('show');
        $('#bank_loan_entry_id').val($(this).attr('bank-loan-entry-id'));
        $("#paying_amount").val($(this).attr('paymentAmount'));
        $("#paid_amount").val($(this).attr('paymentAmount'));

        // Create a new input element
        var newPaymentDateField = $("<input>").attr({ type: "text", id: "payment_date", readonly: true, name: 'payment_date', class: 'form-control', placeholder: 'yyyy-mm-dd' });

        // Replace the existing input element with the new one
        $("#payment_date").replaceWith(newPaymentDateField);

        var paymentDate = new Date($(this).attr('paymentDate'));
        $("#payment_date").datepicker({
            format: "yyyy-mm-dd",
            startDate: paymentDate,
            autoclose: true // to close picker once paid date is selected
        });
    });
    $(document).on('click', '#btn-update-bank-loan-entry', function(e){
        e.preventDefault();
        var formData = {};
        $('#form-update-bank-loan-entry').serializeArray().map(function (x) { formData[x.name] = x.value; });
        formData._token = CSRF_TOKEN;
        $.ajax({
            url: BASE_URL + '/admin/bank-loan-entry-update/' + $('#bank_loan_entry_id').val(),
            type: "PATCH",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#btn-update-bank-loan-entry").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.payment_date_bank_loan').text('');
                $('.paid_amount').text('');
                if(data.status == 500) {
                    if(data.message.payment_date) {
                        $('.payment_date_bank_loan').text(data.message.payment_date);
                    }
                    if(data.message.paid_amount) {
                        $('.paid_amount').text(data.message.paid_amount);
                    }
                } else {
                    $.alert(data.message);
                    $('#bankLoanEntryModal').modal('hide');
                    setTimeout(function(){
                        location.reload()
                    }, 3000);
                }
            },
            complete: function () {
                $("#btn-update-bank-loan-entry").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });
});

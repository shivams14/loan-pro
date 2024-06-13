var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

$(document).ready(function() {
    var loanType = $('#loan_type').val();
    $('.select-inventory').hide();

    $(document).on('keyup', '#loan_amount', function () {
        var loanAmount = parseFloat($(this).val());
        var fees = parseFloat($('#fees').val());

        if(loanAmount != '' && fees != '') {
            var totalLoanAmount = loanAmount + fees;
            $('#total_loan_amount').val('');
            if(!isNaN(totalLoanAmount)) {
                $('#total_loan_amount').val(totalLoanAmount.toFixed(2));
            }
        }
    });
    $(document).on('keyup', '#fees', function () {
        var loanAmount = parseFloat($('#loan_amount').val());
        var fees = parseFloat($(this).val());

        if(loanAmount != '' && fees != '') {
            var totalLoanAmount = loanAmount + fees;
            $('#total_loan_amount').val('');
            if(!isNaN(totalLoanAmount)) {
                $('#total_loan_amount').val(totalLoanAmount.toFixed(2));
            }
        }
    });

    if(loanType == 1) {
        $('.select-inventory').show();
        $('#inventory_id').select2({ width: '879px' });
        $('.single-select-inventory').hide();
        $('.single-select-inventory').attr('name', 'inventory_id_hide');
        $('.multiple-select-inventory').show();
        $('.multiple-select-inventory').attr('name', 'inventory_id[]');
    } else if(loanType == 2) {
        $('.select-inventory').show();
        $('.multiple-select-inventory').hide();
        $('.multiple-select-inventory').attr('name', 'inventory_id_hide[]');
        $('.single-select-inventory').show();
        $('.single-select-inventory').attr('name', 'inventory_id');
    } else {
        $('.select-inventory').hide();
        $('.multiple-select-inventory').attr('name', 'inventory_id_hide[]');
    }
    $(document).on('change', '#loan_type', function() {
        var loanType = $(this).val();

        if(loanType == 1) {
            $('.select-inventory').show();
            $('#inventory_id').select2({ width: '879px' });
            $('.single-select-inventory').hide();
            $('.single-select-inventory').attr('name', 'inventory_id_hide');
            $('.multiple-select-inventory').show();
            $('.multiple-select-inventory').attr('name', 'inventory_id[]');
        } else if(loanType == 2) {
            $('.select-inventory').show();
            $('#inventory_id').select2('destroy');
            $('.multiple-select-inventory').hide();
            $('.multiple-select-inventory').attr('name', 'inventory_id_hide[]');
            $('.single-select-inventory').show();
            $('.single-select-inventory').attr('name', 'inventory_id');
        } else {
            $('.select-inventory').hide();
        }
    });

    $(document).on('click', '#save-bank-loan', function() {
        $('.loader').show();
    });
});
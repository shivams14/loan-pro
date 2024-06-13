$(document).ready(function(){
    $(document).on('keyup', '#insurance_charge_annually', function () {
        var chargeAnnually = parseFloat($('#insurance_charge_annually').val());
        var costAnnually = parseFloat($('#insurance_cost_annually').val());

        if(chargeAnnually > costAnnually) {
            var overageAnnual = chargeAnnually - costAnnually;
        }
        $('#insurance_overage_annual').val('');
        if(!isNaN(overageAnnual)) {
            $('#insurance_overage_annual').val(overageAnnual);
        }
    });

    $(document).on('keyup', '#insurance_cost_annually', function () {
        var chargeAnnually = parseFloat($('#insurance_charge_annually').val());
        var costAnnually = parseFloat($('#insurance_cost_annually').val());

        if(chargeAnnually > costAnnually) {
            var overageAnnual = chargeAnnually - costAnnually;
        }
        $('#insurance_overage_annual').val('');
        if(!isNaN(overageAnnual)) {
            $('#insurance_overage_annual').val(overageAnnual);
        }
    });
});
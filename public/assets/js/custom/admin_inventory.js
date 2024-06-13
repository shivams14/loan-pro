var CSRF_TOKEN = jQuery('meta[name="csrf-token"]').attr('content');

$(document).ready(function(){
    $('#parcel_number').tagsinput();
    $('#parcel_number_residential').tagsinput();
    $('.second-land').hide();
    $('.second-residential').hide();
    $('.second-capital').hide();
    $('.third').hide();
    var isOwnInventory = $('input[name=is_own_inventory]:checked').val();
    var investorId = $('#investor_id').val();
    $('.investor-name').hide();
    $('.investor-percentage').hide();
    if(typeof isOwnInventory === 'undefined') {
        $('.investor-name').show();
        if(investorId !== '') {
            $('.investor-percentage').show();
        }
    }

    var costOfDevelopment = $('input[name=cost_of_development]:checked').val();
    var total_acres_amount = parseInt($('#total_acres').val());
    var totalCost = parseFloat($('#total_cost').val());
    var perAcreCost = parseFloat($('#per_acre_cost').val());
    var price = parseFloat($('#price').val());

    $(document).on('change', '#is_own_inventory', function(){
        var isOwnInventory = $('input[name=is_own_inventory]:checked').val();
        var investorId = $('#investor_id').val();
        $('.investor-name').show();
        $('.investor-percentage').show();
        if(typeof isOwnInventory !== 'undefined') {
            $('.investor-name').hide();
            $('.investor-percentage').hide();
        } else {
            if(investorId === '') {
                $('.investor-percentage').hide();
            }
        }
    });

    $(document).on('change', '#investor_id', function(){
        var investorId = $(this).val();
        $('.investor-percentage').hide();
        if(investorId !== '') {
            $('.investor-percentage').show();
        }
    });

    $('#total_acres').val(total_acres_amount);
    $('#total_cost').val(totalCost.toFixed(2));
    $('#per_acre_cost').val(perAcreCost.toFixed(2));
    if(!isNaN(price)) {
        $('#price').val(price.toFixed(2));
    }
    if(costOfDevelopment == 1) {
        $('#total_cost').attr('readonly', true);
        if(total_acres_amount !== ''){
            $('#total_cost').removeAttr('readonly');
        }
        $('#per_acre_cost').attr('readonly', true);
    } else {
        $('#per_acre_cost').attr('readonly', true);
        if(total_acres_amount !== ''){
            $('#per_acre_cost').removeAttr('readonly');
        }
        $('#total_cost').attr('readonly', true);
    }
    $(document).on('keyup', '#total_cost', function () {
        var totalCost = $(this).val();
        var total_acres_amount = $('#total_acres').val();
        $('#per_acre_cost').val('');
        if(totalCost !== ''){
            var per_acre_cost = totalCost / total_acres_amount;
            $('#per_acre_cost').val(per_acre_cost.toFixed(2));
        }
        var originationFee = parseFloat($('#origination_fee_land').val());
        var closingFee = parseFloat($('#closing_fee_land').val());
        var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_land').val());
        if(totalCost != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
            const totalPrice = totalCost + originationFee + closingFee + endOfTermProRata;
            $('#total_price_land').val('');
            if(!isNaN(totalPrice)) {
                $('#total_price_land').val(totalPrice.toFixed(2));
            }
        }
    });
    $(document).on('keyup', '#per_acre_cost', function () {
        var perAcreCost = $('#per_acre_cost').val();
        var total_acres_amount = $('#total_acres').val();
        $('#total_cost').val('');
        if(perAcreCost !== ''){
            var total_cost = perAcreCost * total_acres_amount;
            $('#total_cost').val(total_cost.toFixed(2));
        }
        var total_cost = parseFloat($('#total_cost').val());
        var originationFee = parseFloat($('#origination_fee_land').val());
        var closingFee = parseFloat($('#closing_fee_land').val());
        var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_land').val());
        if(total_cost != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
            const totalPrice = total_cost + originationFee + closingFee + endOfTermProRata;
            $('#total_price_land').val('');
            if(!isNaN(totalPrice)) {
                $('#total_price_land').val(totalPrice.toFixed(2));
            }
        }
    });
    $(document).on('keyup', '#total_acres', function () {
        var costOfDevelopment = $('input[name=cost_of_development]:checked').val();
        var total_acres_amount = $('#total_acres').val();
        if(costOfDevelopment == 1) {
            $('#total_cost').attr('readonly', true);
            if(total_acres_amount !== ''){
                $('#total_cost').removeAttr('readonly');
                var totalCost = $('#total_cost').val();
                $('#per_acre_cost').val('');
                if(totalCost !== ''){
                    var per_acre_cost = totalCost / total_acres_amount;
                    $('#per_acre_cost').val(per_acre_cost.toFixed(2));
                }
            }
            $('#per_acre_cost').attr('readonly', true);
        } else {
            $('#per_acre_cost').attr('readonly', true);
            if(total_acres_amount !== ''){
                $('#per_acre_cost').removeAttr('readonly');
                var perAcreCost = $('#per_acre_cost').val();
                $('#total_cost').val('');
                if(perAcreCost !== ''){
                    var total_cost = perAcreCost * total_acres_amount;
                    $('#total_cost').val(total_cost.toFixed(2));
                }
            }
            $('#total_cost').attr('readonly', true);
        }
        var total_cost = parseFloat($('#total_cost').val());
        var originationFee = parseFloat($('#origination_fee_land').val());
        var closingFee = parseFloat($('#closing_fee_land').val());
        var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_land').val());
        if(total_cost != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
            const totalPrice = total_cost + originationFee + closingFee + endOfTermProRata;
            $('#total_price_land').val('');
            if(!isNaN(totalPrice)) {
                $('#total_price_land').val(totalPrice.toFixed(2));
            }
        }
    });

    $(document).on('keyup', '#price', function () {
        var price = parseFloat($(this).val());
        var originationFee = parseFloat($('#origination_fee_residential').val());
        var closingFee = parseFloat($('#closing_fee_residential').val());
        var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_residential').val());
        if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
            const totalPrice = price + originationFee + closingFee + endOfTermProRata;
            $('#total_price_residential').val('');
            if(!isNaN(totalPrice)) {
                $('#total_price_residential').val(totalPrice.toFixed(2));
            }
        }
    });
    $(document).on('keyup', '#origination_fee_residential, #origination_fee_land', function () {
        var price;
        var selectedCategory = $("#category_id").val();
        if(selectedCategory == 1) {
            price = parseFloat($('#total_cost').val());
            var originationFee = parseFloat($(this).val());
            var closingFee = parseFloat($('#closing_fee_land').val());
            var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_land').val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_land').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_land').val(totalPrice.toFixed(2));
                }
            }
        } else {
            price = parseFloat($('#price').val());
            var originationFee = parseFloat($(this).val());
            var closingFee = parseFloat($('#closing_fee_residential').val());
            var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_residential').val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_residential').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_residential').val(totalPrice.toFixed(2));
                }
            }
        }
    });
    $(document).on('keyup', '#closing_fee_residential, #closing_fee_land', function () {
        var price;
        var selectedCategory = $("#category_id").val();
        if(selectedCategory == 1) {
            price = parseFloat($('#total_cost').val());
            var originationFee = parseFloat($('#origination_fee_land').val());
            var closingFee = parseFloat($(this).val());
            var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_land').val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_land').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_land').val(totalPrice.toFixed(2));
                }
            }
        } else {
            price = parseFloat($('#price').val());
            var originationFee = parseFloat($('#origination_fee_residential').val());
            var closingFee = parseFloat($(this).val());
            var endOfTermProRata = parseFloat($('#end_of_term_pro_rata_residential').val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_residential').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_residential').val(totalPrice.toFixed(2));
                }
            }
        }
    });
    $(document).on('keyup', '#end_of_term_pro_rata_residential, #end_of_term_pro_rata_land', function () {
        var price;
        var selectedCategory = $("#category_id").val();
        if(selectedCategory == 1) {
            price = parseFloat($('#total_cost').val());
            var originationFee = parseFloat($('#origination_fee_land').val());
            var closingFee = parseFloat($('#closing_fee_land').val());
            var endOfTermProRata = parseFloat($(this).val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_land').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_land').val(totalPrice.toFixed(2));
                }
            }
        } else {
            price = parseFloat($('#price').val());
            var originationFee = parseFloat($('#origination_fee_residential').val());
            var closingFee = parseFloat($('#closing_fee_residential').val());
            var endOfTermProRata = parseFloat($(this).val());
            if(price != '' && originationFee != '' && closingFee != '' && endOfTermProRata != '') {
                const totalPrice = price + originationFee + closingFee + endOfTermProRata;
                $('#total_price_residential').val('');
                if(!isNaN(totalPrice)) {
                    $('#total_price_residential').val(totalPrice.toFixed(2));
                }
            }
        }
    });

    /* First Step */
    $(document).on('click', '#first', function(e){
        e.preventDefault();
        var formData = {};
        var updateForm = $('#update_form').val();
        if(typeof updateForm !== 'undefined' && updateForm !== '') {
            $('#updateInventoryForm').serializeArray().map(function (x) {
                if(x.name !== '_method') {
                    formData[x.name] = x.value;
                }
            });
        } else {
            $('#inventoryForm').serializeArray().map(function (x) { formData[x.name] = x.value; });
        }

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/inventory/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#first").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.category_id').text('');
                $('.inventory_type_id').text('');
                $('.status').text('');
                $('.investor_id').text('');
                $('.investor_percentage').text('');
                $('.ltv').text('');
                if(data.status == 500) {
                    if(data.messages.category_id) {
                        $('.category_id').text(data.messages.category_id);
                    }
                    if(data.messages.inventory_type_id) {
                        $('.inventory_type_id').text(data.messages.inventory_type_id);
                    }
                    if(data.messages.status) {
                        $('.status').text(data.messages.status);
                    }
                    if(data.messages.investor_id) {
                        $('.investor_id').text(data.messages.investor_id);
                    }
                    if(data.messages.investor_percentage) {
                        $('.investor_percentage').text(data.messages.investor_percentage);
                    }
                    if(data.messages.ltv) {
                        $('.ltv').text(data.messages.ltv);
                    }
                } else {
                    $('.first').hide();
                    var category = $('#category_id').val();
                    if(category == 1) {
                        $('.second-residential').hide();
                        $('.second-capital').hide();
                        $('.second-land').show();
                        $('.second-land').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
                    } else if(category == 2) {
                        $('.second-land').hide();
                        $('.second-capital').hide();
                        /* $('#origination_fee_residential').val('');
                        $('#closing_fee_residential').val('');
                        $('#end_of_term_pro_rata_residential').val('');
                        $('#total_price_residential').val(''); */
                        $('.second-residential').show();
                        $('.second-residential').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
                    } else {
                        $('.second-land').hide();
                        $('.second-residential').hide();
                        // $('#cap-name').val('');
                        $('.second-capital').show();
                        $('.second-capital').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
                    }
                    $('#first_step').remove();
                    $('.first-step').removeClass('active');
                    $('.second-step').addClass('active');
                }
            },
            complete: function () {
                $("#first").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    /* Second Step */
    $('input[name=cost_of_development]').change(function(){
        var costOfDevelopment = $('input[name=cost_of_development]:checked').val();
        var total_acres_amount = $('#total_acres').val();
        if(costOfDevelopment == 1) {
            $('#total_cost').attr('readonly', true);
            if(total_acres_amount !== ''){
                $('#total_cost').removeAttr('readonly');
            }
            $('#per_acre_cost').attr('readonly', true);
        } else {
            $('#per_acre_cost').attr('readonly', true);
            if(total_acres_amount !== ''){
                $('#per_acre_cost').removeAttr('readonly');
            }
            $('#total_cost').attr('readonly', true);
        }
    });
    $(document).on('click', '#second-back', function(e){
        e.preventDefault();
        $('.second-land').hide();
        $('.second-residential').hide();
        $('.second-capital').hide();
        $('.first').show();
        $('#second_step').remove();
        $('.first').prepend('<input type="hidden" name="current_step" value="1" id="first_step">');
        $('.second-step').removeClass('active');
        $('.first-step').addClass('active');

        $('.name').text('');
        $('.county').text('');
        $('.state_id').text('');
        $('.total_acres').text('');
        $('.total_cost').text('');
        $('.per_acre_cost').text('');
        $('.street').text('');
        $('.city').text('');
        $('.zipcode').text('');
        $('.price').text('');
    });
    $(document).on('click', '#second', function(e){
        e.preventDefault();
        var formData = {};
        var updateForm = $('#update_form').val();
        var category = $("#category_id option:selected").text();
        if(category == 'Land') {
            $('input[name=county]').val($("#county").val());
            $('input[name=parcel_number]').val($("#parcel_number").val());
            $('#cap-name').val($("#name").val());
            $('#origination_fee_residential').val($("#origination_fee_land").val());
            $('#closing_fee_residential').val($("#closing_fee_land").val());
            $('#end_of_term_pro_rata_residential').val($("#end_of_term_pro_rata_land").val());
            $('#total_price_residential').val($("#total_price_land").val());
        } else if(category == 'Residential') {
            $('input[name=county]').val($("#county_residential").val());
            $('input[name=parcel_number]').val($("#parcel_number_residential").val());
        } else {
            $('#name').val($("#cap-name").val());
        }
        if(typeof updateForm !== 'undefined' && updateForm !== '') {
            $('#updateInventoryForm').serializeArray().map(function (x) {
                if(x.name !== '_method') {
                    formData[x.name] = x.value;
                }
            });
        } else {
            $('#inventoryForm').serializeArray().map(function (x) { formData[x.name] = x.value; });
        }

        /* validations */
        $.ajax({
            url: BASE_URL + '/admin/inventory/validateFields',
            type: "POST",
            datatype: 'json',
            data: formData,
            beforeSend: function () {
                $("#second").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                $('.name').text('');
                $('.county').text('');
                $('.country_id').text('');
                $('.state_id').text('');
                $('.county_residential').text('');
                $('.country_residential').text('');
                $('.state_residential').text('');
                $('.total_acres').text('');
                $('.total_cost').text('');
                $('.per_acre_cost').text('');
                $('.street').text('');
                $('.city').text('');
                $('.zipcode').text('');
                $('.price').text('');
                $('.origination_fee').text('');
                $('.closing_fee').text('');
                $('.end_of_term_pro_rata').text('');
                $('.total_price').text('');
                if(data.status == 500) {
                    if(data.messages.name) {
                        $('.name').text(data.messages.name);
                    }
                    if(data.messages.county) {
                        $('.county').text(data.messages.county);
                    }
                    if(data.messages.country_id) {
                        $('.country_id').text(data.messages.country_id);
                    }
                    if(data.messages.state_id) {
                        $('.state_id').text(data.messages.state_id);
                    }
                    if(data.messages.county_residential) {
                        $('.county_residential').text(data.messages.county_residential);
                    }
                    if(data.messages.country_residential) {
                        $('.country_residential').text(data.messages.country_residential);
                    }
                    if(data.messages.state_residential) {
                        $('.state_residential').text(data.messages.state_residential);
                    }
                    if(data.messages.total_acres) {
                        $('.total_acres').text(data.messages.total_acres);
                    }
                    if(data.messages.total_cost) {
                        $('.total_cost').text(data.messages.total_cost);
                    }
                    if(data.messages.per_acre_cost) {
                        $('.per_acre_cost').text(data.messages.per_acre_cost);
                    }
                    if(data.messages.street) {
                        $('.street').text(data.messages.street);
                    }
                    if(data.messages.city) {
                        $('.city').text(data.messages.city);
                    }
                    if(data.messages.zipcode) {
                        $('.zipcode').text(data.messages.zipcode);
                    }
                    if(data.messages.price) {
                        $('.price').text(data.messages.price);
                    }
                    if(data.messages.origination_fee) {
                        $('.origination_fee').text(data.messages.origination_fee);
                    }
                    if(data.messages.closing_fee) {
                        $('.closing_fee').text(data.messages.closing_fee);
                    }
                    if(data.messages.end_of_term_pro_rata) {
                        $('.end_of_term_pro_rata').text(data.messages.end_of_term_pro_rata);
                    }
                    if(data.messages.total_price) {
                        $('.total_price').text(data.messages.total_price);
                    }
                } else {
                    var category = $("#category_id option:selected").text();
                    $('#category').text(category);
                    $('#type').text($("#inventory_type_id option:selected").text());
                    var ownInventory = $('input[name=is_own_inventory]:checked').val();
                    if(typeof ownInventory === 'undefined') {
                        $('#own-inv').text('No');
                        $('.investor').show();
                        $('#investor-name').text($("#investor_id option:selected").text());
                        $('#investor-per').text($('#investor_percentage').val() + '%');
                    } else {
                        $('#own-inv').text('Yes');
                        $('.investor').hide();
                    }
                    var ltv = $('#ltv').val();
                    if(ltv !== '') {
                        $('.ltv-per').show();
                        $('#ltv-per').text(ltv + '%');
                    } else {
                        $('.ltv-per').hide();
                    }
                    if(category == 'Land') {
                        $(".residential").hide();
                        $(".capital").hide();
                        $(".land").show();
                        $(".land-residential").show();
                        $('#inv-name').text($("#name").val());
                        $('#inv-county').text($("#county").val());
                        $('#inv-state').text($("#state_id option:selected").text());
                        $('#inv-status').text($("#status option:selected").text());
                        $('#parcel-numbers').text($("#parcel_number").val());
                        $('#total-acres').text($("#total_acres").val());
                        $('#total-cost').html('$' + $("#total_cost").val());
                        $('#per-acre-cost').html('$' + $("#per_acre_cost").val());
                        $('#origination-fee').html('$' + $("#origination_fee_land").val());
                        $('#closing-fee').html('$' + $("#closing_fee_land").val());
                        $('#pro-rata').html('$' + $("#end_of_term_pro_rata_land").val());
                        $('#total-price').html('$' + $("#total_price_land").val());
                    } else if(category == 'Residential') {
                        $(".land").hide();
                        $(".capital").hide();
                        $(".residential").show();
                        $(".land-residential").show();
                        $('#inv-name').text($("#street").val());
                        $('#inv-status-residential').text($("#status option:selected").text());
                        $('#inv-street-residential').text($("#street").val());
                        $('#inv-city-residential').text($("#city").val());
                        $('#inv-county-residential').text($("#county_residential").val());
                        $('#inv-state-residential').text($("#state_residential option:selected").text());
                        $('#inv-zipcode-residential').text($("#zipcode").val());
                        $('#parcel-numbers-residential').text($("#parcel_number_residential").val());
                        $('#inv-bedroom-residential').text($("#bedroom").val());
                        $('#inv-bathroom-residential').text($("#bathroom").val());
                        $('#square-footage-residential').text($("#square_footage").val());
                        $('#lot-type-residential').text($("#lot_area_type option:selected").text());
                        $('#inv-price-residential').html('$' + $("#price").val());
                        $('#origination-fee').html('$' + $("#origination_fee_residential").val());
                        $('#closing-fee').html('$' + $("#closing_fee_residential").val());
                        $('#pro-rata').html('$' + $("#end_of_term_pro_rata_residential").val());
                        $('#total-price').html('$' + $("#total_price_residential").val());
                    } else {
                        $(".residential").hide();
                        $(".land").hide();
                        $(".land-residential").hide();
                        $(".capital").show();
                        $('#inv-name').text($("#cap-name").val());
                        $('#inv-status-capital').text($("#status option:selected").text());
                    }
                    $('.second-land').hide();
                    $('.second-residential').hide();
                    $('.second-capital').hide();
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
        var category = $('#category_id').val();
        if(category == 1) {
            $('.second-residential').hide();
            $('.second-capital').hide();
            $('.second-land').show();
            $('.second-land').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
        } else if(category == 2) {
            $('.second-land').hide();
            $('.second-capital').hide();
            $('.second-residential').show();
            $('.second-residential').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
        } else {
            $('.second-land').hide();
            $('.second-residential').hide();
            $('.second-capital').show();
            $('.second-capital').prepend('<input type="hidden" name="current_step" value="2" id="second_step">');
        }
        $('#third_step').remove();
        $('.third-step').removeClass('active');
        $('.second-step').addClass('active');
    });
    $(document).on('click', '#third', function(e){
        e.preventDefault();
        var updateForm = $('#update_form').val();
        $("#third").attr('disabled', 'disabled');
        $('.loader').show();
        if(typeof updateForm !== 'undefined' && updateForm !== '') {
            $('#updateInventoryForm').submit();
        } else {
            $('#inventoryForm').submit();
        }
    });

    /* Verify Address */
    $(document).on('click', '#verify-address', function(e){
        e.preventDefault();
        $.ajax({
            url: BASE_URL + '/admin/inventory/verifyAddress',
            type: "POST",
            datatype: 'json',
            data: {id: $(this).attr('inventoryId'), _token: CSRF_TOKEN},
            beforeSend: function () {
                $("#verify-address").attr('disabled', 'disabled');
                $('.loader').show();
            },
            success: function (data) {
                location.reload();
            },
            complete: function () {
                $("#verify-address").removeAttr('disabled');
                $('.loader').fadeOut();
            },
        });
    });

    // Edit Note Modal
    $('.edit-note').on('click', function(e){
        e.preventDefault();
        var noteId = $(this).data('note-id');
        // Assuming you have a route to fetch note details based on noteId
        $.ajax({
            url: BASE_URL + '/admin/inventory/notes/' + noteId, // Replace with your route URL
            type: 'GET',
            success: function(response){
                $('#edit_inventory_note').val(response.note); // Populate the note in the modal
                $('#note_id').val(response.id); // Populate the note id in the modal
                $('#inventoryEditNoteModal').modal('show'); // Show the modal
            }
        });
    });

    var noteIdToDelete = null;

    // Open confirmation modal when delete button is clicked
    $('.delete-note').on('click', function(e){
        e.preventDefault();
        noteIdToDelete = $(this).data('note-id');
        $('#confirmationModal').modal('show');
    });

    // Handle note deletion when user confirms
    $('#confirmDelete').on('click', function(e){
        e.preventDefault();
        if (noteIdToDelete) {
            var csrfToken = CSRF_TOKEN;
            // Perform AJAX request to delete the note
            $.ajax({
                url:  BASE_URL +'/admin/inventory/ajax-inventory-delete-note/' + noteIdToDelete, // Update the URL based on your route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#confirmationModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                }
            });
        }
        // Close the confirmation modal
        $('#confirmationModal').modal('hide');
    });

    var fileIdToDelete = null;

    // Open confirmation modal when delete button is clicked
    $('.delete-file').on('click', function(e){
        e.preventDefault();
        fileIdToDelete = $(this).data('file-id');
        $('#fileconfirmationModal').modal('show');
    });

    // Handle file deletion when user confirms
    $('#confirmfileDelete').on('click', function(e){
        e.preventDefault();
        if (fileIdToDelete) {
            var csrfToken = CSRF_TOKEN;
            // Perform AJAX request to delete the note
            $.ajax({
                url:  BASE_URL +'/admin/inventory/ajax-inventory-delete-file/' + fileIdToDelete, // Update the URL based on your route
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#fileconfirmationModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                }
            });
        }
        // Close the confirmation modal
        $('#fileconfirmationModal').modal('hide');
    });

    // Show the add files modal when the button is clicked
    $('.btn-add-files').on('click', function(e) {
        e.preventDefault();
        $('#form-add-files')[0].reset();
        $('#file-validation-errors').text('');
        $('#addFilesModal').modal('show');
    });

    // Handle form submission for file upload
    $('#form-add-files').on('submit', function(event) {
        event.preventDefault();
        // Clear previous validation errors
        $('#file-validation-errors').text('');

        // Get the file title input element
        var fileTitle = $('#fileTitle').val();
        // Validate file title input
        if (fileTitle.length === 0) {
            $('#file-validation-errors').text('Please enter file title.');
            return;
        }
        // Get the file input element
        var fileInput = $('#file')[0];
        var files = fileInput.files;

        // Allowed file types
        var allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];

        // Validate file input
        if (files.length === 0) {
            $('#file-validation-errors').text('Please select at least one file.');
            return;
        }

        // Check file types
        for (var i = 0; i < files.length; i++) {
            if (allowedTypes.indexOf(files[i].type) === -1) {
                $('#file-validation-errors').text('Invalid file type. Please select PDF, PNG, or JPG files.');
                return;
            }
        }
        // Prepare form data for file upload using FormData
        var formData = new FormData(this);

        // Perform AJAX request for file upload
        $.ajax({
            url: BASE_URL +'/admin/inventory/ajax-inventory-add-file', // Specify the URL to handle file uploads
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                jQuery('.loader').show();
            },
            success: function (data) {
                if (data.status == 200) {
                    jQuery.alert(data.message);
                    $('#addFilesModal').modal('hide');
                    
                    setTimeout(function(){
                        location.reload()
                    }, 3000);
                } else {
                    alertMessage(data.message, 'danger');
                }
                jQuery('.loader').fadeOut();
            },
            error: function(xhr, status, error) {
                // Handle errors, e.g., display error messages
                console.error(xhr.responseText);
                // Display validation errors, if any
                $('#file-validation-errors').text(xhr.responseText);
            }
        });
    });

    jQuery(document).on('change', '#country_id', function () {
        $.ajax({
            url: BASE_URL + '/admin/getState',
            type: "POST",
            datatype: 'json',
            data: {countryId: jQuery(this).val(), _token: CSRF_TOKEN},
            beforeSend: function () {
                $('.loader').show();
            },
            success: function (data) {
                $('#state_id').html(data);
            },
            complete: function () {
                $('.loader').fadeOut();
            },
        });
    });

    jQuery(document).on('change', '#country_residential', function () {
        $.ajax({
            url: BASE_URL + '/admin/getState',
            type: "POST",
            datatype: 'json',
            data: {countryId: jQuery(this).val(), _token: CSRF_TOKEN},
            beforeSend: function () {
                $('.loader').show();
            },
            success: function (data) {
                $('#state_residential').html(data);
            },
            complete: function () {
                $('.loader').fadeOut();
            },
        });
    });

    jQuery(document).on("click", "#btn-open-add-inventory-note-modal", function (e) {
        e.preventDefault();
        jQuery('#form-add-inventory-note')[0].reset();
        jQuery('#inventoryNoteModal').modal('show');
    });

    jQuery(document).on("click", "#btn-add-inventory-note", function (e) {
        e.preventDefault();
        var dataEncode = {};
        var form_data = jQuery('#form-add-inventory-note').serializeArray().map(function (x) { dataEncode[x.name] = x.value; });
        if (dataEncode.inventory_note.trim() === '') {
            jQuery.alert({ title: 'Alert!', content: 'Please enter your note', });
        }
        else {
            dataEncode._token = CSRF_TOKEN;
            jQuery.ajax({
                url: BASE_URL + '/admin/inventory/ajax-inventory-add-note',
                type: "POST",
                datatype: 'json',
                data: dataEncode,
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#inventoryNoteModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                },
            });
        }
    });

    jQuery(document).on("click", "#btn-update-inventory-note", function (e) {
        e.preventDefault();
        var dataEncode = {};
        var form_data = jQuery('#form-update-inventory-note').serializeArray().map(function (x) { dataEncode[x.name] = x.value; });
        if (dataEncode.edit_inventory_note.trim() === '') {
            jQuery.alert({ title: 'Alert!', content: 'Please enter your note', });
        }
        else {
            dataEncode._token = CSRF_TOKEN;
    
            jQuery.ajax({
                url: BASE_URL + '/admin/inventory/ajax-inventory-update-note',
                type: "POST",
                datatype: 'json',
                data: dataEncode,
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#inventoryEditNoteModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                },
            });
        }
    });

    jQuery(document).on("click", "#btn-open-add-inventory-description-modal", function (e) {
        e.preventDefault();
        jQuery('#form-add-inventory-description')[0].reset();
        jQuery('#inventoryAddDescriptionModal').modal('show');
    });

    jQuery(document).on("click", "#btn-add-inventory-description", function (e) {
        e.preventDefault();
        var dataEncode = {};
        var form_data = jQuery('#form-add-inventory-description').serializeArray().map(function (x) { dataEncode[x.name] = x.value; });
        if (dataEncode.inventoryDescription.trim() === '') {
            jQuery.alert({ title: 'Alert!', content: 'Please enter inventory description', });
        } else {
            dataEncode._token = CSRF_TOKEN;
            jQuery.ajax({
                url: BASE_URL + '/admin/inventory/ajax-inventory-add-description',
                type: "POST",
                datatype: 'json',
                data: dataEncode,
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#inventoryAddDescriptionModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                },
            });
        }
    });

    jQuery(document).on("click", "#edit-description", function (e) {
        e.preventDefault();
        jQuery('#inventoryEditDescriptionModal').modal('show');
    });

    jQuery(document).on("click", "#btn-update-inventory-description", function (e) {
        e.preventDefault();
        var dataEncode = {};
        var form_data = jQuery('#form-update-inventory-description').serializeArray().map(function (x) { dataEncode[x.name] = x.value; });
        if (dataEncode.inventoryDescription.trim() === '') {
            jQuery.alert({ title: 'Alert!', content: 'Please enter inventory description', });
        } else {
            dataEncode._token = CSRF_TOKEN;
            jQuery.ajax({
                url: BASE_URL + '/admin/inventory/ajax-inventory-add-description',
                type: "POST",
                datatype: 'json',
                data: dataEncode,
                beforeSend: function () {
                    jQuery('.loader').show();
                },
                success: function (data) {
                    if (data.status == 200) {
                        jQuery.alert(data.message);
                        jQuery('#inventoryEditDescriptionModal').modal('hide');
                        
                        setTimeout(function(){
                            location.reload()
                        }, 3000);
                    } else {
                        alertMessage(data.message, 'danger');
                    }
                    jQuery('.loader').fadeOut();
                },
            });
        }
    });
});

<div class="row third" style="display: none;">
    <table id="#example1" class="table table-bordered">
        <tr>
            <td><strong>Name</strong></td>
            <td id="inv-name"></td>
            <td><strong>Category</strong></td>
            <td id="category"></td>
            <td><strong>Type</strong></td>
            <td id="type"></td>
        </tr>

        <!-- Land -->
        <tr class="land" style="display: none;">
            <td><strong>Status</strong></td>
            <td id="inv-status"></td>
            <td><strong>County</strong></td>
            <td id="inv-county"></td>
            <td><strong>State</strong></td>
            <td id="inv-state"></td>
        </tr>
        <tr class="land" style="display: none;">
            <td><strong>Parcel Numbers</strong></td>
            <td id="parcel-numbers"></td>
            <td><strong>Total Acres</strong></td>
            <td id="total-acres"></td>
            <td><strong>Total Dev Cost</strong></td>
            <td id="total-cost"></td>
        </tr>
        <tr class="land" style="display: none;">
            <td><strong>Per Acre Cost</strong></td>
            <td id="per-acre-cost"></td>
        </tr>

        <!-- Residential -->
        <tr class="residential" style="display: none;">
            <td><strong>Status</strong></td>
            <td id="inv-status-residential"></td>
            <td><strong>Street Address</strong></td>
            <td id="inv-street-residential"></td>
            <td><strong>City</strong></td>
            <td id="inv-city-residential"></td>
        </tr>
        <tr class="residential" style="display: none;">
            <td><strong>County</strong></td>
            <td id="inv-county-residential"></td>
            <td><strong>State</strong></td>
            <td id="inv-state-residential"></td>
            <td><strong>Zipcode</strong></td>
            <td id="inv-zipcode-residential"></td>                
        </tr>
        <tr class="residential" style="display: none;">
            <td><strong>Parcel Numbers</strong></td>
            <td id="parcel-numbers-residential"></td>
            <td><strong>Bedrooms</strong></td>
            <td id="inv-bedroom-residential"></td>
            <td><strong>Bathrooms</strong></td>
            <td id="inv-bathroom-residential"></td>
        </tr>
        <tr class="residential" style="display: none;">
            <td><strong>Square Footage</strong></td>
            <td id="square-footage-residential"></td>
            <td><strong>Lot Area</strong></td>
            <td id="lot-type-residential"></td>
            <td><strong>Price</strong></td>
            <td id="inv-price-residential"></td>
        </tr>

        <!-- Capital -->
        <tr class="capital" style="display: none;">
            <td><strong>Status</strong></td>
            <td id="inv-status-capital"></td>
        </tr>

        <tr>
            <td><strong>Own Inventory</strong></td>
            <td id="own-inv"></td>
            <td class="investor"><strong>Investor</strong></td>
            <td class="investor" id="investor-name"></td>
            <td class="investor" id="investor-invested"><strong>Investor Percentage</strong></td>
            <td class="investor" id="investor-per"></td>
        </tr>
        <tr class="land-residential" style="display: none;">
            <td><strong>Origination Fee</strong></td>
            <td id="origination-fee"></td>
            <td><strong>Closing Fee</strong></td>
            <td id="closing-fee"></td>
            <td><strong>End of Term Pro Rata</strong></td>
            <td id="pro-rata"></td>
        </tr>
        <tr class="land-residential" style="display: none;">
            <td><strong>Total Price</strong></td>
            <td colspan="100" id="total-price"></td>
        </tr>
        <tr class="ltv-per">
            <td><strong>LTV (Loan-to-Value)</strong></td>
            <td colspan="100" id="ltv-per"></td>
        </tr>
    </table>

    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
        <button type="button" class="btn btn-dark" id="third-back">Back</button>
        <button type="submit" class="btn btn-primary" id="third">Save</button>
    </div>
</div>
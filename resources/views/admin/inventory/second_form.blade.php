<!-- Land -->
<div class="row second-land second" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name', 'class' => 'form-control', 'id' => 'name')) !!}
            <div class="col-sm-8">
                <small class="text-danger name"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>County:</strong>
            {!! Form::text('county', null, array('placeholder' => 'County', 'class' => 'form-control', 'id' => 'county')) !!}
            <div class="col-sm-8">
                <small class="text-danger county"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Country:</strong>
            <select name="country_id" id="country_id" class="form-control">
                <option value="">Select Country</option>
                @if (!empty($countries))
                    @foreach ($countries as $item)
                        @php $selected = ''; @endphp
                        @if((isset($record->country_id) && $record->country_id == $item->id) || ($item->id == old('country_id')))
                            @php $selected = ' selected'; @endphp
                        @endif
                        <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <div class="col-sm-8">
                <small class="text-danger country_id"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>State:</strong>
            <select name="state_id" id="state_id" class="form-control">
                <option value="">Select State</option>
                @if (!empty($record) && !empty($states))
                    @foreach ($states as $item)
                        @php $selected = ''; @endphp
                        @if((isset($record->state_id) && $record->state_id == $item->id) || ($item->id == old('state_id')))
                            @php $selected = ' selected'; @endphp
                        @endif
                        <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <div class="col-sm-8">
                <small class="text-danger state_id"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Parcel Numbers:</strong>
            {!! Form::text('parcel_number', null, array('placeholder' => 'Parcel Number', 'class' => 'form-control', 'id' => 'parcel_number', 'data-role'=>"tagsinput")) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Total Acres:</strong>
            {!! Form::number('total_acres', null, array('placeholder' => 'Total Acres', 'class' => 'form-control', 'id' => 'total_acres')) !!}
            <div class="col-sm-8">
                <small class="text-danger total_acres"></small>
            </div>
        </div>
    </div>

    <span class="subheading">Cost of Development</span>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Total Cost:</strong>
            {!! Form::radio('cost_of_development', 1, array('class' => 'form-control', 'id' => 'cost_of_development')) !!}
            {!! Form::number('total_cost', null, array('placeholder' => 'Total Cost', 'class' => 'form-control', 'id' => 'total_cost')) !!}
            <div class="col-sm-8">
                <small class="text-danger total_cost"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Per Acre Cost:</strong>
            {!! Form::radio('cost_of_development', 2, array('class' => 'form-control', 'id' => 'cost_of_development')) !!}
            {!! Form::number('per_acre_cost', null, array('placeholder' => 'Per Acre Cost', 'class' => 'form-control', 'id' => 'per_acre_cost')) !!}
            <div class="col-sm-8">
                <small class="text-danger per_acre_cost"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Origination Fee:</strong>
            {!! Form::text('origination_fee', null, array('placeholder' => 'Origination Fee', 'class' => 'form-control', 'id' => 'origination_fee_land')) !!}
            <div class="col-sm-8">
                <small class="text-danger origination_fee"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Closing Fee:</strong>
            {!! Form::text('closing_fee', null, array('placeholder' => 'Closing Fee', 'class' => 'form-control', 'id' => 'closing_fee_land')) !!}
            <div class="col-sm-8">
                <small class="text-danger closing_fee"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>End of Term Pro Rata:</strong>
            {!! Form::text('end_of_term_pro_rata', null, array('placeholder' => 'End of Term Pro Rata', 'class' => 'form-control', 'id' => 'end_of_term_pro_rata_land')) !!}
            <div class="col-sm-8">
                <small class="text-danger end_of_term_pro_rata"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Total Price:</strong>
            {!! Form::text('total_price', null, array('placeholder' => 'Total Price', 'class' => 'form-control', 'id' => 'total_price_land', 'readonly' => true)) !!}
            <div class="col-sm-8">
                <small class="text-danger total_price"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
        <button type="submit" class="btn btn-dark" id="second-back">Back</button>
        <button type="submit" class="btn btn-primary" id="second">Next</button>
    </div>
</div>


<!-- Residential -->
<div class="row second-residential second" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Street Address:</strong>
            {!! Form::text('street', null, array('placeholder' => 'Street Address', 'class' => 'form-control', 'id' => 'street')) !!}
            <div class="col-sm-8">
                <small class="text-danger street"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>City:</strong>
            {!! Form::text('city', null, array('placeholder' => 'City', 'class' => 'form-control', 'id' => 'city')) !!}
            <div class="col-sm-8">
                <small class="text-danger city"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>County:</strong>
            {!! Form::text('county', null, array('placeholder' => 'County', 'class' => 'form-control', 'id' => 'county_residential')) !!}
            <div class="col-sm-8">
                <small class="text-danger county_residential"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">@if (!empty($states))
                    @foreach ($states as $item)
                        @php $selected = ''; @endphp
                        @if(isset($record->state_id) && $record->state_id == $item->id)
                            @php $selected = ' selected'; @endphp
                        @endif
                        <option style="display:none" class="state-country state-country-{{$item->country_id}}" value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                    @endforeach
                @endif
            <strong>Country:</strong>
            <select name="country_residential" id="country_residential" class="form-control">
                <option value="">Select Country</option>
                @if (!empty($countries))
                    @foreach ($countries as $item)
                        @php $selected = ''; @endphp
                        @if((isset($record->country_id) && $record->country_id == $item->id) || ($item->id == old('country_residential')))
                            @php $selected = ' selected'; @endphp
                        @endif
                        <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <div class="col-sm-8">
                <small class="text-danger country_residential"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>State:</strong>
            <select name="state_residential" id="state_residential" class="form-control">
                <option value="">Select State</option>
                @if (!empty($record) && !empty($states))
                    @foreach ($states as $item)
                        @php $selected = ''; @endphp
                        @if((isset($record->state_id) && $record->state_id == $item->id) || ($item->id == old('state_residential')))
                            @php $selected = ' selected'; @endphp
                        @endif
                        <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            <div class="col-sm-8">
                <small class="text-danger state_residential"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Zip Code:</strong>
            {!! Form::text('zipcode', null, array('placeholder' => 'Zip Code', 'class' => 'form-control', 'id' => 'zipcode')) !!}
            <div class="col-sm-8">
                <small class="text-danger zipcode"></small>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Parcel Numbers:</strong>
            {!! Form::text('parcel_number', null, array('placeholder' => 'Parcel Number', 'class' => 'form-control', 'id' => 'parcel_number_residential', 'data-role'=>"tagsinput")) !!}
        </div>
    </div>

    <span class="subheading">Property Details</span>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Bedroom:</strong>
            {!! Form::number('bedroom', null, array('placeholder' => 'Bedroom', 'class' => 'form-control', 'id' => 'bedroom')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Bathroom:</strong>
            {!! Form::number('bathroom', null, array('placeholder' => 'Bathroom', 'class' => 'form-control', 'id' => 'bathroom')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Square Footage:</strong>
            {!! Form::number('square_footage', null, array('placeholder' => 'Square Footage', 'class' => 'form-control', 'id' => 'square_footage')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong>Lot Area:</strong>
            {!! Form::number('lot_area', null, array('placeholder' => 'Lot Area', 'class' => 'form-control', 'id' => 'lot_area')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="form-group">
            <strong></strong>
            <strong></strong>
            <select name="lot_area_type" class="form-control" id="lot_area_type">
                <option @if((isset($record->lot_area_type) && $record->lot_area_type == 1) || (old('lot_area_type') == 1)) {{'selected'}} @else {{''}} @endif value="1">Acres</option>
                <option @if((isset($record->lot_area_type) && $record->lot_area_type == 2) || (old('lot_area_type') == 2)) {{'selected'}} @else {{''}} @endif value="2">Square Feet</option>
            </select>
        </div>
    </div>

    <span class="subheading">Pricing Details</span>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Price:</strong>
            {!! Form::text('price', null, array('placeholder' => 'Price', 'class' => 'form-control', 'id' => 'price')) !!}
            <div class="col-sm-8">
                <small class="text-danger price"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Origination Fee:</strong>
            {!! Form::text('origination_fee', null, array('placeholder' => 'Origination Fee', 'class' => 'form-control', 'id' => 'origination_fee_residential')) !!}
            <div class="col-sm-8">
                <small class="text-danger origination_fee"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Closing Fee:</strong>
            {!! Form::text('closing_fee', null, array('placeholder' => 'Closing Fee', 'class' => 'form-control', 'id' => 'closing_fee_residential')) !!}
            <div class="col-sm-8">
                <small class="text-danger closing_fee"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>End of Term Pro Rata:</strong>
            {!! Form::text('end_of_term_pro_rata', null, array('placeholder' => 'End of Term Pro Rata', 'class' => 'form-control', 'id' => 'end_of_term_pro_rata_residential')) !!}
            <div class="col-sm-8">
                <small class="text-danger end_of_term_pro_rata"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Total Price:</strong>
            {!! Form::text('total_price', null, array('placeholder' => 'Total Price', 'class' => 'form-control', 'id' => 'total_price_residential', 'readonly' => true)) !!}
            <div class="col-sm-8">
                <small class="text-danger total_price"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
        <button type="submit" class="btn btn-dark" id="second-back">Back</button>
        <button type="submit" class="btn btn-primary" id="second">Next</button>
    </div>
</div>


<!-- Capital -->
<div class="row second-capital second" style="display: none;">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name', 'class' => 'form-control', 'id' => 'cap-name')) !!}
            <div class="col-sm-8">
                <small class="text-danger name"></small>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
        <button type="submit" class="btn btn-dark" id="second-back">Back</button>
        <button type="submit" class="btn btn-primary" id="second">Next</button>
    </div>
</div>
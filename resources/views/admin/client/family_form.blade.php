<input type="hidden" value="{{$record->parent_id}}" name="user_id" id="user_id">
<input type="hidden" value="{{$record->id}}" id="family_member_id" name="family_member_id">

<div class="row">
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Title</label>
        <input type="text" class="form-control" name="member_title_name" id="member_title_name" value="{{$record->name}}" placeholder="Title">
        <div class="col-sm-8">
            <small class="text-danger member_title_name"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">First Name</label>
        <input type="text" class="form-control" name="member_first_name" id="member_first_name" value="{{$record->first_name}}" placeholder="First Name">
        <div class="col-sm-8">
            <small class="text-danger member_first_name"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Middle Name</label>
        <input type="text" class="form-control" name="member_middle_name" id="member_middle_name" value="{{$record->middle_name}}" placeholder="Middle Name">
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Last Name</label>
        <input type="text" class="form-control" name="member_last_name" id="member_last_name" value="{{$record->last_name}}" placeholder="Last Name">
        <div class="col-sm-8">
            <small class="text-danger member_last_name"></small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <label for="inputPassword4" class="form-label">Dob</label>
        <input type="text" class="form-control" name="member_dob" id="member_dob" value="{{$record->dob}}" placeholder="yyyy-mm-dd" readonly>
        <div class="col-sm-8">
            <small class="text-danger member_dob"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputEmail4" class="form-label">Email</label>
        <input type="email" class="form-control" name="member_email" id="member_email" value="{{$record->email}}" placeholder="Email">
        <div class="col-sm-8">
            <small class="text-danger member_email"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputAddress" class="form-label">Tax ID Number</label>
        <input type="text" class="form-control" name="member_tax_id_number" id="member_tax_id_number" value="{{$record->tax_id_number}}" placeholder="Tax ID Number">
    </div>
</div>
<h6 class="card-title">Phone Number</h6>
<div class="row">
    <div class="col-6">
        <label for="inputAddress" class="form-label">Phone number</label>
        <input type="text" class="form-control" name="member_phone_number" id="member_phone_number" value="{{$record->phone_number}}" placeholder="Phone Number">
        <div class="col-sm-8">
            <small class="text-danger member_phone_number"></small>
        </div>
    </div>
    <div class="col-6 form-check form-switch">
        <label for="inputAddress" class="form-label">Is Celular</label><br>
        <input class="form-check-input" type="checkbox" name="member_celular" id="member_celular" @if($record->is_cellular == 1) {{'checked'}} @endif>
    </div>
</div>
<h6 class="card-title">Address</h6>
<div class="row">
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Street</label>
        <input type="text" class="form-control" name="member_street_name" id="member_street_name" value="{{$record->street}}" placeholder="Street">
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">City</label>
        <input type="text" class="form-control" name="member_city_name" id="member_city_name" value="{{$record->city}}" placeholder="City">
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Country</label>
        <select name="member_country_name" id="member_country_name" class="form-control">
            <option value="">Select Country</option>
            @if (!empty($countries))
                @foreach ($countries as $item)
                    @php $selected = ''; @endphp
                    @if((isset($record->country_id) && $record->country_id == $item->id) || ($item->id == old('member_country_name')))
                        @php $selected = ' selected'; @endphp
                    @endif
                    <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                @endforeach
            @endif
        </select>
        <div class="col-sm-8">
            <small class="text-danger member_country_name"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">State</label>
        <select name="member_state_name" class="form-control" id="member_state_name">
            <option value="">Select State</option>
            @if (!empty($record) && !empty($states))
                @foreach ($states as $item)
                    @php $selected = ''; @endphp
                    @if((isset($record->state_id) && $record->state_id == $item->id) || ($item->id == old('member_state_name')))
                        @php $selected = ' selected'; @endphp
                    @endif
                    <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
                @endforeach
            @endif
        </select>
        <div class="col-sm-8">
            <small class="text-danger member_state_name"></small>
        </div>
    </div>
    <div class="col-6">
        <label for="inputNanme4" class="form-label">Zip Code</label>
        <input type="text" class="form-control" name="member_zip_code" id="member_zip_code" value="{{$record->zipcode}}" placeholder="Zip Code">
    </div>
</div>
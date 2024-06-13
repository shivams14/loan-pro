<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name: </strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
			@if($errors->first('name'))
                <div class="col-sm-8">
                    <small class="text-danger">
                        {{$errors->first('name')}}
                    </small>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Email: </strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
			@if($errors->first('email'))
                <div class="col-sm-8">
                    <small class="text-danger">
                        {{$errors->first('email')}}
                    </small>
                </div>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <strong>Type: </strong>
        <select name="client_type_id" class="form-control">
            @if (!empty($clientTypes))
                <option value="">Select Client Type</option>
                @foreach ($clientTypes as $item)
                    @php $selected = ''; @endphp
                    @if ((isset($record->client_type_id) && $record->client_type_id == $item->id) || ($item->id == old('client_type_id')))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{ $selected }} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif
        </select>
		@if($errors->first('client_type_id'))
			<div class="col-sm-8">
				<small class="text-danger">
					{{$errors->first('client_type_id')}}
				</small>
			</div>
		@endif
    </div>
</div>
<div class="row">
    <div class="form-group">
        <strong>Status: </strong>
        <select name="active_status" class="form-control">
            <option @if((isset($record->active_status) && $record->active_status == \App\Enums\Status::ENABLE)) {{'selected'}} @else {{''}} @endif value="1">Enable
            </option>
            <option @if((isset($record->active_status) && $record->active_status == \App\Enums\Status::DISABLE)) {{'selected'}} @else {{''}} @endif value="0">Disable
            </option>
        </select>
		@if($errors->first('active_status'))
			<div class="col-sm-8">
				<small class="text-danger">
					{{$errors->first('active_status')}}
				</small>
			</div>
		@endif
    </div>
</div>
<div class="row">
    <div class="form-group">
        <strong>Language: </strong>
        <select name="language" class="form-control">
            @if (!empty($languages))
                <option value="">Select Language</option>
                @foreach ($languages as $languageCode => $languageValue)
                    @php $selected = ''; @endphp
                    @if ((isset($record->language) && $record->language == $languageCode) || ($languageCode == old('language')))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{$selected}} value="{{$languageCode}}"> <x-flag-language-{{ $languageCode }} />
                        {{$languageValue}}</option>
                @endforeach
            @endif
        </select>
		@if($errors->first('language'))
			<div class="col-sm-8">
				<small class="text-danger">
					{{$errors->first('language')}}
				</small>
			</div>
		@endif
    </div>
</div>
<div class="row">
    <div class="form-group">
        <strong>Allowed Payment Method: </strong>
        <select name="allowed_payment_method[]" id="js-payment-method-multiple" multiple="multiple" class="form-control">
            @if (!empty($paymentMethods))
                @foreach ($paymentMethods as $item)
                    @php
                        $selected = '';
                        $allowedPaymentMethods = (isset($record->allowed_payment_method)) ? json_decode($record->allowed_payment_method) : [];
                    @endphp
                    @if (($allowedPaymentMethods !== null && is_array($allowedPaymentMethods) && in_array($item->id, $allowedPaymentMethods)) || (old('allowed_payment_method') !== null && is_array(old('allowed_payment_method')) && in_array($item->id, old('allowed_payment_method'))))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{$selected}} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif
        </select>
		@if($errors->first('allowed_payment_method'))
			<div class="col-sm-8">
				<small class="text-danger">
					{{$errors->first('allowed_payment_method')}}
				</small>
			</div>
		@endif
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>

{!! Form::close() !!}


@if(isset($record->id))

<hr>

<div class="row">
    <div class="form-group">
        <strong>Family Member: <button type="button" class="btn btn-primary" id="btn-open-family-member-modal">+Add</button>
    </div>
</div>

<div class="card family-members-list" style="margin-bottom: 10px !important;">
    <div class="card-header">
        Family Members
    </div>
    <div class="card-body">
        <table id="#example1" class="table table-bordered">
            <tr>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Email </th>
                <th width="150px;">Action</th>
            </tr>
            @php
                $delete = "client.destroy";
            @endphp
            @forelse($memberRecords as $key => $value)
                <tr>
                    <td>{{ $value->first_name }}</td>
                    <td>{{ $value->middle_name }}</td>
                    <td>{{ $value->last_name}}</td>
                    <td>{{ $value->email}}</td>
                    <td>
                        <a class="btn btn-primary" onClick="openFamilyEditModal('<?php echo $value->id; ?>')">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100" class="no-record-found" style="font-weight: 400;">No record found!</td>
                </tr>
            @endforelse
        </table>
    </div>
</div>


<div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Family Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <form id="form_add_family_member" method="POST">
                            <input type="hidden" value="{{$record->id}}" name="user_id" id="user_id">
                            <input type="hidden" value="0" id="family_member_id" name="family_member_id">

                            <div class="row">
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Title</label>
                                    <input type="text" class="form-control" name="member_title_name" id="member_title_name" placeholder="Title">
                                    <div class="col-sm-8">
                                        <small class="text-danger member_title_name"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="member_first_name" id="member_first_name" placeholder="First Name">
                                    <div class="col-sm-8">
                                        <small class="text-danger member_first_name"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" name="member_middle_name" id="member_middle_name" placeholder="Middle Name">
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="member_last_name" id="member_last_name" placeholder="Last Name">
                                    <div class="col-sm-8">
                                        <small class="text-danger member_last_name"></small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="inputPassword4" class="form-label">Dob</label>
                                    <input type="text" class="form-control" name="member_dob" id="member_dob" placeholder="yyyy-mm-dd" readonly>
                                    <div class="col-sm-8">
                                        <small class="text-danger member_dob"></small>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="member_email" id="member_email" placeholder="Email">
                                    <div class="col-sm-8">
                                        <small class="text-danger member_email"></small>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Tax ID Number</label>
                                    <input type="text" class="form-control" name="member_tax_id_number" id="member_tax_id_number" placeholder="Tax ID Number">
                                </div>
                            </div>
                            <h6 class="card-title">Phone Number</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Phone number</label>
                                    <input type="text" class="form-control" name="member_phone_number" id="member_phone_number" placeholder="Phone Number">
                                    <div class="col-sm-8">
                                        <small class="text-danger member_phone_number"></small>
                                    </div>
                                </div>
                                <div class="col-6 form-check form-switch">
                                    <label for="inputAddress" class="form-label">Is Celular</label><br>
                                    <input class="form-check-input" type="checkbox" name="member_celular" id="member_celular">
                                </div>
                            </div>
                            <h6 class="card-title">Address</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Street</label>
                                    <input type="text" class="form-control" name="member_street_name" id="member_street_name" placeholder="Street">
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">City</label>
                                    <input type="text" class="form-control" name="member_city_name" id="member_city_name" placeholder="City">
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Country</label>
                                    <select name="member_country_name" id="member_country_name" class="form-control">
                                        <option value="">Select Country</option>
                                        @if (!empty($countries))
                                            @foreach ($countries as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
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
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="col-sm-8">
                                        <small class="text-danger member_state_name"></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="inputNanme4" class="form-label">Zip Code</label>
                                    <input type="text" class="form-control" name="member_zip_code" id="member_zip_code" placeholder="Zip Code">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="btn-family-member-add" class="btn btn-primary">
                    <!-- <div class="spinner-border" role="status">
                        <span class="sr-only"></span>
                    </div> -->
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
@endif
@if($userType == 'admin')
<div class="row">
    <div class="form-group">
        <strong>Client: </strong>
        <select name="client_id" class="form-control" id="client_id">
            @if (!empty($clients))
                <option value="">Select Client</option>
                @foreach ($clients as $item)
                    @php $selected = ''; @endphp
                    @if ((isset($record->client_id) && $record->client_id == $item->id) || ($item->id == old('client_id')))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{ $selected }} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif
        </select>
		@if($errors->first('client_id'))
			<div class="col-sm-3">
				<small class="text-danger">
					{{$errors->first('client_id')}}
				</small>
			</div>
		@endif
    </div>
</div>
@else
    <input type="hidden" name="client_id" id="client_id" value="{{auth()->user()->id}}">
@endif

<input type="hidden" name="created_by" id="created_by" value="{{auth()->user()->id}}">
<div class="row">
    <div class="form-group">
        <strong>Loan:</strong>
        <select name="loan_id" id="loan_id" class="form-control">
            <option value="">Select Loan</option>
            @if (!empty($loans))
                @foreach ($loans as $item)
                    @php $selected = ''; @endphp
                    @if((isset($record->loan_id) && $record->loan_id == $item->id) || ($item->id == old('loan_id')))
                        @php $selected = ' selected'; @endphp
                    @endif
                    <option style="display:none" class="loan-client loan-client-{{$item->client_id}}" id="loan-client-{{$item->client_id}}" value="{{$item->id}}" {{$selected}}>{{$item->loan_label}}</option>
                @endforeach
            @endif
        </select>
        @if($errors->first('loan_id'))
			<div class="col-sm-3">
				<small class="text-danger">
					{{$errors->first('loan_id')}}
				</small>
			</div>
		@endif
    </div>
</div>

<div class="row">
    <div class="form-group">
        <strong>Issue Details:</strong>
        {!! Form::textarea('issue_details', null, array('placeholder' => 'Issue Details', 'class' => 'form-control', 'id' => 'issue_details')) !!}
        @if($errors->first('issue_details'))
			<div class="col-sm-3">
				<small class="text-danger">
					{{$errors->first('issue_details')}}
				</small>
			</div>
		@endif
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
    <button type="submit" class="btn btn-primary" id="save-support">Submit</button>
</div>
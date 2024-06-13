<option value="">Select State</option>
@if (!empty($states))
    @foreach ($states as $item)
        @php $selected = ''; @endphp
        @if(isset($record->state_id) && $record->state_id == $item->id)
            @php $selected = ' selected'; @endphp
        @endif
        <option value="{{$item->id}}" {{$selected}}>{{$item->name}}</option>
    @endforeach
@endif
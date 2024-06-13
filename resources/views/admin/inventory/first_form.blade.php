<div class="row first">
    <input type="hidden" name="current_step" value="{{\App\Enums\Steps::BASIC}}" id="first_step">
    <div class="form-group">
        <strong>Category:</strong>
        <select name="category_id" class="form-control" id="category_id">
            <option value="">Select Category</option>
            <!-- @if (!empty($categories))
                @foreach ($categories as $item)
                    @php $selected = ''; @endphp
                    @if (isset($record->category_id) && $record->category_id == $item->id)
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{$selected}} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif -->
            <option value="{{\App\Enums\Category::LAND}}" @if((isset($record->category_id) && $record->category_id == \App\Enums\Category::LAND) || (old('category_id') == \App\Enums\Category::LAND)) {{'selected'}} @else {{''}} @endif>Land</option>
            <option value="{{\App\Enums\Category::RESIDENTIAL}}" @if((isset($record->category_id) && $record->category_id == \App\Enums\Category::RESIDENTIAL) || (old('category_id') == \App\Enums\Category::RESIDENTIAL)) {{'selected'}} @else {{''}} @endif>Residential</option>
            <option value="{{\App\Enums\Category::CAPITAL}}" @if((isset($record->category_id) && $record->category_id == \App\Enums\Category::CAPITAL) || (old('category_id') == \App\Enums\Category::CAPITAL)) {{'selected'}} @else {{''}} @endif>Capital</option>
        </select>
        <div class="col-sm-8">
            <small class="text-danger category_id"></small>
        </div>
    </div>
    <div class="form-group">
        <strong>Type:</strong>
        <select name="inventory_type_id" class="form-control" id="inventory_type_id">
            @if (!empty($inventoryTypes))
                <option value="">Select Type</option>
                @foreach ($inventoryTypes as $item)
                    @php $selected = ''; @endphp
                    @if ((isset($record->inventory_type_id) && $record->inventory_type_id == $item->id) || ($item->id == old('inventory_type_id')))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{$selected}} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif
        </select>
        <div class="col-sm-8">
            <small class="text-danger inventory_type_id"></small>
        </div>
    </div>
    <div class="form-group">
        <strong>Status:</strong>
        <select name="status" class="form-control" id="status">
            <option value="">Select Status</option>
            <option @if((isset($record->status) && $record->status==\App\Enums\Status::IDEA) || (old('status') == \App\Enums\Status::IDEA)) {{'selected'}} @else {{''}} @endif value="{{\App\Enums\Status::IDEA}}">Idea</option>

            <option @if((isset($record->status) && $record->status==\App\Enums\Status::READY) || (old('status') == \App\Enums\Status::READY)) {{'selected'}} @else {{''}} @endif value="{{\App\Enums\Status::READY}}">Ready</option>

            <option @if((isset($record->status) && $record->status==\App\Enums\Status::INPROGRESS) || (old('status') == \App\Enums\Status::INPROGRESS)) {{'selected'}} @else {{''}} @endif value="{{\App\Enums\Status::INPROGRESS}}">In progress</option>

            <option @if((isset($record->status) && $record->status==\App\Enums\Status::COMPLETED) || (old('status') == \App\Enums\Status::COMPLETED)) {{'selected'}} @else {{''}} @endif value="{{\App\Enums\Status::COMPLETED}}">Completed</option>
        </select>
        <div class="col-sm-8">
            <small class="text-danger status"></small>
        </div>
    </div>
    <div class="form-group form-check form-switch">
        <strong>Own Inventory:</strong>
        <input class="form-check-input" type="checkbox" name="is_own_inventory" id="is_own_inventory" @if(isset($record->is_own_inventory) && $record->is_own_inventory == 1) {{'checked'}} @endif>
    </div>
    <div class="form-group investor-name" style="display: none;">
        <strong>Investor:</strong>
        <select name="investor_id" class="form-control" id="investor_id">
            <option value="">Select Investor</option>
            @if (!empty($investor))
                @foreach ($investor as $item)
                    @php $selected = ''; @endphp
                    @if ((isset($record->investor_id) && $record->investor_id == $item->id) || ($item->id == old('investor_id')))
                        @php $selected = ' selected '; @endphp
                    @endif
                    <option {{$selected}} value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
            @endif
        </select>
        <div class="col-sm-8">
            <small class="text-danger investor_id"></small>
        </div>
    </div>
    <div class="form-group investor-percentage" style="display: none;">
        <strong>Percentage:</strong>
        <div class="input-group has-validation">
            {!! Form::text('investor_percentage', null, array('placeholder' => 'Percentage', 'class' => 'form-control', 'id' => 'investor_percentage')) !!}
            <span class="input-group-text" id="inputGroupPrepend">%</span>
        </div>
        <div class="col-sm-8">
            <small class="text-danger investor_percentage"></small>
        </div>
    </div>
    <div class="form-group">
        <strong>LTV (Loan-to-Value):</strong>
        <div class="input-group has-validation">
            {!! Form::text('ltv', null, array('placeholder' => 'LTV', 'class' => 'form-control', 'id' => 'ltv')) !!}
            <span class="input-group-text" id="inputGroupPrepend">%</span>
        </div>
        <div class="col-sm-8">
            <small class="text-danger ltv"></small>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 mt-3 submit-action">
        <button type="submit" class="btn btn-primary" id="first">Next</button>
    </div>
</div>
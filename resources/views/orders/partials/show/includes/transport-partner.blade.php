<div class="col-sm-6">
    <div class="form-group">
        <label for="">{{ trans('all.transport') }}</label>
        <select class="form-control list-transport" disabled="disabled">
            <option>ID {{$transport_partner->id}} - {{$transport_partner->number}} {{$transport_partner->drivers ? $transport_partner->drivers->first()->name : ''}}</option>
        </select>
    </div>
</div>
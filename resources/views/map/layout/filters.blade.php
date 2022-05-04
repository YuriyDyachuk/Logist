<form action="" method="GET">
    <div class="filters_block">
        Order : <input type="text" name="order_id" class="form-control" value="{{ $input['order_id'] ? $input['order_id'] : "" }}">
        Transport number : <input type="text" name="transport_number" class="form-control" value="{{ $input['transport_number'] ? $input['transport_number'] : "" }}">
        <input type="submit" value="Show" class="btn btn-success form-control">
    </div>
</form>
<!-- Modal -->
<div style="display: @if(!$user->tutorial) block @else none @endif" class="modal tutorial" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content transition">
            <div class="modal-header">
                <h4 class="modal-title" style="margin-bottom: 15px">{{trans('all.settings_fill')}}</h4>
            </div>
            <div class="modal-body">
                <p>{{trans('all.settings_fill_text')}}</p>
            </div>
            <div class="modal-footer">
                <button class=" btn btn-success" onclick="location.href='{{route('user.setting', ['tutorial' => 1])}}';" >{{trans('all.settings_fill_text_now')}}</button>
                <a class=" btn btn-danger" href="{{route('orders')}}">{{trans('all.settings_fill_text_later')}}</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

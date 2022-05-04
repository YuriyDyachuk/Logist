@push('scripts')
@if($transports->count() == 0)
    <script>
        $(function() {
            $('.tutorial').modal('show');
        });

    </script>
@endif
@endpush

<!-- Modal -->
<div class="modal tutorial" role="dialog">
    <div class="modal-dialog animated zoomIn" role="document">
        <div class="modal-content transition">
            <div class="modal-header">
                {{--<h4 class="modal-title" style="margin-bottom: 15px">Добавление транспорта</h4>--}}
            </div>
            <div class="modal-body">
                <div class="text-center tutorial_image">
                    <img src="/img/icon/tutorial-truck.svg" class="img-responsive">
                </div>
                <div class="text-center tutorial_title">{{ trans('all.transport') }}</div>
                <div class="text-center">
                    {{ trans('all.add_transport_first') }}
                </div>
            </div>
            <div class="modal-footer">
                @if(\App\Services\SubscriptionService::checkAutoLimit())
                <a class=" btn button-style1" href="{{ route('transport.create') }}">{{ trans('all.add_transport') }}</a>
                @else
                    <button type="button" class="btn button-block transition" disabled><span>{{ trans('all.add_transport') }}</span></button>
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="alert-box">
{{--    @if(Session::has('msg-default'))
        <div class="alert alert-default"><a href="#" class="close" data-dismiss="alert"
                                            aria-label="close">&times;</a>{{Session::get('msg-default')}}</div>@endif

    @if(Session::has('msg-primary'))
        <div class="alert alert-info"><a href="#" class="close" data-dismiss="alert"
                                         aria-label="close">&times;</a>{{Session::get('msg-primary')}}</div>@endif--}}

    {{--@if(Session::has('msg-success'))--}}
        {{--<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert"--}}
        {{--aria-label="close">&times;</a>{{Session::get('msg-success')}}</div>--}}
    {{--@endif--}}

    {{--@if(Session::has('msg-info'))--}}
        {{--<div class="alert alert-info"><a href="#" class="close" data-dismiss="alert"--}}
                                         {{--aria-label="close">&times;</a>{{Session::get('msg-info')}}</div>@endif--}}

{{--    @if(Session::has('msg-warning'))
        <div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert"
                                            aria-label="close">&times;</a>{{Session::get('msg-warning')}}</div>@endif

    @if(Session::has('msg-danger'))
        <div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert"
                                           aria-label="close">&times;</a>{{Session::get('msg-danger')}}</div>@endif--}}

    @if(Session::has('msg-popup'))
        <div class="modal fade" id="popup" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>{{Session::get('msg-popup')}}</p>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <script>
            $(document).ready(function () {
                $('#popup').modal('show');
            });
        </script>
    @endif
</div>

<div class="modal fade" id="alert" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@push('scripts')
    <script>
        $.notifyDefaults({
                             placement: {
                                 from: "bottom",
                                 align: "right"
                             },
                             animate:{
                                 enter: "animated fadeInUp",
                                 exit: "animated fadeOutDown"
                             },
                         });

        @if(\Session::has('msg-info'))
            $.notify({message: '{{\Session::get('msg-info')}}.'}, {type: 'info'});
        @endif

        @if(\Session::has('msg-primary'))
            $.notify({message: '{{\Session::get('msg-primary')}}.'}, {type: 'primary'});
        @endif

        @if(\Session::has('msg-default'))
            $.notify({message: '{{\Session::get('msg-default')}}.'}, {type: 'default'});
        @endif

        @if(\Session::has('msg-success'))
            $.notify({message: '{{\Session::get('msg-success')}}.'}, {type: 'success'});
        @endif

        @if(\Session::has('msg-warning'))
            $.notify({message: '{{\Session::get('msg-warning')}}.'}, {type: 'warning'});
        @endif

        @if(\Session::has('msg-danger'))
            $.notify({message: '{{\Session::get('msg-danger')}}.'}, {type: 'danger'});
        @endif
    </script>
@endpush
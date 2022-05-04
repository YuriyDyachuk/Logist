@if(auth()->user()->isClient() && $order->isCompleted())
<div id="testimonial_order" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">
                    {{ trans('all.completed_order') }}
                </div>
            </div>
            <div class="modal-body">
                <form id="completedOrderForm">
                    <div class="form-group">
                        <label for="rating" class="control-label col-sm-4">{{trans('all.rating')}}</label>
                        <div class="col-sm-8">
                            <input type="hidden" name="rating" value="0" autocomplete="off">
                            <ul class="testimonail">
                                <li data-value='1'>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                </li>
                                <li data-value='2'>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                </li>
                                <li data-value='3'>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                </li>
                                <li data-value='4'>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                </li>
                                <li data-value='5'>
                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment" class="control-label col-sm-4">{{trans('all.testimonial')}}</label>
                        <div class="col-sm-8">
                            <textarea name="comment" class="form-control"  rows="3" autocomplete="off"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default transition" data-dismiss="modal">{{ trans('all.cancel') }}
                    <i>×</i>
                </button>
                <button type="submit" class="btn button-green xs" data-action-order="testimonial-{{ $order->id }}" id="btn_complete" value="submit"><span>{{ trans('all.save') }}</span></button>
            </div>

        </div>
    </div>
</div>


@push('scripts')
<script defer>
    $(function() {

        @if($order->testimonial->isEmpty())
        var modal_id = '#testimonial_order';

            $(modal_id).modal('show');

            $('.testimonail li').on('mouseover', function(){
                var onStar = parseInt($(this).data('value'), 10);

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li').each(function(e){
                    if (e < onStar) {
                        $(this).children('span').addClass('checked');
                    }
                    else {
                        $(this).children('span').removeClass('checked');
                    }
                });

            }).on('mouseout', function(){
                $(this).parent().children('li').children('span').each(function(e){
                    $(this).removeClass('checked');
                });
            });

            $('.testimonail li').on('click', function(){
    //            console.log('click 214');
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                var stars = $(this).parent().children('li');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                var ratingValue = parseInt($('.testimonail li.selected').last().data('value'), 10);
                $(modal_id).find('input[name=rating]').val(ratingValue);
            });
        @endif
    });
</script>
@endpush


@endif
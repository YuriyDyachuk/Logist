<div role="tabpanel" class="tab-pane fade transition testimonail" id="testimonial">
        <div class="row">
            <div class="col-sm-4">
                <h3 class="text-center">{{ trans('all.testimonials') }}</h3>
            </div>
            <div class="col-sm-4 testimonail-rating">
                <p>{{ trans('all.rating') }}:</p>
                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 1) checked @endif" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 2) checked @endif" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 3) checked @endif" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 4) checked @endif" aria-hidden="true"></span>
                <span class="glyphicon glyphicon-star @if($testimonials_rating >= 5) checked @endif" aria-hidden="true"></span>
            </div>
        </div>
        <div class="row" id="testimonial_wrapper">
            @include('profile.partials.testimonial-comments')
        </div>
</div>

@push('scripts')
<script>
    $(function() {

        $('#testimonial_wrapper').on('click', '.page-item a',function (e) {
            e.preventDefault();
            var url = $(e.target).attr('href');

            $.get(url)
                .done(function (data) {
                    if (data.status === 'ok') {
                        $('#testimonial_wrapper').html(data.html);
                    }
                })
                .fail(function (data) {
                    console.log(data);
                })
                .always(function () {

                });
        });
    })
</script>
@endpush
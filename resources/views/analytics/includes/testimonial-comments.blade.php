@forelse ($testimonials as $testimonial)
    <div class="col-sm-12">
        <div class="testimonail_single">
            <div class="testimonail_single__name">{{ $testimonial->driver->name }} [{{ Carbon\Carbon::parse($testimonial->created_at)->format('d/m/Y') }}]</div>
            <div class="testimonail_single__content">{{ $testimonial->comment }}</div>
        </div>
    </div>
    <!-- Pagination -->
    <div class="col-sm-12 testimonials-pagination">
        {{--{{ $testimonials->appends( ['action' => 'testimonials'])->links() }}--}}
        {{ $testimonials->appends( ['action' =>'testimonials', 'filters' => $filters])->fragment( 'testimonials' )->links() }}
    </div>
@empty
    <p class="text-center" style="margin-top: 20px">{{ trans('all.no_data_view') }}</p>
@endforelse
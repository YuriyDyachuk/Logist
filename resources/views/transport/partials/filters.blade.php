{{--<div class="content-box__body">--}}
<div class="content-box__body-tabs">
    <ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">
        <li role="presentation" class="transition active" >
            <a href="#transport" app-filter="auto" class="ajaxTab"><span>{{trans('all.automobiles')}}</span> </a>
        </li>

        <li role="presentation" class="transition">
            <a href="#trailers" app-filter="trailer" class="ajaxTab"><span>{{trans('all.trailers')}}</span></a>
        </li>
    </ul>
</div>
{{--</div>--}}


{{--<div class="content-box__filter page-order-filter-nav">--}}
    {{--<div class="row">--}}
        {{--<div class="content-box__body-tabs col-xs-12">--}}
            {{--<!-- Tab navigation: BEGIN -->--}}
            {{--<ul class="nav nav-tabs tablist transition" role="tablist" id="rowTab">--}}
                {{--<li role="presentation" class="transition active" >--}}
                    {{--<a href="#transport" app-filter="auto" class="ajaxTab"><span>{{trans('all.automobiles')}}</span> </a>--}}
                {{--</li>--}}

                {{--<li role="presentation" class="transition">--}}
                    {{--<a href="#trailers" app-filter="trailer" class="ajaxTab"><span>{{trans('all.trailers')}}</span></a>--}}
                {{--</li>--}}
            {{--</ul>--}}
            {{--<!-- Tab navigation: END -->--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="clearfix"></div>--}}
{{--</div>--}}

<div class="content-box__filters">
    <form id="formFilters" class="clearfix">
        <input type="hidden" name="filters[type]" id="filterType">
        {{--<div class="row">--}}
            {{--<div class="col-sm-3">--}}
                {{--<div class="filter-category">--}}
                    {{--<label for="" class="h5 title-grey">{{trans('all.show')}}:</label>--}}
                    {{--<select id="ownerFilter" name="filters[owner]" class="selectpicker">--}}
                        {{--<option value="1" selected>{{trans('all.transport_own')}}</option>--}}
                        {{--<option value="0" >{{trans('all.transport_partner')}}</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--TODO after release--}}
            {{--<div class="col-sm-3">--}}
                {{--<div class="filter-category">--}}
                    {{--<label for="" class="h5 title-grey">{{ trans('all.transport') }}:</label>--}}
                    {{--<select id="category" name="filters[category]" class="selectpicker" data-live-search="true" >--}}
                        {{--@foreach($category as $item)--}}
                            {{--@if($item->id != 1)--}}
                            {{--<option value="{{ $item->id }}">{{ trans('handbook.'.$item->name) }}</option>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col-sm-3">--}}
                <div class="content-box__filter-rollingStock content-box__filter">
                    <label for="" class="label-filter">{{trans('all.type')}}</label>
                    <select id="rollingStockFilter" name="filters[rollingStock]"
                            class="form-control selectpicker" data-live-search="true" data-size="7" data-cancel="{{trans('all.all')}}">
                        <option value="" selected>{{trans('all.all')}}</option>
                    </select>
                </div>
            {{--</div>--}}

        <div id="clearForm" class="clear-form">
            <a href="{{ route('transport.index') }}" class="btn btn-filter transition" type="button">
                <i class="fa fa-refresh"></i>
            </a>
        </div>

            <div class="content-box__filter-search content-box__filter filter-float__right">
                <input type="text" name="filters[text]" class="form-control filter-search"
                       placeholder="{{trans('all.find')}}...">

                {{--<a href="{{ route('transport.index') }}" class="btn btn-filter transition" type="button">--}}
                    {{--<i class="fa fa-refresh"></i></a>--}}
            </div>


        {{--</div>--}}

    </form>
    <div class="clearfix"></div>
</div>
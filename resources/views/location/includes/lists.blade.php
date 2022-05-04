<div id="locations">
    <div class="header">
        <div class="search-header-wrap menu-close-wrap">
            <a href="" id="menu-close" class="pull-right"></a>
        </div>
        <div class="search-header-wrap tabs">
            <a href="#transport" class="pull-left default active" aria-controls="transport" role="tab" data-toggle="tab">{{ trans('all.transport') }}</a>
            <a href="#orders" class="pull-right" aria-controls="orders" role="tab" data-toggle="tab" style="margin-right: 16px;">{{ trans('all.orders') }}</a>
        </div>
        <div class="search-header-wrap">
            <input type="text" name="search" class="tsearchInput form-control">
        </div>
    </div>
    <div class="content-box__body col-sm-12">
        @include('location.includes.lists-content')
    </div>
    <div class="type_window" data-id="">
        <ul>
            <li><a href="" class="type_window_history">Запросить маршрут</a></li>
            <li><a href="" class="type_window_current">Текущий заказ</a></li>
        </ul>
    </div>
</div>
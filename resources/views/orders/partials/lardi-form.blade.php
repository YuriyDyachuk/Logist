<link rel="stylesheet" type="text/css" href="{{ url('bower-components/semantic/dist/components/dropdown.min.css') }}"> 
<link rel="stylesheet" type="text/css" href="{{ url('bower-components/semantic/dist/components/transition.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('bower-components/semantic/dist/components/popup.min.css') }}">
<form>

</form>
<form method="GET" action="" id="lardiForm">
    <div class="container-fluid lardi-form" style="">
        <div class="row" style="margin-bottom: 15px;">
            <div class="group col-xs-3">
                <label class="control-label" for="countryfrom">{{trans('all.countryfrom')}}</label>
                <fieldset>
                    <div id="countryfrom" class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="countryfrom" autocomplete="off">
                        <i class="dropdown icon"></i>
                        <div class="default text">{{trans('all.country_select')}}</div>
                        <div class="menu">
                        </div>
                    </div>
                    <div id="areafrom" class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="areafrom" autocomplete="off">
                        <i class="dropdown icon"></i>
                        <div class="default text">{{trans('all.region')}}</div>
                        <div class="menu">
                        </div>
                    </div>
                    <input type="hidden" id="cityFromId" name="cityFromId" value="" autocomplete="off">
                    <input type="text" class="form-control city_autocomplete" id="cityFrom" name="cityFrom" value="" placeholder="{{trans('all.city')}}" required="" autocomplete="off">
                </fieldset>
            </div>
            <div class="group col-xs-3">
                <label class="control-label" for="countryto">{{trans('all.countryto')}}</label>
                <fieldset>
                    <div id="countryto" class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="countryto" autocomplete="off">
                        <i class="dropdown icon"></i>
                        <div class="default text">{{trans('all.country_select')}}</div>
                        <div class="menu">
                        </div>
                    </div>

                    <div id="areato" class="ui fluid multiple search selection dropdown">
                        <input type="hidden" name="areato" autocomplete="off">
                        <i class="dropdown icon"></i>
                        <div class="default text">{{trans('all.region')}}</div>
                        <div class="menu">
                        </div>
                    </div>

                    <input type="hidden" id="cityToId" name="cityToId" value="" autocomplete="off">
                    <input type="text" class="form-control city_autocomplete" id="cityTo" name="cityTo" value="" placeholder="{{trans('all.city')}}" required="" autocomplete="off">
                </fieldset>
            </div>
            <div class="col-xs-6 group">
                <div class="row">
                    <div class="col-xs-6 group">
                        <label class="control-label" for="dateFrom">{{ trans('all.date_loading') }}</label>
                        <input type="text" class="datetimepickerDate datetimepickerTime date-start form-control"
                               name="dateFrom" value=""
                               data-marker-update=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                    </div>
                    <div class="col-xs-6 group">
                        <label class="control-label" for="dateTo">{{ trans('all.date_unloading') }}</label>
                        <input type="text" class="datetimepickerDate datetimepickerTime date-start form-control"
                               name="dateTo" value=""
                               data-marker-update=""
                               placeholder="{{trans('all.placeholder_date')}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="group col-xs-6 group-4col">
                        <label class="control-label" for="mass">{{trans('all.weight')}}</label>
                        <div class="row">
                            <div class="col-xs-1"><span>{{trans('all.from')}}</span></div>
                            <div class="col-xs-4"><input type="text" name="mass" class="form-control number-order" value=""></div>
                            <div class="col-xs-4" style="float:right;"><input type="text" name="mass2" class="form-control number-order" value=""></div>
                            <div class="col-xs-1" style="float:right;"><span>{{trans('all.before')}}</span></div>
                        </div>
                    </div>
                    <div class="group col-xs-6 group-4col">
                        <label class="control-label" for="value">{{trans('all.volume')}}</label>
                        <div class="row">
                            <div class="col-xs-1"><span>{{trans('all.from')}}</span></div>
                            <div class="col-xs-4"><input type="text" name="value" class="form-control number-order" value=""></div>
                            <div class="col-xs-4" style="float:right;"><input type="text" name="value2" class="form-control number-order" value=""></div>
                            <div class="col-xs-1" style="float:right;"><span>{{trans('all.before')}}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex">
            <div class="text-right">
                {{trans('all.vehicles')}}:
            </div>
            <div>
                <div class="ui button visible cartype" data-not-select="{{trans('all.any')}}">{{trans('all.any')}}</div>
                <div class="ui special popup cartype_inputs">
                </div>
            </div>
            <div>
                <div class="checkbox">
                    <input type="checkbox" name="strictBodyTypes" id="strictBodyTypes">
                    <label for="strictBodyTypes">
                        {{trans('all.search_strict_lardi')}}
                    </label>
                </div>
            </div>
            <div class="text-right">
                <button type="button" id="lardi-orders-get" class="btn btn-info btn-lg button-green transition" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{trans('all.loading')}}">{{trans('all.search')}}</button>
            </div>
        </div>
    </div>
</form>

<div class="container lardi-error">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3 text-center">
            <div class="alert alert-danger" role="alert" id="lardi-error-msg"></div>
        </div>
    </div>
</div>

<form class="lardi-form-order" action="/logistic/store" method="post">
    {{ csrf_field() }}
<div id="lardi-orders"></div>
    <button type="button" id="lardi-orders-edit" class="btn btn-info btn-lg button-green transition" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{trans('all.loading')}}">{{trans('all.add')}}</button>
    <button type="submit" id="lardi-orders-save" class="btn btn-info btn-lg button-green transition" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> {{trans('all.loading')}}">{{trans('all.submit')}}</button>
</form>

<div id="lardi-pagination" style="display: none;">
    <div class="content-box__paginav">
        <div class="content-box__paginav">
            <ul class="list">
            </ul>
        </div>
</div>

<div id="lardi-default" style="display: none;">
<input type="hidden" name="link[]" id="link" value="">
<input type="hidden" name="id[]" id="id" value="">
<div class="content-box__row">
    <div class="card-order">
        <div class="row flex">
            <div class="col-xs-1 text-center">
                <p class="text-center">{{trans('all.select')}}:</p>
                <input type="checkbox" name="lardiorder[]" class="lardi-checkbox" ></div>
            <div class="col-xs-2 br-2 flex align-content-between">
                <div class="">
                    <span class="marker-planning transition"></span>
                </div>
                <div class="">
                    <h4 class="title-block label-card"><b></b></h4>
                </div>

                <div>
                    <h5 class="title-grey label-card">{{trans('all.category')}}</h5>
                    <span class="small-size bold">{{trans('all.automotive')}}</span>
                </div>
            </div>
            <div class="col-xs-4 br-2 flex">
                <div class="row info-download">
                    <div class="col-xs-5">
                        <h5 class="title-grey label-card">{{ trans('all.date_loading') }}</h5>
                        <span class="small-size" id="datefrom"></span>
                    </div>

                    <div class="col-xs-7">
                        <h4 class="title-black label-card" id="from"></h4>
                        <div class="line-map">
                            <div class="point-download"></div>
                            <div class="point-upload"></div>
                        </div>
                    </div>
                </div>

                <div class="row info-upload">
                    <div class="col-xs-5">
                        <h5 class="title-grey label-card">{{ trans('all.date_unloading') }}</h5>
                        <span class="small-size"></span>
                    </div>
                    <div class="col-xs-7">
                        <h4 class="title-black label-card" id="to"></h4>
                    </div>
                </div>
            </div>


            <div class="col-xs-2 flex align-center cargo align-content-between">
                <div class="row">
                    <div class="col-xs-12 ">
                        <h5 class="title-grey label-card">{{ trans('all.cargo') }}:<span class="name" id="gruz"></span></h5>
                        <div class="spec spec_text">
                            <span><i class="fa fa-cube"></i> <span id="volume"></span><span class="as-unit">M3</span></span>
                            <span><i class="fa fa-balance-scale"></i> <span id="weight"></span><span class="as-unit">т</span></span>
                            <br>
                        </div>
                        <div class="spec spec_input">
                            <span><i class="fa fa-cube"></i> <input name="volume[]" class="form-control cargo_form" id="volume_form" type="text" value=""><span class="as-unit">M3</span></span>
                            <span><i class="fa fa-balance-scale"></i> <input name="weight[]" class="form-control cargo_form" id="weight-form" type="text" value=""><span class="as-unit">т</span></span><br>
                            <span><i class="fa fa-arrows-alt"></i></span> <br>
                            Д <input name="length[]" class="form-control cargo_form" id="lengthform" type="text" value="">
                            <span class="as-unit after-x">{{ trans('all.cm') }}</span><br>
                            В <input name="height[]" class="form-control cargo_form" id="heightform" type="text" value="">
                            <span class="as-unit after-x">{{ trans('all.cm') }}</span><br>
                            Ш <input name="width[]" class="form-control cargo_form" id="widthform" type="text" value="">
                            <span class="as-unit">{{ trans('all.cm') }}</span>
                        </div>
                        <h5 class="title-grey label-card" style="margin-top: 10px;">{{trans('all.other')}}: <span class="name" id="other"></span></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <h5 class="title-grey label-card">{{ trans('all.transport') }}</h5>
                        <div class="small-size bold"></div>
                        <span class="small-size"></span>
                        <span class="small-size"></span>
                    </div>
                </div>
            </div>


            <div class="col-xs-3 payment-block">
                <div class="pl-20 price">
                </div>

                <div class="pl-20 pb-0">
                    <h5 class="title-grey label-card">{{trans('all.payment_type')}}</h5>
                    <span class="small-size bold" id="payment"></span>
                </div>

                <div class="pl-20">
                    <h5 class="title-grey label-card">{{ trans('all.terms_type') }}</h5>
                    <span class="small-size bold"></span>
                </div>

                <div class="pl-20">
                    <h5 class="title-grey label-card">{{ trans('all.client') }}</h5>
                    <span class="small-size bold">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@push('scripts')
    <script src="{{ url('bower-components/semantic/dist/components/dropdown.min.js') }}"></script>
    <script src="{{ url('bower-components/semantic/dist/components/transition.min.js') }}"></script>
    <script src="{{ url('bower-components/semantic/dist/components/popup.min.js') }}"></script>
<script>

    $('.ui.dropdown').dropdown();

    $('.cartype').popup({
        inline: true,
        position   : 'bottom right',
        on    : 'click',
        lastResort: true
    });

    $.ajax({
        url     : "/logistic/larditrans_country",
        type    : 'GET',
        dataType: 'JSON',
        async   : false,
        success : function (data) {
            $.each(data, function(key, value) {
                $('#countryfrom .menu')
                    .append('<div class="item" data-value="'+key+'_'+value+'">'+value+'</div>');
            });

            $.each(data, function(key, value) {
                $('#countryto .menu')
                    .append('<div class="item" data-value="'+key+'_'+value+'">'+value+'</div>');
            });
        },
        error   : function (data) {
            console.log(data);
        }
    });

    $('#cityTo').on('input',function(e){
        var city = $(this).val();
        if(city.length > 2){

            var country = $('input[name=countryto]').val();
            var areas = $('input[name=areato]').val();

            $.ajax({
                url     : '/logistic/larditrans_sities',
                type    : 'GET',
                data:{
                    q: city,
                    countrySIGN : country,
                    areaId: areas
                },
                success : function (data) {
                    let list = '<div class="list-group autocomplete-result">';
                    data.forEach(function (item) {
                        console.log(item);
                        list += '<a href="javascript://" class="list-group-item" data-place="'+item[3]+'">'+item[0]+'</a>';
                    });
                    list +=  '</div>';
                    $('#cityTo').parent().append(list + '</div>');


                    $('.autocomplete-result a').bind('click', function () {
                        let $_parent = $(this).parent();
                        $('#cityToId').val($(this).attr('data-place'));
                        $_parent.siblings('input.city_autocomplete').val($(this).text());
                    })
                },
                error   : function (data) {
                    console.log(data)
                }
            });
        }
    });

    $('#cityFrom').on('input',function(e){
        var city = $(this).val();
        if(city.length > 2){

            var country = $('input[name=countryto]').val();
            var areas = $('input[name=areato]').val();

            $.ajax({
                url     : '/logistic/larditrans_sities',
                type    : 'GET',
                data:{
                    q: city,
                    countrySIGN : country,
                    areaId: areas
                },
                success : function (data) {
                    let list = '<div class="list-group autocomplete-result">';
                    data.forEach(function (item) {
                        console.log(item);
                        list += '<a href="javascript://" class="list-group-item" data-place="'+item[3]+'">'+item[0]+'</a>';
                    });
                    list +=  '</div>';
                    $('#cityFrom').parent().append(list + '</div>');


                    $('.autocomplete-result a').bind('click', function () {
                        let $_parent = $(this).parent();
                        $('#cityFromId').val($(this).attr('data-place'));
                        $_parent.siblings('input.city_autocomplete').val($(this).text());
                    })
                },
                error   : function (data) {
                    console.log(data)
                }
            });
        }
    });

    $('body').on('blur', '.city_autocomplete', function () {
        deleteAutocompleteResult()
    });
    $('body').on('change', '.city_autocomplete', function () {
        deleteAutocompleteResult()
    });

    function deleteAutocompleteResult() {
        $('body').find('.autocomplete-result').fadeOut(200, function () {
            $(this).detach();
        });
    }


    $.ajax({
        url     : "/logistic/larditrans_avto",
        type    : 'GET',
        dataType: 'JSON',
        //async   : false,
        success : function (data) {
            $.each(data, function(key, value) {
                $('.cartype_inputs').append('<div class="car_type_col" data-name="'+value+'" style=""><div class="checkbox"><input id="'+value+'" type="checkbox" name="bt_chb_group[]" value="'+key+'"><label for="'+value+'">'+value+'</label></div></div>');
            });
        },
        error   : function (data) {
            console.log(data)
        }
    });


    $('#countryfrom').dropdown({
        onChange: function(val, text, $choice) {
            if(val !== ''){
                var select_areas = val.split(',');

                if(select_areas.length > 1){
                    $('#cityFrom').prop('disabled', 'disabled');
                    $("#cityFrom").val("");
                }
                else {
                    $('#cityFrom').prop('disabled', false);
                }

                $('#areafrom .menu').empty();
                $.ajax({
                    url     : "/logistic/larditrans_areas",
                    type    : 'GET',
                    dataType: 'JSON',
                    success : function (areas) {
                        $.each(select_areas, function(index, value) {
                            var country_id = value.split('_')[0];
                            $.each(areas[country_id], function(key, value2) {
                                $('#areafrom .menu').append('<div class="item" data-value="'+value2.id+'">'+value2.name+'</div>');
                            });
                        });
                    },
                    error   : function (data) {
                        console.log(data)
                    }
                });

            }
        }
    });

    $('#countryto').dropdown({
        onChange: function(val, text, $choice) {
            if(val !== ''){
                var select_areas = val.split(',');

                if(select_areas.length > 1){
                    $('#cityTo').prop('disabled', 'disabled');
                    $("#cityTo").val("");
                }
                else {
                    $('#cityTo').prop('disabled', false);
                }

                $('#areato .menu').empty();
                $.ajax({
                    url     : "/logistic/larditrans_areas",
                    type    : 'GET',
                    dataType: 'JSON',
                    success : function (areas) {
                        $.each(select_areas, function(index, value) {
                            var country_id = value.split('_')[0];
                            $.each(areas[country_id], function(key, value2) {
                                $('#areato .menu').append('<div class="item" data-value="'+value2.id+'">'+value2.name+'</div>');
                            });
                        });
                    },
                    error   : function (data) {
                        console.log(data)
                    }
                });
            }
        }
    });

    $('#lardi-orders-get').on('click', function(e){
        var $this = $(this);
        $this.button('loading');

        $('#lardi_data').val('');

        var form = $('#lardiForm');
        var data = form.serialize();

        $.ajax({
            url     : "/logistic/larditrans_orders",
            type    : 'GET',
            data    : data,
            dataType: 'JSON',
            success : function (data) {
                console.log(data);
                $('.lardi-error').hide();
                if(data.status == 'error'){

                    $('#lardi-error-msg').text(data.message);
                    $('.lardi-error').show("slow");
                }
                else {
                    $.data(document.body, 'lardi_data_orders', data);
                    set_lardi_data();
                }
                $this.button('reset');
            },
            error   : function (data) {
                console.log(data)
            }
        });
    });

    function set_lardi_data(num){

        // pagination
        var per_page = 5;
        var end;

        if (num === undefined || num === 1) {
            start = 1;
            end = per_page;
            num = 1;
        }
        else {
            end = num * per_page;
            start = (num - 1) * per_page;
        }

        $('#lardi-orders').empty();

        var orders = $.data(document.body, 'lardi_data_orders');

        var count = Object.keys(orders).length;
        var pages = Math.round(count/per_page);

        $('#lardi-pagination .list').empty();

        for (var i = 1; i <= pages; i++) {

            if(i == num){
                $('#lardi-pagination .list').append('<li class="active transition"><a id="link_lardi_pagination" style="color:#fff" data-page="'+i+'" href=""><span>'+i+'</span></a></li>');
            }
            else {
                $('#lardi-pagination .list').append('<li class="transition link-paginav"><a id="link_lardi_pagination" data-page="'+i+'" href=""><span>'+i+'</span></a></li>');
            }
        }

        $('#lardi-pagination').show();

        $.each(orders, function(key, value) {
            if (start <= (key+1) && (key+1) <= end){
                $('#lardi-default').find('#id').val(key);

                $('#lardi-default').find('#datefrom').html(value.date);
                $('#lardi-default').find('#from').html(value.from + ', ' + value.from_area);
                $('#lardi-default').find('#to').html(value.to + ', ' + value.to_area);
                $('#lardi-default').find('#gruz').html(value.gruz.name);
                $('#lardi-default').find('#payment').html(value.oplata);
                $('#lardi-default').find('#link').val(value.link);

                $('#lardi-default').find('#volume').html(value.gruz.volume);
                $('#lardi-default').find('#weight').html(value.gruz.weight);

                $('#lardi-default').find('#widthform').attr('value', value.gruz.width);
                $('#lardi-default').find('#heightform').attr('value', value.gruz.height);
                $('#lardi-default').find('#lenghtform').attr('value', value.gruz.lenght);
                $('#lardi-default').find('#other').html(value.gruz.other);

                var html = $('#lardi-default').html();
                $('#lardi-orders').append(html);
            }
        });

    }

    $('.datetimepickerDate').datetimepicker({
        format: 'L'
    });

    $(document).on('click', '#link_lardi_pagination', function(e){
        e.preventDefault();
        var num = $(this).attr('data-page');
        set_lardi_data(num);
    });

    $(document).on('change', '.car_type_col', function(e){
        var select_not = $('.cartype').attr('data-not-select');

        $('.cartype').empty();

        var checked = false;

        $('.car_type_col input[type=checkbox]:checked').each(function(i,elem) {
            checked = true;
            var cartype = $(this).parents('.car_type_col').attr('data-name');
            console.log();
            $('.cartype').append('<span>'+cartype+ '</span> ');
        });

        if (checked === false){
            $('.cartype').text(select_not);
        }
    });

    $(document).on('change', '.lardi-checkbox', function() {
        let view = false;

        $('.lardi-checkbox').each(function(i, elem){
            if($(this).is(':checked')){
                view = true;
            }
            else {
                $(this).find('.spec_input').hide();
                $(this).find('.spec_text').show();
            }
        });

        if(view === true){
            $('#lardi-orders-save').hide();
            $('#lardi-orders-edit').show();
        }
        else {
            $('#lardi-orders-edit').hide();
            $('#lardi-orders-save').hide();
        }
    });

    $(document).on('click', '#lardi-orders-edit', function(){

        $('#lardi-orders .card-order').each(function(i, elem){

            let checkbox = $(this).find('.lardi-checkbox');
            if (checkbox.is(':checked')){

                let v = $(this).find('#volume').text();
                $(this).find('#volume_form').val(v);

                let w = $(this).find('#weight').text();
                $(this).find('#weight_form').val(w);

                $(this).find('.spec_input').show();
                $(this).find('.spec_text').hide();
            }
        });

        $('#lardi-orders-edit').hide();
        $('#lardi-orders-save').show();
    })
</script>
@endpush
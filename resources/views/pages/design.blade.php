<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.includes.head')

    <style>
        li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="loading /*is-collapsed*/" data-language="{{app()->getLocale()}}">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Elements</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3 left-menu">
                <ul class="list-group">
                    <li class="list-group-item"><a href="#typography">Заголовки</a></li>
                    <li class="list-group-item"><a href="#buttons">Buttons</a></li>
                </ul>
            </div>
            <div class="col-xs-9">
                <h2><a name="typography"></a>Заголовки</h2>
                <hr>
                <h1>Заголовок 1</h1>
                <h2>Заголовок 2</h2>
                <h3>Заголовок 3</h3>
                <hr>
                <h2><a name="buttons"></a>Buttons</h2>
                <ul class="list-unstyled">
                    <li><a href="" class="btn button-style1 ">Активировать</a></li>
                    <li><button type="button" class="btn button-style1">Активировать<span class="arrow-right"></span></button></li>
                    <li><a href="" class="btn button-cancel">Отменить заказ<i class="symbol-close">×</i></a></li>
                    <li><a href="" class="btn button-style1 ">Save</a></li>
                    <li><a href="" class="btn button-style1 "><i class="as as-adddocument"></i>{{ trans('all.create_new_order') }}</a></li>
                    <li><a href="" class="btn button-style1 "><i class="as as-adddocument"></i>{{ trans('all.create_new_order_logist') }}</a></li>
                    <li><button class="btn button-style1 "><i class="as as-adddocument"></i>New order Button</button></li>
                    <li><button class="btn button-style1 "><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>Save</button></li>
                    <li><a href="" class="btn button-style1 "><i class="as as-adddocument"></i>{{ trans('all.create_new_order_logist') }}</a><br></li>
                    <li><a href="" class="btn button-style1 "><i class="as as-addclient"></i>{{ trans('profile.add_employee') }}</a><br></li>
                    <li><a href="" class="btn button-style1 "><i class="as as-addclient"></i>{{ trans('profile.add_partner') }} Link</a><br></li>
                    <li><button class="btn button-style1 "><i class="as as-addclient"></i>{{ trans('profile.add_partner') }} Button</button><br></li>
                    <li><a href="" class="btn button-style3 ">{{ trans('all.save') }} Link</a><br></li>
                    <li><button class="btn button-style3 ">{{ trans('all.save') }} Button</button><br></li>
                    <li><a href="" class="btn button-block"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>{{ trans('profile.add_affiliate') }}</a><br></li>
                    <li><button class="btn button-block"><span class="glyphicon glyphicon-lock"></span>{{ trans('profile.add_affiliate') }}</button><br></li>
                    <li><button class="btn button-block"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>{{ trans('all.save') }}</button><br></li>
                    <li><button class="btn button-block"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>Test</button><br></li>
                    <li><a href="" class="btn button-style2 "><i class="as as-adddocument"></i>{{ trans('all.create_new_order') }}</a></li>
                    <li><a href="" class="btn button-style2 "><i class="as as-adddocument"></i>{{ trans('all.create_new_order_logist') }}</a></li>
                    <li>
                        <a href="" class="btn button-cancel">Отменить заказ<i class="symbol-close">×</i></a>
                        <a href="" class="btn button-style3 ">{{ trans('all.save') }} Link</a>
                        <button type="button" class="btn button-style1">Активировать<span class="arrow-right"></span></button>
                    </li>
                    <li style="margin-bottom: 10px">
                        <a href="{{ route('transport.create') }}" class="btn button-style1 transition">
                            <i class="fa fa-truck"></i>
                            {{ trans('all.add_transport') }}
                        </a>

                    </li>
                </ul>
                <br>
                <br>


            </div>
        </div>
    </div>
</body>
</html>
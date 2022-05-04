@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <div class="panel-heading">Paywith Portmone</div>
                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="custom-alerts alert alert-success fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message !!}
                        </div>
                        <?php Session::forget('success');?>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="custom-alerts alert alert-danger fade in">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {!! $message !!}
                        </div>
                        <?php Session::forget('error');?>
                    @endif
                        <div class="form-group">
                            <label>
                                <div >
                                    {{trans('all.balance')}} : {{ $user->balance }}
                                </div>
                            </label>
                        </div>
                        <div class="form-group">
                            <form action="{{route('pay.portmone.submit')}}" method="post">
                                {{csrf_field()}}
                                <input type="hidden" name="payee_id" value="{{ env('PORTMONE_PAYEE_ID') }}" />
                                <input type="hidden" name="shop_order_number" value="1" />
                                <input type="number" name="bill_amount" value="" step="0.1"/>
                                <input type="hidden" name="description" value="InnLogist Payment (Portmone)"/>
                                <input type="hidden" name="success_url" value="{{ route('pay.portmone.result', ['ok']) }}" />
                                <input type="hidden" name="failure_url" value="{{ route('pay.portmone.result', ['fail']) }}" />
                                <input type="hidden" name="lang" value="ru" />
                                <input type="hidden" name="encoding" value="UTF-8" />
                                <input type="submit" value="Оплатить" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
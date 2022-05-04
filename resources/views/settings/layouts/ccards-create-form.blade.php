
<form class="form-horizontal" id="{{ isset($card) ? 'updateCcard' : 'createCcard' }}">
    <div class="form-group">
        <label class="control-label col-sm-4">{{trans("all.card_name")}}</label>
        <div class="col-sm-6">
            <input type="text" name="cn" class="form-control cn_new" placeholder="XXXX XXXX XXXX XXXX" value="{{ $card['n_full'] or ''}}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4">{{trans("all.card_validity")}}</label>
        <div class="col-sm-3">
            <input type="text" name="em" class="form-control em_new" placeholder="MM" value="{{ $card['em'] or ''}}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4">{{trans("all.card_validity")}}</label>
        <div class="col-sm-3">
            <input type="text" name="ey" class="form-control ey_new" placeholder="YY" value="{{ $card['ey'] or ''}}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-4">{{trans("all.card_cvv")}}</label>
        <div class="col-sm-3">
            <input type="text" name="cvv" class="form-control cvv_new" placeholder="CVV" value="{{ $card['cvv'] or ''}}">
        </div>
    </div>

    @unless(isset($card['n_full']))
        <div class="form-group text-right">
            <div class="col-xs-12">
                <input type="button" value="{{trans("all.add")}}"
                       class="btn btn-success add_cc_ajax" href="{{route('cc.add.ajax')}}">
            </div>
        </div>
    @endunless
</form>
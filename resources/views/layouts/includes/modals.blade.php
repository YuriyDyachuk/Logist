@if(!\Request::is('pay'))
    @include('pay.partials.modal_subscriptions', ['link' => true])
@endif

@if(profile_filled() === false)
<!-- Modal Select Profile Type: BEGIN -->
<div id="selectProfile" class="modal" role="dialog" style="z-index: 100005;">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="h1 modal-title">
                    {{ trans('all.select_profile') }}
                </div>
            </div>
            <div class="modal-body">

                <div class="form-group d-inline-block">
                    <label class="container_radio">{{trans('all.company_type_individual')}}
                        <input class="company_type" name="company_type" type="radio" id="" value="individual" autocomplete="off">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="form-group d-inline-block">
                    <label class="container_radio">{{trans('all.company_type_company')}}
                        <input class="company_type" name="company_type" type="radio" id="" value="company" autocomplete="off">
                        <span class="checkmark"></span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn button-green xs" id="btn_selectProfileLater" value="submit"><span>Позже</span></button>
                <button type="submit" class="btn button-green xs" id="btn_selectProfile" value="submit" disabled="" autocomplete="off"><span>ОК</span></button>
            </div>

        </div>
    </div>
</div>
@endif
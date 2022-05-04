<div role="tabpanel" class="tab-pane fade in active transition" id="info">
    <div class="tab-pane__row">
        <div class="row">
            <div class="/*tab-pane_col-left*/ col-xs-12 col-sm-6">

                <div class="form-horizontal text-left">

                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.fio_client')}}</label>
                        <span>{{$user->name}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.phone')}}</label>
                        <span>{{$user->phone}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.email')}}</label>
                        <span>{{ isset($user->email) ? $user->email : trans('all.empty')}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">SKYPE</label>
                        <span>{{ isset($user->client->data['skype']) ? $user->client->data['skype'] : trans('all.empty') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.city')}}</label>
                        <span>{{ isset($user->meta_data['address_city']) ? $user->meta_data['address_city'] : trans('all.empty')}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.street')}}</label>
                        <span>{{ isset($user->meta_data['address_street']) ? $user->meta_data['address_street'] : trans('all.empty')}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.index')}}</label>
                        <span>{{ isset($user->meta_data['address_index']) ? $user->meta_data['address_index'] : trans('all.empty')}}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">{{trans('all.special_conditions')}}</label>
                        <span class="label-name">{{ isset($user->client->data['condition']) ? $user->client->data['condition'] : trans('all.empty') }}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
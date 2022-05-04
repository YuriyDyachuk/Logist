<!-- Modal Add new client: BEGIN -->
<div id="addClient" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">
                    <span v-if=edit>{{trans('all.client_edit')}}</span>
                    <span v-else>{{trans('all.add_client')}}</span>
                </div>
            </div>
            <form id="addNewClient" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-body">
                    <!-- Tabs content -->
                    <div class="tab-content">
                        {{-- STEP-1 --}}
                        <div role="tabpanel" :class="{'tab-pane': true, 'in active': step == 1}" id="step1">
                            <div class="step-title">{{ trans('all.step') }} @{{ step }} {{ trans('all.step_of') }} 2</div>

                            <div class="form-group" :class="{'has-error shake': errors.email}">
                                <label for="client_email" class="control-label">email</label>
                                <input v-model="client.email" @change="checkUser()" name="email" type="email"
                                       class="form-control" :readonly="edit" autocomplete="off">
                                <span v-if="loading" class="as-loader"></span>
                            </div>

                            <div class="form-group" :class="{'has-error shake': errors.phone1}" style="z-index: 2">
                                <label for="clientPhone" class="control-label">{{ trans('all.phone') }}</label>
                                <input v-model.lazy="client.phone" type="text" class="form-control phone" name="phone1"  id="phone1"
                                       :readonly="isSystem">
                            </div>

                            <a v-show="!isSystem" href="javascript://" id="addTwoPhone" class="transition">{{ trans('all.phone_add_second') }}</a>

                            <div class="form-group hidden animated fadeIn clientPhone2_wrapper">
                                <label for="clientPhone2" class="control-label">{{ trans('all.phone') }} #2</label>
                                <input v-model="client.phone2" type="text" name="phone2" class="form-control phone"
                                       id="clientPhone2" :readonly="isSystem">
                                <a class="icon-basket" id="rmTwoPhone" href=""><i class="as as-del"></i></a>
                            </div>

                            <div v-show="!edit" class="form-group checkbox">
                                <strong v-if="isSystem && !alreadyExists" class="status text-success">{{ trans('all.status_client_online') }}</strong>
                                <strong v-if="!isSystem && !alreadyExists" class="status text-warning">{{ trans('all.status_client_offline') }}</strong>
                                <strong v-if="alreadyExists && isSystem" class="status text-warning">{{ trans('all.client_in_list') }}</strong>

                                <input v-if="!isSystem" type="checkbox" value="1" name="invite" id="invite">
                                <label v-if="!isSystem" for="invite" class="text-inherit">{{ trans('all.client_send_invitation') }}</label>
                                <label v-else for="invite" class="text-inherit"></label>
                            </div>

                            <div class="form-group addon-file" :class="{'has-error shake': errors.name }">
                                <label for="" class="control-label">{{ trans('all.full_name') }}</label>
                                <input v-model="client.name" name="name" type="text" class="form-control"
                                       :readonly="isSystem">

                                <label for="avatar"
                                       class="control-label addon-file-label">{{ trans('all.photo') }}</label>
                                <input id="avatar" type="file" name="images[]" :disabled="isSystem">
                            </div>

                            <div class="form-group">
                                <label for="client_email">{{ trans('all.company_name') }}</label>
                                <input v-model="client.companyName" type="text" class="form-control"
                                       name="companyName" :readonly="isSystem">
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">{{trans('all.client_company_role')}}</label>
                                <input v-model="client.position" type="text" class="form-control" name="position"
                                       :readonly="isSystem">
                            </div>
                        </div>

                        {{-- STEP-2 --}}
                        <div role="tabpanel" :class="{'tab-pane': true, 'in active': step == 2}" id="step2">
                            <div class="step-title">
                                <button @click="step--" type="button" class="btn btn-link link-back"><i>&#8592;</i>
                                    {{ trans('all.back') }}
                                </button>
                                <span>{{ trans('all.step') }} @{{ step }} {{ trans('all.step_of') }} 2</span>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">{{trans('all.country')}}</label>
                                <input v-model="client.country" type="text" class="form-control" name="country"
                                       :readonly="isSystem">
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">{{trans('all.city')}}</label>
                                <input v-model="client.city" type="text" class="form-control" name="city"
                                       :readonly="isSystem">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="" class="control-label">{{trans('all.street')}}</label>
                                        <input v-model="client.street" type="text" class="form-control" name="street"
                                               :readonly="isSystem">
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="" class="control-label">Zip code</label>
                                        <input v-model="client.index" type="text" class="form-control" name="index"
                                               :readonly="isSystem">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">Skype</label>
                                <input v-model="client.skype" type="text" class="form-control" name="skype">
                            </div>

                            <div v-if="!isSystem" class="form-group" style="display: none">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <label for="" class="control-label">{{ trans('all.number_order') }}</label>
                                        <input v-model="client.order.number" type="text" class="form-control"
                                               name="order[number]">
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="" class="control-label">{{ trans('all.date') }}</label>
                                        <input v-model="client.order.date" type="text"
                                               class="form-control datetimepicker date"
                                               name="order[date]">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="control-label">{{ trans('all.special_conditions') }}</label>
                                <input v-model="client.condition" type="text" class="form-control" name="condition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn button-cancel" data-dismiss="modal">{{trans('all.cancel')}} <span>&times;</span>
                    </button>

                    <button v-if="step < 2" @click="validate()" type="button" class="btn button-style1"
                            :disabled="!btnSubmit">{{ trans('all.next') }}<span
                                class="arrow-right"></span></button>
                    <button v-else type="button" class="btn button-style1" :disabled="!btnSubmit"
                            @click="storeOrUpdate($event)">{{ trans('all.save') }} <span class="arrow-right"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add new client: END -->

@push('scripts')
    {{-- Vue.js --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const vClient = new Vue({
                                    el: '#addClient',
                                    data: {
                                        step: 1,
                                        edit: false,
                                        isSystem: false,
                                        btnSubmit: true,
                                        alreadyExists: false,
                                        errors: {email: false, phone2: false, name: false},
                                        loading: false,
                                        client: getDefaultData(),
                                    },
                                    methods: {
                                        validate: function () {
                                            let $form = $('#step' + this.step);
                                            let _this = this;
                                            let res   = true;
                                            let re    = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

                                            this.resetValidate();
                                            setTimeout(function () {
                                                $form.find('input').each(function () {
                                                    let $this = $(this);
                                                    let name  = $this.attr('name');

                                                    if (_this.errors.hasOwnProperty(name)) {
                                                        if ($this.val() === '' && !$this.hasClass('phone')) {
                                                            res                = false;
                                                            _this.errors[name] = true;
                                                        }
                                                        if (name === 'email' && !re.test($this.val())) {
                                                            res                = false;
                                                            _this.errors[name] = true;
                                                        }
                                                        if ($this.hasClass('phone') && !$this.intlTelInput("isValidNumber") && $this.attr('readonly') === undefined && $this.is(":visible")) {
                                                            res                = false;
                                                            _this.errors[name] = true;
                                                        }
                                                    }
                                                });
                                                if (res) _this.step++;
                                            }, 30);
                                        },

                                        resetValidate: function () {
                                            for (let item in this.errors) {
                                                if (this.errors.hasOwnProperty(item))
                                                    this.errors[item] = false;
                                            }
                                        },

                                        resetData: function () {
                                            this.client    = getDefaultData();
                                            this.isSystem  = false;
                                            this.btnSubmit = true;
                                            this.edit      = false;
                                            this.resetValidate();
                                        },

                                        resetDataForEmail: function () {
                                            let email         = this.client.email;
                                            this.client       = getDefaultData();
                                            this.client.email = email;
                                        },

                                        checkUser: function () {
                                            let _this     = this;
                                            _this.loading = true;

                                            $.post('/client-exists', {_token: CSRF_TOKEN, email: this.client.email})
                                             .done(function (res) {
                                                 console.log(res);
                                                 if (res.status === 'success' && res.client) {
                                                     _this.btnSubmit = true;
                                                     _this.client    = res.client;
                                                     _this.isSystem  = true;

                                                     if (res.alreadyExists) {
                                                         _this.alreadyExists = true;
                                                         _this.btnSubmit = false;
                                                     }
                                                 } else {
                                                     _this.btnSubmit     = true;
                                                     _this.isSystem      = false;
                                                     _this.alreadyExists = false;
                                                     _this.resetDataForEmail()
                                                 }
                                             })
                                             .fail(function () {
                                                 swal('Something went wrong... :(', '', 'warning');
                                             })
                                             .always(function () {
                                                 _this.loading = false;
                                             });
                                        },

                                        storeOrUpdate: function (event) {
                                            const redirectRoute = document.getElementsByClassName('button-style1').onclick = function() {
                                                window.location.href = 'order-create';
                                                let nameSelect = document.querySelector('input[name="name"]');
                                                localStorage.setItem('name', nameSelect.value);
                                            };
                                            let _this = this,
                                                id    = _this.client.id || 0,
                                                data  = new FormData($('#addNewClient')[0]),
                                                url   = _this.edit ? '/client/' + id : '/client';

                                            if (_this.edit)
                                                data.append('_method', 'PUT');
                                            else
                                                data.append('id', id);

                                            btnLoader(event.target);
                                            _this.btnSubmit = false;

                                            $.ajax({
                                                       url: url,
                                                       type: 'POST',
                                                       data: data,
                                                       processData: false,
                                                       contentType: false
                                                   })
                                             .done(function (res) {
                                                 console.log(res);
                                                 if (res.status === 'success') {
                                                     redirectRoute();
                                                     // window.location.reload();
                                                 }
                                             })
                                             .fail(function (res) {
                                                 console.log(res);
                                                 _this.btnSubmit = true;
                                                 btnLoader('hide');
                                                 swal('', 'Something went wrong... :(', 'warning');
                                             })
                                        }
                                    }
                                });

        $('#addClient').on('hidden.bs.modal', function (e) {
            vClient.step = 1;
            vClient.resetData();
            $('#avatar')
                .siblings('.file-name').detach().end()
                .val('');
        });

        $('#avatar').change(function () {
            var $this    = $(this),
                fileName = $this.val().replace(/C:\\fakepath\\/i, ''),
                html     = '<span class="file-name">' + fileName + '</span>';

            $this.siblings('.file-name').detach();
            $this.parent().append(html);
        });

        $('.datetimepicker').on('dp.hide', function (event) {
            console.log(event.currentTarget.value);
            vClient.client.order.date = event.currentTarget.value;
        });

        function edit($this) {
            let data = $this.data('client');
            vClient.client.id          = data.client_id;
            vClient.client.email       = data.user.email;
            vClient.client.phone       = data.phone || data.data.phone1 || '';
            vClient.client.phone2      = data.phone || data.data.phone2 || '';
            vClient.client.name        = data.user.name;
            vClient.client.companyName = data.company_name || data.data.companyName || '';
            vClient.client.position    = data.data.position || '';
            vClient.client.country     = data.data.country || '';
            vClient.client.city        = data.data.city || '';
            vClient.client.street      = data.data.street || '';
            vClient.client.index       = data.data.index || '';
            vClient.client.skype       = data.data.skype || '';
            vClient.client.order       = data.data.order || {};
            vClient.client.condition   = data.data.condition || '';

            vClient.edit = true;
            $('#addClient').modal('show');
        }

        function getDefaultData() {
            return {
                email: '',
                phone: '',
                phone2: '',
                name: '',
                companyName: '',
                country: '',
                city: '',
                street: '',
                index: '',
                skype: '',
                order: {},
                condition: ''
            }
        }

//        $('#phone1').mask('+000-00-000-00-00');

    </script>
@endpush
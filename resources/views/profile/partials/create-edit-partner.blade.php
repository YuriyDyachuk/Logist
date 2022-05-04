<!-- Modal Add new partner: BEGIN -->
<div id="addPartner" class="modal" role="dialog">
    <div class="modal-dialog animated zoomIn">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <div class="h1 title-blue modal-title">
                    <span v-if=edit>{{trans('all.partner_edit')}}</span>
                    <span v-else>{{trans('all.partner_add')}}</span>
                </div>
            </div>
            <form id="addNewPartner" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-body">
                    <!-- Tabs content -->
                    <div class="tab-content">
                        {{-- STEP-1 --}}
                        <div role="tabpanel" :class="{'tab-pane': true, 'in active': step == 1}" id="step1">

                            <div class="form-group" :class="{'has-error shake': errors.email}">
                                <label for="partner_email" class="control-label">email</label>
                                <input v-model="partner.email" @change="checkUser()" name="email" type="email"
                                       class="form-control" :readonly="edit" autocomplete="off">
                                <span v-if="loading" class="as-loader"></span>
                            </div>

                            <div class="form-group" :class="{'has-error shake': errors.phone1}" style="z-index: 2">
                                <label for="partnerPhone" class="control-label">{{ trans('all.phone') }}</label>
                                <input v-model="partner.phone" type="text" class="form-control phone" name="phone1"
                                       :readonly="isSystem">
                            </div>

                            {{--<a v-show="!isSystem" href="javascript://" id="addTwoPhone" class="transition">Добавить еще--}}
                                {{--один номер</a>--}}

                            {{--<div class="form-group hidden animated fadeIn">--}}
                                {{--<label for="partnerPhone2" class="control-label">{{ trans('all.phone') }} #2</label>--}}
                                {{--<input v-model="partner.phone2" type="text" name="phone2" class="form-control phone"--}}
                                       {{--id="partnerPhone2" :readonly="isSystem">--}}
                            {{--</div>--}}

                            {{--<div v-show="!edit" class="form-group checkbox">--}}
                                {{--<strong v-if="isSystem && !alreadyExists" class="status text-success">В системе</strong>--}}
                                {{--<strong v-if="!isSystem && !alreadyExists" class="status text-warning">Не в--}}
                                    {{--системе</strong>--}}
                                {{--<strong v-if="alreadyExists && isSystem" class="status text-warning">Клиент в Вашем--}}
                                    {{--списке</strong>--}}

                                {{--<input v-if="!isSystem" type="checkbox" value="1" name="invite" id="invite">--}}
                                {{--<label v-if="!isSystem" for="invite" class="text-inherit">Выслать приглашение</label>--}}
                                {{--<label v-else for="invite" class="text-inherit"></label>--}}
                            {{--</div>--}}

                            <div class="form-group addon-file" :class="{'has-error shake': errors.name }">
                                <label for="name" class="control-label">{{ trans('all.full_name') }}</label>
                                <input v-model="partner.meta_data.delegate_name" name="name" type="text" class="form-control"
                                       :readonly="isSystem">

                                {{--<label for="avatar"--}}
                                       {{--class="control-label addon-file-label">{{ trans('all.photo') }}</label>--}}
                                {{--<input id="avatar" type="file" name="images[]" :disabled="isSystem">--}}
                            </div>

                            <div class="form-group">
                                <label for="companyName">{{ trans('all.company_name') }}</label>
                                <input v-model="partner.name" type="text" class="form-control"
                                       name="companyName" :readonly="isSystem">
                            </div>

                        </div>

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" @click="resetValidate()" class="btn button-cancel transition" data-dismiss="modal">{{trans('all.cancel')}} <i>&times;</i>
                    </button>

                    <button type="button" class="btn button-style1" :disabled="!btnSubmit" @click="validate($event)" v-if=edit>
                        <span>{{trans('all.edit')}}</span>
                        <span class="arrow-right"></span>
                    </button>

                    <button type="button" class="btn button-style1" :disabled="!btnSubmit" @click="validate($event)" v-else>
                        <span>{{trans('all.add')}}</span>
                        <span class="arrow-right"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Add new partner: END -->

@push('scripts')
    {{-- Vue.js --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const vPartner = new Vue({
                                    el: '#addPartner',
                                    data: {
                                        step: 1,
                                        edit: false,
                                        isSystem: false,
                                        btnSubmit: true,
                                        alreadyExists: false,
                                        errors: {email: false, phone1: false, name: false},
                                        loading: false,
                                        partner: getDefaultData(),
                                    },
                                    methods: {
                                        validate: function (e) {
                                            let $form = $('#step' + this.step);
                                            let _this = this;
                                            let eventForm = e;
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
                                                        if ($this.hasClass('phone') && !$this.intlTelInput("isValidNumber") && $this.attr('readonly') === undefined) {
                                                            res                = false;
                                                            _this.errors[name] = true;
                                                        }
                                                    }
                                                });
                                                if (res) {
                                                    _this.storeOrUpdate(eventForm);
                                                }
                                            }, 30);
                                        },

                                        resetValidate: function () {
                                            for (let item in this.errors) {
                                                if (this.errors.hasOwnProperty(item))
                                                    this.errors[item] = false;
                                            }
                                        },

                                        resetData: function () {
                                            this.partner    = getDefaultData();
                                            this.isSystem  = false;
                                            this.btnSubmit = true;
                                            this.edit      = false;
                                            this.resetValidate();
                                        },

                                        resetDataForEmail: function () {
                                            let email         = this.partner.email;
                                            this.partner       = getDefaultData();
                                            this.partner.email = email;
                                        },

                                        checkUser: function () {
                                            if(this.partner.email === ''){
                                                return;
                                            }

                                            let _this     = this;
                                            _this.loading = true;

                                            $.post('/partner-exists', {_token: CSRF_TOKEN, email: this.partner.email})
                                             .done(function (res) {
                                                 if (res.status === 'success' && res.partner) {

                                                     if(res.partner.meta_data === null){
                                                         res.partner.meta_data = {};
                                                         res.partner.meta_data.delegate_name = res.partner.name;
                                                     }

                                                     if(res.partner.meta_data !== null && res.partner.meta_data.type === 'individual'){
                                                         res.partner.meta_data.delegate_name = res.partner.name;
                                                     }

                                                     _this.btnSubmit = true;
                                                     _this.partner    = res.partner;
                                                     _this.isSystem  = true;

                                                     if (res.alreadyExists) {
                                                         _this.alreadyExists = true;
                                                         _this.btnSubmit = false;
                                                     }
                                                 }
                                                 else if(res.status === 'disable' && res.partner) {
                                                     _this.btnSubmit     = false;
                                                     _this.isSystem      = false;
                                                     _this.alreadyExists = false;
                                                     _this.resetDataForEmail();
                                                     swal('', '{{trans('validation.partner_errors.same_email')}}', 'success');
                                                 }
                                                 else {
                                                     _this.btnSubmit     = false;
                                                     _this.isSystem      = false;
                                                     _this.alreadyExists = false;
                                                     _this.resetDataForEmail();
                                                     swal('', '{{trans('validation.partner_errors.email_exist')}}', 'warning');
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
                                            console.log(this);
                                            let _this = this,
                                                id    = _this.partner.id || 0,
                                                data  = new FormData($('#addNewPartner')[0]),
                                                url   = _this.edit ? '/partner/' + id : '/partner';
                                            data.append('images[]', $('input[type=file]')[0].files[0]);

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
                                                     window.location.reload();
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

        $('#addPartner').on('hidden.bs.modal', function (e) {
            vPartner.step = 1;
            vPartner.resetData();
            $('#avatar').val('');
            $(this).find('input[name=phone1]').val('');
        });

        $('#addPartner').on('show.bs.modal', function (e) {
            $(this).find('input[name=phone1]').val('+380');
        });

        $('.datetimepicker').on('dp.hide', function (event) {
            console.log(event.currentTarget.value);
            vPartner.partner.order.date = event.currentTarget.value;
        });

        function editPartner($this) {
            let data = $this.data('partner');

            vPartner.partner.id          = data.id;
            vPartner.partner.email       = data.email;
            vPartner.partner.phone       = data.phone || data.data.phone1 || '';
            vPartner.partner.phone2      = data.phone || data.data.phone2 || '';
            vPartner.partner.name        = data.meta_data.delegate_name|| data.data.delegate_name || '';
            vPartner.partner.companyName = data.name|| data.name;

            vPartner.edit = true;
            $('#addPartner').modal('show');
        }

        function getDefaultData() {
            return {
                email: '',
                phone: '',
                phone2: '',
                name: '',
                companyName: '',
                meta_data: {
                    delegate_name : ''
                }
            }
        }
    </script>
@endpush
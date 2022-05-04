<div class="calendar-maps">
    <div class="row">
        <div class="col-sm-12">
            <!-- Content date time rows -->
            <div class="workstat_block_sm" id="date-time_rows">
                <div class="calendars-title">
                    <div class="row">
                        <ul>
                            <li v-for="(title, index) in titlesLink"
                                v-on:click="toggleItem(index)"
                                v-bind:class="{'done': activeItemLink === index}"
                                class="title-col value">
                                @{{title}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End content date time rows -->

            <!-- Content calendar block -->
            <div v-for="item in push" class="line-content workstat_block_sm" id="content">
                <div class="row bt">
                   <div class="date-time">
                       <div>@{{item.time}}</div>
                   </div>
                    <div class="col-sm-12 body-push">
                        <div v-if="statusPush === item.status" class="col-sm-3" style="padding-left: 0;">
                            <div class="user_image dot-push">
                                <img src="{{asset('img/dashboard/active-push.png')}}" alt="logo">
                            </div>
                        </div>

                        <div v-else class="col-sm-3" style="padding-left: 0;">
                            <div class="user_image">
                                <img src="{{asset('img/dashboard/not-active-push.png')}}" alt="logo">
                            </div>
                        </div>
                        &nbsp;
                        <div class="">@{{item.message}}</div>
                    </div>
                </div>
            </div>
            <!-- End content calendar block -->
        </div>
    </div>
</div>

@push('scripts')
    {{-- Vue.js --}}
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script>
        const bodyMessage = (time, message, status) => ({time, message, status});

        const push = [
            bodyMessage('20 min ago', 'Автомобилль АА1212АА выехал к месту назначения', false),
            bodyMessage('30 min ago', 'Перешивко А.О. DAF AE 1112 ОЕ Завершил заказ', true),
            bodyMessage('40 min ago', 'Перешивко А.О. DAF AE 1110 ОЕ Завершил заказ', false),
            bodyMessage('50 min ago', 'Автомобилль АА1215АА выехал к месту назначения', false),
            bodyMessage('2 hours ago', 'Перешивко А.О. DAF AE 1111 ОЕ Завершил заказ', true),
        ]

        const message = [
            bodyMessage('10 min ago', 'Отправка заявки одобренна', false),
            bodyMessage('20 min ago', 'Отправка заявки отклоненна', true),
            bodyMessage('1 hours ago', 'Дозаполните Ваш профиль', false),
        ]

        const vMessage = new Vue({
            el: '#push',
            data: {
                push: push,
                statusPush: true,
                titlesLink: ['{{trans("all.notifications")}}','{{trans("all.message")}}'],
                activeItemLink: 0,
            },
            methods: {
                toggleItem(index) {
                    this.activeItemLink = index;
                    if (index === 0) {
                        this.push = push;
                    } else {
                        this.push = message;
                    }
                }
            }
        });

    </script>
@endpush
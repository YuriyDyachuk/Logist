<div class="content-box__header row">
    <div class="content-box__title col-xs-9" id="client-info">
        <div class="content-box__header-avatar"
             style="background-image: url({{ app_avatar_url($user->getAvatar()) }})">
        </div>
        <div class="col-xs-9">
            <h1 class="h1 title-company-name">{{ $user->name}}</h1>
            <h5 class="h5 title-grey">
                @if(isset($client->user->meta_data['type']))
                    {{ trans('all.company_type_'.$user->meta_data['type']) }}
                @else
                    {{ $user->getRoleName() }}
                @endif
            </h5>
        </div>

        <!-- Button block -->
        <div class="col-xs-6">
            <form id="addClient">
                {{ csrf_field() }}
                <input type="hidden" id="clientId" value="{{ $user->id}}" name="id">

                <div class="button-press">
                    <ul>
                        @if( empty($partner))
                            <li><button type="submit" class="btn button-style1 transition">Пригласить</button></li>
                        @elseif($partner)
                            <li><button id="submit" class="btn button-block" disabled>Запрос отправлен</button></li>
                        @endif
                    </ul>
                </div>
            </form>
        </div>
        <!-- end button block -->

    </div>

    <div class="content-box template-page col-xs-3" id="button-back" style="padding: 0;min-height: 0;">
        <div class="container-fluid btn-header">
            <div class="row">
                <div class="col-xs-6 text-right">
                    <a class="btn button-cancel" id="templates" href="{{route('client.index')}}">
                        {{trans('all.back_to_clients')}}
                        <i>&times;</i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
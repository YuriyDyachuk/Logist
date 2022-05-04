<div class="admining_list">


    <h2>{{trans('all.information')}}</h2>

    <table class="table table-bordered">
        <tr class="info">
            <td>{{trans('all.information')}}</td>
            <td>{{trans('all.old_value')}}</td>
            <td>{{trans('all.new_value')}}</td>
        </tr>

        <tr class="{{ isset($user->data['new_name']) ? 'danger' : 'success' }}">
            <td>{{trans('all.name')}}</td>
            <td>{{$user->name}}</td>
            <td>{{ $user->data['new_name'] or  '<' . trans('all.empty') . '>'}}</td>
        </tr>

        <tr class="{{ isset($user->data['new_egrpou_or_inn']) ? 'danger' : 'success' }}">
            <td>{{trans('all.egrpou_or_inn')}}</td>
            <td>{{ $user->egrpou_or_inn or  '<' . trans('all.empty') . '>'}}</td>
            <td>{{ $user->data['new_egrpou_or_inn'] or  '<' . trans('all.empty') . '>'}}</td>
        </tr>

        <tr class="{{ isset($user->data['new_company_name']) ? 'danger' : 'success' }}">
            <td>{{trans('all.company_name')}}</td>
            <td>{{ $user->company_name or  '<' . trans('all.empty') . '>'}}</td>
            <td>{{ $user->data['new_company_name'] or  '<' . trans('all.empty') . '>'}}</td>
        </tr>

        <tr class="{{ isset($user->data['new_password']) ? 'danger' : 'success' }}">
            <td>{{trans('all.password')}}</td>
            <td>{{ '*******' }}</td>
            <td>{{ isset($user->data['new_password']) ? '*******' : '<' . trans('all.empty') . '>' }}</td>
        </tr>


        @if($user->isLogistic())
            <tr class="{{ isset($user->data['new_city']) ? 'danger' : 'success' }}">
                <td>{{trans('all.city')}}</td>
                <td>{{ $user->city or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_city'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_region']) ? 'danger' : 'success' }}">
                <td>{{trans('all.region')}}</td>
                <td>{{ $user->region or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_region'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_country']) ? 'danger' : 'success' }}">
                <td>{{trans('all.country')}}</td>
                <td>{{ $user->country or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_country'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_legal_address']) ? 'danger' : 'success' }}">
                <td>{{trans('all.new_legal_address')}}</td>
                <td>{{ $user->legal_address or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_legal_address'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_index']) ? 'danger' : 'success' }}">
                <td>{{trans('all.index')}}</td>
                <td>{{ $user->index or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_index'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_company_description']) ? 'danger' : 'success' }}">
                <td>{{trans('all.company_description')}}</td>
                <td>{{ $user->company_description or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_company_description'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_site_url']) ? 'danger' : 'success' }}">
                <td>{{trans('all.site_url')}}</td>
                <td>{{ $user->site_url or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_site_url'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>

            <tr class="{{ isset($user->data['new_company_logo']) ? 'danger' : 'success' }}">
                <td>{{trans('all.company_logo')}}</td>
                <td>{{ $user->company_logo or  '<' . trans('all.empty') . '>'}}</td>
                <td>{{ $user->data['new_company_logo'] or  '<' . trans('all.empty') . '>'}}</td>
            </tr>
        @endif

        <tr class="success">
            <td>Email</td>
            <td>{{$user->email}}</td>
            <td>{{ '<' . trans('all.empty') . '>'}}</td>
        </tr>

        <tr class="success">
            <td>{{trans('all.phone')}}</td>
            <td>{{$user->phone}}</td>
            <td>{{ '<' . trans('all.empty') . '>'}}</td>
        </tr>

        @if($user->social_type != '' && $user->social_type != null)
            <tr class="success">
                <td>{{trans('all.social_network')}}</td>
                <td colspan="2">
                    <span>{{$user->social_type}} </span><br/>
                    ID : {{$user->social_id}}
                </td>
            </tr>
        @endif
    </table>
</div>
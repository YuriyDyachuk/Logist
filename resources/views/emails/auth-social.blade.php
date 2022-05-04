@component('mail::message')
    {{ trans('all.user_data_mail') }} : <br/>
    {{ trans('all.email_address') }} - {{ $email }} <br/>
    {{ trans('all.email_address') }} - {{ $password }}<br/>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
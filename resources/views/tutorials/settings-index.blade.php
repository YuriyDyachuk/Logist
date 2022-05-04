@if( !profile_filled() && user_tutorials('profile-fill'))
    @include('tutorials.pages.profile-fill')
@endif

@if( !auth()->user()->isClient() && profile_filled() && user_tutorials('transport-section-link'))
    @include('tutorials.pages.transport-section-link')
@endif
<div class="row text-center">

    <button href="{{route('admin.users.update', $user->id)}}" class="btn btn-lg btn-success admin_user_update" rel="1">{{trans('all.accept_user_request')}}</button>

    <button href="{{route('admin.users.update', $user->id)}}" class="btn btn-lg @if(!$is_verified) btn-danger admin_user_update @else btn-flat @endif" rel="2">{{trans('all.block_user_request')}}</button>

    <button href="{{route('admin.users.block', $user->id)}}" class="btn btn-lg @if(!$is_verified) @if($user->verified==0) btn-success @else btn-danger @endif admin_user_update @else btn-flat @endif">@if($user->verified==0){{trans('all.activate')}}@else{{trans('all.deactivate')}}@endif</button>

    <button href="{{route('admin.users.delete', $user->id)}}" class="btn btn-lg @if(!$is_verified) btn-danger  admin_user_update @else btn-flat @endif">{{trans('all.delete')}}</button>

</div>
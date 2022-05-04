@forelse($image_list as $image)
<tr class="@if($image->verified == 0) danger @else success @endif">
    <td colspan="2">
    {{trans('all.download')}} :
    <a href="{{HelperOption::imageUrl($image->filename, $image->path)}}" target="_blank">
        <img src="{{HelperOption::imageUrl($image->filename, $image->path)}}" class="img-responsive inline-block" width="32">{{$image->filename}}
    </a>({{$image->image_type}})
    <br/>
    </td>
</tr>
@empty
        <{{trans('all.empty')}}>
@endforelse
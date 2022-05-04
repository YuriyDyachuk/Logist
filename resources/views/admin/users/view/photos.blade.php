<div class="admining_list">
    <h2>{{trans('all.photos')}}</h2>

    <table class="table table-bordered">
        <tr class="">
            <td>{{trans('all.photos')}}</td>
            <td colspan="2">
                @include('admin.includes.images', ['image_list'=> $user->images, 'images_type'=>'photos'])
            </td>
        </tr>

        <tr @if(count($required_files['images']) == 0) class="danger" @endif>
            <td>{{trans('all.required_photos')}}</td>
            <td>
                @forelse($required_files['images'] as $required_image)
                    {{$required_image['name']}}
                @empty
                    {{'<' . trans('all.empty') . '>'}}
                @endforelse
            </td>
        </tr>
    </table>
</div>
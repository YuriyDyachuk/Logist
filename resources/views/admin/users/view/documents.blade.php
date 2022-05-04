<div class="admining_list">
    <h2>{{trans('all.documents')}}</h2>
    <table class="table table-bordered">
        <tr class="">
            <td>{{trans('all.documents')}}</td>
            <td>
            @forelse($user->documents as $document)

                @foreach($document->images()->get() as $image)
                    <tr class="@if($document->verified == 0) danger @else success @endif">
                        <td colspan="2">
                            <a href="{{HelperOption::documentUrl($image->filename)}}">{{$image->filename}}</a> ({{trans('document.' .$document->getName()) }})@if(!$loop->last)<br/>@endif
                        </td>
                    </tr>
                @endforeach
            @empty
                <{{trans('all.empty')}}>
            @endforelse
            </td>
        </tr>
        <tr @if(count($required_files['images']) == 0) class="danger" @endif>
            <td>{{trans('all.required_documents')}}</td>
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
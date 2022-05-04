<div class="admining_list">
    <h2>{{trans('all.ccard_user_list')}}</h2>

    <table class="table table-bordered">
        <tr class="">
            <td colspan="2">
                @include('admin.includes.ccards', ['list'=> $user->ccards])
            </td>
        </tr>
    </table>
</div>
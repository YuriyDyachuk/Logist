<div role="tabpanel" class="tab-pane fade transition" id="history">
    <div class="tab-pane__row">
        <table class="table font-table" id="historyClient">
            <?php $num = 1; ?>
            <thead>
            <tr>
                <th class="control-label">#</th>
                <th class="control-label">{{ trans('all.event_table') }}</th>
                <th class="control-label">{{ trans('all.participant') }}</th>
                <th class="control-label">{{ trans('all.date_and_time') }}</th>
                <th class="control-label">{{ trans('all.status') }}</th>
                <th class="control-label">{{ trans('all.comment') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$num++}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
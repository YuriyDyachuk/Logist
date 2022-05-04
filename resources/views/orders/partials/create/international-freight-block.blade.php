<p class="duplex">
	<span>
		<label class="control-label">Таможня места отправления</label>
		<input class="form-control" type="text" name="meta_data[customs][departure]" value="2222" placeholder="">
		{{-- Validation msg --}}
		<span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>

    <span>
		<label class="control-label">Таможенный переход</label>
		<input class="form-control" type="text" name="meta_data[customs][transition]" placeholder="">
        {{-- Validation msg --}}
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>
</p>

<p class="duplex">
	<span>
		<label class="control-label">Таможня места назначения</label>
		<input class="form-control" type="text" name="meta_data[customs][destination]" placeholder="">
		{{-- Validation msg --}}
		<span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>

    <span>
		<label class="control-label">Таможенный режим оформления</label>
		<input class="form-control" type="text" name="meta_data[customs][mode]" placeholder="">
        {{-- Validation msg --}}
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>
</p>

<p class="duplex">
	<span>
		<label class="control-label">Оформление СЭС</label>
		<input class="form-control" type="text" name="meta_data[ses]" placeholder="">
		{{-- Validation msg --}}
		<span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>

    <span>
		<label class="control-label">Штамп гигиена/экология/радиология/карантин</label>
		<input class="form-control" type="text" name="meta_data[h_e_r_q]" placeholder="">
        {{-- Validation msg --}}
        <span style="display: none" class="help-block small"><strong>{{ trans('validation.required') }}</strong></span>
	</span>
</p>
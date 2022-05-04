<!-- Filter section: BEGIN -->
<div class="content-box__filter row flex">
    <div class="content-box__filter-search">
        <form name="search">
            <i class="as as-search-sm"></i>
            <input type="text" name="client-search" placeholder="Найти сотрудника..." class="transition">
        </form>
    </div>
    <div class="content-box__filter-branch">
        <label for="filter_branch" class="h5 title-grey">{{ trans('all.branch') }}</label>
        <select name="filter_branch" class="selectpicker">
            <option selected disabled>{{trans('all.all')}}</option>
        </select>
    </div>
    <div class="content-box__filter-department">
        <label for="filter_department" class="h5 title-grey">{{trans('all.departments')}}:</label>
        <select name="filter_department" class="selectpicker">
            <option selected disabled>{{trans('all.all_departments')}}</option>
        </select>
    </div>
</div>
<!-- Filter section: END -->
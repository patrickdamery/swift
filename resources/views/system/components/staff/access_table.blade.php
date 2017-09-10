@php
  $code = 0;
  $user_access = \App\UserAccess::where('code', $code)->first();
  //$access = $user_access->access;
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('staff/staff_configuration.access')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('staff/staff_configuration.modules')</th>
        <th>@lang('staff/staff_configuration.pages')</th>
        <th>@lang('staff/staff_configuration.sub_pages')</th>
        <th>@lang('staff/staff_configuration.options')</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

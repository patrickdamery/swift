@php
  $user_access = \App\UserAccess::where('code', $code)->first();
  $user_access = json_decode($user_access->access, true);

  $access_table = array();

  foreach($user_access as $module => $pages) {
    foreach($pages as $page => $sub_pages) {
      $access_table[$module][$page] = array();
      if(is_array($sub_pages)) {
        foreach($sub_pages as $sub_page => $options) {
          $access_table[$module][$page][$sub_page] = $options;
        }
      }
    }
  }
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('staff/staff_configuration.access')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table" style="overflow-x: scroll">
  <div class="row">
    <div class="col-xs-3">
      <h5><b>@lang('staff/staff_configuration.modules')</b></h5>
    </div>
    <div class="col-xs-3">
      <h5><b>@lang('staff/staff_configuration.pages')</b></h5>
    </div>
    <div class="col-xs-3">
      <h5><b>@lang('staff/staff_configuration.sub_pages')</b></h5>
    </div>
    <div class="col-xs-3">
      <h5><b>@lang('staff/staff_configuration.options')</b></h5>
    </div>
  </div>
  @foreach($access_table as $module => $pages)
    <div class="row">
      <div class="col-xs-3">
        {{ $module }}
      </div>
      <div class="col-xs-9">
        @foreach($pages as $page => $sub_pages)
          <div class="row">
            <div class="col-xs-4">
              {{ $page }}
            </div>
            <div class="col-xs-8">
              @foreach($sub_pages as $sub_page => $options)
                <div class="row">
                  <div class="col-xs-6">
                    {{ $sub_page }}
                  </div>
                  <div class="col-xs-6">
                    @if(is_array($options))
                      @foreach($options as $option => $choice)
                        <div class="row">
                          <div class="col-xs-12">
                            {{ $option }}
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
</div>

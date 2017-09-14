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
<div class="box-body table-responsive no-padding access-config">
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
    @php
      $page_count = 0;
    @endphp
    <div class="row access-module">
      <div class="col-xs-3">
        @lang('staff/staff_configuration.module_'.$module)
      </div>
      <div class="col-xs-9 left-border">
        @foreach($pages as $page => $sub_pages)
          @php
            $page_count++;
          @endphp
          <div class="row {{ (count($pages) == $page_count) ? '' : 'access-page' }}">
            <div class="col-xs-4">
              @if($page == 'has')
                <div class="form-group">
                  <select class="form-control access-select" id="{{ $module }}-{{ $page }}">
                    <option value="0" {{ (!$user_access[$module]['has']) ? 'selected' : '' }}>
                      @lang('staff/staff_configuration.no')
                    </option>
                    <option value="1" {{ ($user_access[$module]['has']) ? 'selected' : '' }}>
                      @lang('staff/staff_configuration.yes')
                    </option>
                  </select>
                </div>
              @else
                @lang('staff/staff_configuration.page_'.$page)
              @endif
            </div>
            <div class="col-xs-8 left-border">
              @foreach($sub_pages as $sub_page => $options)
                @if($sub_page == 'has')
                  <div class="row">
                    <div class="col-xs-6">
                      <div class="form-group">
                        <select class="form-control access-select" id="{{ $module }}-{{ $page }}-{{ $sub_page }}">
                          <option value="0" {{ (!$user_access[$module][$page]['has']) ? 'selected' : '' }}>
                            @lang('staff/staff_configuration.no')
                          </option>
                          <option value="1" {{ ($user_access[$module][$page]['has']) ? 'selected' : '' }}>
                            @lang('staff/staff_configuration.yes')
                          </option>
                        </select>
                      </div>
                @else
                  <div class="row access-sub-page">
                    <div class="col-xs-6">
                      @lang('staff/staff_configuration.sub_page_'.$sub_page)
                @endif
                  </div>
                    <div class="col-xs-6">
                      @if(is_array($options))
                        @foreach($options as $option => $choice)
                          <div class="row access-option">
                            <div class="col-xs-12">
                              @if($option == 'has')
                                <div class="form-group">
                                  <select class="form-control access-select" id="{{ $module }}-{{ $page }}-{{ $sub_page }}-{{ $option }}">
                                    <option value="0" {{ (!$user_access[$module]['has']) ? 'selected' : '' }}>
                                      @lang('staff/staff_configuration.no')
                                    </option>
                                    <option value="1" {{ ($user_access[$module]['has']) ? 'selected' : '' }}>
                                      @lang('staff/staff_configuration.yes')
                                    </option>
                                  </select>
                                </div>
                              @else
                                <div class="form-group">
                                  <label for="option-{{ $sub_page }}" class="control-label">
                                    @lang('staff/staff_configuration.option_'.$option)
                                  </label>
                                  <select class="form-control access-select" id="{{ $module }}-{{ $page }}-{{ $sub_page }}-{{ $option }}">
                                    <option value="0" {{ (!$user_access[$module]['has']) ? 'selected' : '' }}>
                                      @lang('staff/staff_configuration.no')
                                    </option>
                                    <option value="1" {{ ($user_access[$module]['has']) ? 'selected' : '' }}>
                                      @lang('staff/staff_configuration.yes')
                                    </option>
                                  </select>
                                </div>
                              @endif
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

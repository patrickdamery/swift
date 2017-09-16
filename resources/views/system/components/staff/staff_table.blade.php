@php
  function get_state($state) {
    switch($state) {
      case 1:
        return \Lang::get('staff/staff.active');
      break;
      case 2:
        return \Lang::get('staff/staff.unactive');
      break;
    }
  }

  $workers = array();
  if(isset($code)) {
    if($code == '') {
      if($branch == 'all') {
        $workers = \App\Worker::where('code', '>=', '0');
      } else {
        $workers = \App\Worker::where('current_branch_code', $branch);
      }
    } else {
      if($branch == 'all') {
        $workers = \App\Worker::where('code', $code);
      } else {
        $workers = \App\Worker::where('code', $code)
        ->where('current_branch_code', $branch);
      }
    }
  } else {
    $workers = \App\Worker::where('code', '>=', '0');
  }

  $records = $workers->count();
  $pages = ceil($records/50);

  if($offset == 'first') {
    $offset = 0;
  } else if ($offset == 'last') {
    $offset = $pages-1;
  } else {
    $offset--;
  }
  $workers = $workers->offset($offset*50)
    ->limit(50)
    ->orderBy('code')
    ->get();
@endphp
<div class="box-header">
  <h3 class="box-title">@lang('staff/staff.staff')</h3>
</div>
<div class="box-body table-responsive no-padding swift-table">
  <table class="table table-hover">
    <thead>
      <tr>
        <th>@lang('staff/staff.name')</th>
        <th>@lang('staff/staff.legal_id')</th>
        <th>@lang('staff/staff.phone')</th>
        <th>@lang('staff/staff.job_title')</th>
        <th>@lang('staff/staff.state')</th>
        <th>@lang('staff/staff.user')</th>
      </tr>
    </thead>
    <tbody>
      @foreach($workers as $worker)
        <tr id="worker-{{ $worker->code }}">
          <td class="staff-name-edit">{{ $worker->name }}</td>
          <td class="staff-id-edit">{{ $worker->legal_id }}</td>
          <td class="staff-phone-edit">{{ $worker->phone }}</td>
          <td class="staff-job-edit">{{ $worker->job_title }}</td>
          <td class="staff-state-edit">{{ get_state($worker->state) }}</td>
          <td>
            @php
              // Check if user exists.
              $user = \App\User::where('worker_code', $worker->code)->first();
            @endphp
            @if($user)
              <button type="button" class="btn btn-info edit-user">
                <i class="fa fa-edit"></i> @lang('staff/staff.edit')
              </button>
            @else
            <button type="button" class="btn btn-success create-user" data-toggle="modal" data-target="#worker-user">
              <i class="fa fa-plus"></i> @lang('staff/staff.create_user')
            </button>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="box-footer clearfix">
  <ul class="pagination pagination-sm no-margin pull-right staff-pagination">
    <li><a href="#" id="staff-pagination-first">«</a></li>
    @if($offset+1 == 1)
      <li><a href="#" id="staff-pagination-1">1</a></li>
      @for($i = 2; $i <= $pages; $i++)
        @if($i < 4)
          <li><a href="#" id="staff-pagination-{{ $i }}">{{ $i }}</a></li>
        @endif
      @endfor
    @else
      <li><a href="#" id="staff-pagination-{{ $offset }}">{{ $offset }}</a></li>
      <li><a href="#" id="staff-pagination-{{ $offset+1 }}">{{ $offset+1 }}</a></li>
      @if($offset+2 <= $pages)
        <li><a href="#" id="staff-pagination-{{ $offset+2 }}">{{ $offset+2 }}</a></li>
      @endif
    @endif
    <li><a href="#" id="staff-pagination-last">»</a></li>
  </ul>
</div>

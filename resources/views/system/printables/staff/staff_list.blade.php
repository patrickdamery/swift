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

  function get_user($code) {
    $user = \App\User::where('worker_code', $code)->first();
    if($user) {
      return $user->username;
    } else {
      return 'N/A';
    }
  }

  $workers = array();
  $current_branch = \Lang::get('staff/staff.all');
  if(isset($code)) {
    if($code == '') {
      if($branch == 'all') {
        $workers = \App\Worker::where('code', '>=', '0')->get();
      } else {
        $current_branch = \App\Branch::where('code', $branch)->first();
        $workers = \App\Worker::where('current_branch_code', $branch)->get();
      }
    } else {
      if($branch == 'all') {
        $workers = \App\Worker::where('code', $code)->get();
      } else {
        $workers = \App\Worker::where('code', $code)
        ->where('current_branch_code', $branch)->get();
        $current_branch = \App\Branch::where('code', $branch)->first()->name;
      }
    }
  } else {
    $workers = \App\Worker::where('code', '>=', '0')->get();
  }
@endphp
<div class="printable-document">
  <div class="printable-header">
    <div class="staff-list-report">
      <h3>@lang('staff/staff.staff_list')</h3>
    </div>
    <div class="staff-list-branch">
      <p>@lang('staff/staff.staff_branch'): {{ $current_branch }}</p>
    </div>
    <div class="staff-list-date">
      <p>@lang('staff/staff.date'):
        {{ date('d/m/Y') }}
      </p>
    </div>
  </div>
  <div class="printable-body">
    <table class="staff-list">
      <tr>
        <th>@lang('staff/staff.name')</th>
        <th>@lang('staff/staff.legal_id')</th>
        <th>@lang('staff/staff.phone')</th>
        <th>@lang('staff/staff.job_title')</th>
        <th>@lang('staff/staff.address')</th>
        <th>@lang('staff/staff.inss')</th>
        <th>@lang('staff/staff.state')</th>
        <th>@lang('staff/staff.user')</th>
      </tr>
      <tbody>
        @foreach($workers as $worker)
          <tr>
            <td>{{ $worker->name }}</td>
            <td>{{ $worker->legal_id }}</td>
            <td>{{ $worker->phone }}</td>
            <td>{{ $worker->job_title }}</td>
            <td>{{ $worker->address }}</td>
            <td>{{ $worker->inss }}</td>
            <td>{{ get_state($worker->state) }}</td>
            <td>{{ get_user($worker->code) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

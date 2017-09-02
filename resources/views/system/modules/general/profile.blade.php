<?php
  // Get data we need to display.
  use App\Configuration;
  use App\Branch;
  use App\User;
  use App\Worker;

  $config = Configuration::find(1);
  $modules = json_decode($config->modules);
  $worker = Worker::where('code', Auth::user()->worker_code)->first();
 ?>
<script>
$(function(){
  $('.daterangepicker-sel').daterangepicker({
         format: 'dd-mm-yyyy'
  });
  $(".knob").knob();
});
swift_menu.new_submenu();
swift_menu.get_language().add_sentence('profile-commission-tab', {
                                      'en': 'View Commissions',
                                      'es': 'Ver Comisiones',
                                    });
swift_menu.get_language().add_sentence('profile-schedule-tab', {
                                      'en': 'View Schedule',
                                      'es': 'Ver Horario',
                                    });
swift_menu.get_language().add_sentence('profile-calendar-tab', {
                                      'en': 'View Calendar',
                                      'es': 'Ver Calendario',
                                    });
swift_event_tracker.register_swift_event('#profile-commission-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#profile-commission-tab', function(e) {
  swift_event_tracker.fire_event(e, '#profile-commission-tab');
});
swift_event_tracker.register_swift_event('#profile-schedule-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#profile-schedule-tab', function(e) {
  swift_event_tracker.fire_event(e, '#profile-schedule-tab');
});
swift_event_tracker.register_swift_event('#profile-calendar-tab', 'click', swift_menu, 'select_submenu_option');
$(document).on('click', '#profile-calendar-tab', function(e) {
  swift_event_tracker.fire_event(e, '#profile-calendar-tab');
  calendar();
});
function calendar() {

		$('.calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2017-05-12',
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'All Day Event',
					start: '2017-05-01'
				},
				{
					title: 'Long Event',
					start: '2017-05-07',
					end: '2017-05-10'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-05-09T16:00:00'
				},
				{
					id: 999,
					title: 'Repeating Event',
					start: '2017-05-16T16:00:00'
				},
				{
					title: 'Conference',
					start: '2017-05-11',
					end: '2017-05-13'
				},
				{
					title: 'Meeting',
					start: '2017-05-12T10:30:00',
					end: '2017-05-12T12:30:00'
				},
				{
					title: 'Lunch',
					start: '2017-05-12T12:00:00'
				},
				{
					title: 'Meeting',
					start: '2017-05-12T14:30:00'
				},
				{
					title: 'Happy Hour',
					start: '2017-05-12T17:30:00'
				},
				{
					title: 'Dinner',
					start: '2017-05-12T20:00:00'
				},
				{
					title: 'Birthday Party',
					start: '2017-05-13T07:00:00'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2017-05-28'
				}
			]
		});

	}
</script>
<section class="content-header">
  <h1>
    @lang('profile.title')
    <small class="crumb">@lang('measurement_units.view_units')</small>
  </h1>
  <ol class="breadcrumb">
    <li><i class="fa fa-user"></i> @lang('profile.title')</li>
    <li class="active crumb">@lang('profile.view_profile')</li>
  </ol>
</section>
<section class="content">
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="{{ URL::to('/') }}/images/default-profile.png" alt="User profile picture">
          <h3 class="profile-username text-center">{{ $worker->name }}</h3>
          <p class="text-muted text-center">{{ $worker->job_title }}</p>
          <p class="text-muted text-center">{{ $worker->phone }}</p>
          <p class="text-muted text-center">{{ $worker->legal_id }}</p>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#profile-commission" id="profile-commission-tab" data-toggle="tab">@lang('profile.commissions')</a></li>
          <li><a href="#profile-schedule" id="profile-schedule-tab" data-toggle="tab">@lang('profile.schedule')</a></li>
          <li><a href="#profile-calendar" id="profile-calendar-tab" data-toggle="tab">@lang('profile.calendar')</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="profile-commission">
            <div class="row form-inline">
              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="profile-branch" class="control-label">@lang('profile.branch')</label>
                  <select class="form-control" id="profile-branch" disabled>
                    @foreach(\App\Branch::all() as $branch)
                      <option value="{{ $branch->code }}">{{ $branch->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="profile-date-range" class="control-label">@lang('profile.date_range')</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control daterangepicker-sel" id="profile-date-range">
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-inline lg-top-space md-top-space sm-top-space">
              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="profile-rank" class="control-label">@lang('profile.rank')</label>
                  <input type="text" class="form-control" id="profile-rank" disabled>
                </div>
              </div>
              <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                  <label for="profile-total-sales" class="control-label">@lang('profile.total_sales')</label>
                  <input type="text" class="form-control" id="profile-total-sales" disabled>
                </div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space text-center">
              <h3>Metas Commissiones</h3>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space text-center">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input id="profile-commission-1" type="text" value="30" class="knob" data-width="90" data-height="90" data-fgcolor="#3c8dbc" readonly>
                <div class="knob-label">Meta Hilco</div>
                <div class="knob-label">Comision Hilco: C$ 500</div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input id="profile-commission-2" type="text" value="60" class="knob" data-width="90" data-height="90" data-fgcolor="#3c8dbc" readonly>
                <div class="knob-label">Meta Truper</div>
                <div class="knob-label">Comision Truper: C$ 300</div>
              </div>
            </div>
            <div class="row lg-top-space md-top-space sm-top-space xs-top-space text-center">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input id="profile-commission-1" type="text" value="47.5" class="knob" data-width="90" data-height="90" data-fgcolor="#3c8dbc" readonly>
                <div class="knob-label">Meta Perneria</div>
                <div class="knob-label">Comision Perneria: C$ 600</div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <input id="profile-commission-2" type="text" value="100" class="knob" data-width="90" data-height="90" data-fgcolor="#3c8dbc" readonly>
                <div class="knob-label">Comision Ventas Generales</div>
                <div class="knob-label">Comision Ventas: C$ 800</div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="profile-schedule">
            <div class="row" style="padding-top:15px;">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 center-block" style="padding-top:15px;">
                <div class="box">
                  <div class="box-body table-responsive no-padding swift-table">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>@lang('profile.time')</th>
                          <th>@lang('profile.monday')</th>
                          <th>@lang('profile.tuesday')</th>
                          <th>@lang('profile.wednesday')</th>
                          <th>@lang('profile.thursday')</th>
                          <th>@lang('profile.friday')</th>
                          <th>@lang('profile.saturday')</th>
                          <th>@lang('profile.sunday')</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="profile-calendar">
            <div class="row center-block">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="calendar" style="min-width:300px;min-height:300px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<div>
</div>
</section>

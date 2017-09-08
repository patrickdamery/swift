<script>
  var option = {
    'bank_accounts': '/swift/system/bank_accounts'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#bank_accounts', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#bank_accounts', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#bank_accounts');
  });

  option = {
    'currency': '/swift/system/currency'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#currency', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#currency', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#currency');
  });

  option = {
    'accounts': '/swift/system/accounts'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#accounts', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#accounts', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#accounts');
  });

  option = {
    'journal': '/swift/system/journal'
  };
  swift_menu.register_menu_option(option);
  swift_event_tracker.register_swift_event('#journal', 'click', swift_menu, 'select_menu_option');
  $(document).on('click', '#journal', function(e) {
    e.preventDefault();
    swift_event_tracker.fire_event(e, '#journal');
  });
</script>

<li class="treeview">
  <a id="menu_accounting" href="menu_accounting">
    <i class="fa fa-book"></i>
    <span>@lang('swift_menu.accountancy')</span>
  </a>
  <ul class="treeview-menu">
    <li><a href="#bank_accounts" id="bank_accounts"><i class="fa fa-bank"></i> @lang('swift_menu.bank_accounts')</a></li>
    <li><a href="#currency" id="currency"><i class="fa fa-money"></i> @lang('swift_menu.currency')</a></li>
    <li><a href="#accounts" id="accounts"><i class="fa fa-square"></i> @lang('swift_menu.accounts')</a></li>
    <li><a href="#journal" id="journal"><i class="fa fa-book"></i> @lang('swift_menu.journal')</a></li>
  </ul>
</li>

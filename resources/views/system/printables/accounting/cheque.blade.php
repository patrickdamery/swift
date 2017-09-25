@php
  // Get the journal entries.
  $ledger = DB::table('journal_entries')
    ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->select('journal_entries.*', 'journal_entries_breakdown.*')
    ->where('journal_entries_breakdown.account_code', $code)
    ->whereBetween('journal_entries.entry_date', $date_range)
    ->get();
@endphp
<div class="printable-document">
  <div class="printable-header">
    <div class="ledger-report">
      <h3>@lang('accounting/accounts.ledger_report')</h3>
    </div>
    <div class="ledger-account">
      <p>@lang('accounting/accounts.ledger_account'): {{ \App\Account::where('code', $code)->first()->name }}</p>
    </div>
    <div class="ledger-date-range">
      <p>@lang('accounting/accounts.date_range'):
        {{ date('d/m/Y', strtotime($date_range[0])) }} - {{ date('d/m/Y', strtotime($date_range[1])) }}
      </p>
    </div>
  </div>
  <div class="printable-body">
    <table class="ledger">
      <tr>
        <th>@lang('accounting/accounts.date')</th>
        <th>@lang('accounting/accounts.description')</th>
        <th>@lang('accounting/accounts.debit')</th>
        <th>@lang('accounting/accounts.credit')</th>
        <th>@lang('accounting/accounts.value')</th>
      </tr>
      <tbody>
      @foreach($ledger as $entry)
        <tr id="entry-code-{{ $entry->code }}">
          <td>{{ $entry->entry_date }}</td>
          <td>{{ $entry->description }}</td>
          <td>{{ ($entry->debit == 1) ? $entry->amount : '' }}</td>
          <td>{{ ($entry->debit == 0) ? $entry->amount : '' }}</td>
          <td>{{ $entry->balance }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

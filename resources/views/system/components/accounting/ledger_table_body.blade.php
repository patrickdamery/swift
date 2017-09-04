@php
  // Get the journal entries.
  $ledger = DB::table('journal_entries')
    ->join('journal_entries_breakdown', 'journal_entries.code', 'journal_entries_breakdown.journal_entry_code')
    ->select('journal_entries.*', 'journal_entries_breakdown.*')
    ->where('journal_entries_breakdown.account_code', $code)
    ->whereBetween('journal_entries.entry_date', $date_range)
    ->offset($offset)
    ->limit(100)
    ->get();
@endphp
@foreach($ledger as $entry)
  <tr id="entry-code-{{ $entry->code }}">
    <td>{{ $entry->entry_date }}</td>
    <td>{{ $entry->description }}</td>
    <td>{{ ($entry->debit == 1) ? $entry->amount : '' }}</td>
    <td>{{ ($entry->debit == 0) ? $entry->amount : '' }}</td>
    <td>{{ $entry->balance }}</td>
  </tr>
@endforeach

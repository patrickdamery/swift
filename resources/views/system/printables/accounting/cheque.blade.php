@php
  // Get the Cheque data.
  $cheque = \App\Cheque::where('code', $code)->first();
  $journal_entry = \App\JournalEntry::where('code', $cheque->journal_entry_code)->first();
  $entry_breakdown = \App\JournalEntryBreakdown::where('journal_entry_code', $journal_entry->code)
    ->where('debit', 0)->first();

@endphp
<div class="printable-document">
  <div class="cheque-date">
    <div class="cheque-place">
      Managua
    </div>
    <div class="cheque-day">
      {{ date('d', strtotime($journal_entry->entry_date)) }}
    </div>
    <div class="cheque-month">
      {{ date('m', strtotime($journal_entry->entry_date)) }}
    </div>
    <div class="cheque-year">
      {{ date('Y', strtotime($journal_entry->entry_date)) }}
    </div>
  </div>
  <div class="cheque-pay-to">
    <div class="pay-to">
      {{ $cheque->paid_to }}
    </div>
    <div class="pay-amount">
      {{ $entry_breakdown->amount }}
    </div>
  </div>
  <div class="cheque-sum">
    @php
      $f = new \NumberFormatter('es', NumberFormatter::SPELLOUT);
      echo ucfirst($f->format($entry_breakdown->amount));
    @endphp
  </div>
  <div class="cheque-concept">
    {{ $entry_breakdown->description }}
  </div>
</div>

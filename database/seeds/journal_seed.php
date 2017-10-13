<?php

use Illuminate\Database\Seeder;

class journal_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $begin_date = date('Y-m-d H:i:s', strtotime('2 weeks ago'));
      $end_date = date('Y-m-d H:i:s');
      $current_date = $begin_date;

      while($current_date != $end_date) {
        for($i = 0; $i < 1000; $i++) {
          $total = rand(100, 1000);
          $last_entry = DB::table('journal_entries')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->lockForUpdate()
            ->get();

          // Create Journal Entry.
          $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
          DB::table('journal_entries')->insert([
            ['code' => $entry_code, 'state' => 1]
          ]);

          // Now update the accounts.
          DB::table('accounts')->where('code', $bank_account->account_code)
            ->decrement('amount', Input::get('amount'));
          $debit = DB::table('accounts')->where('code', $bank_account->account_code)
            ->first()->amount;

          DB::table('accounts')->where('code', Input::get('account'))
            ->decrement('amount', Input::get('amount'));
          $credit = DB::table('accounts')->where('code', Input::get('account'))
            ->first()->amount;

          // Make the entry breakdowns.
          DB::table('journal_entries_breakdown')->insert([
            [
              'journal_entry_code' => $entry_code,
              'debit' => 0,
              'account_code' => $bank_account->account_code,
              'description' => Input::get('description'),
              'amount' => Input::get('amount'),
              'balance' => $debit
            ]
          ]);

          DB::table('journal_entries_breakdown')->insert([
            [
              'journal_entry_code' => $entry_code,
              'debit' => 1,
              'account_code' => Input::get('account'),
              'description' => Input::get('description'),
              'amount' => Input::get('amount'),
              'balance' => $credit
            ]
          ]);
        }
      }
    }
}

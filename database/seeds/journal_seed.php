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
        for($i = 0; $i < 10000; $i++) {
          $total = rand(100, 1000);
          $last_entry = DB::table('journal_entries')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->lockForUpdate()
            ->get();

          // Create Journal Entry.
          $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;
          DB::table('journal_entries')->insert([
            ['code' => $entry_code, 'entry_date' => $current_date, 'state' => 1]
          ]);

          // Now update the accounts.
          if((rand(0,2) % 2) != 1) {
            $bank_account = ((rand(0,2) % 2) != 1) ? '102.1' : '102.2';
            DB::table('accounts')->where('code', $bank_account)
              ->increment('amount', $total);
            $credit = DB::table('accounts')->where('code', $bank_account)
              ->first()->amount;

            $account = ((rand(0,2) % 2) != 1) ? '444.2.1' : '444.2.2';
            DB::table('accounts')->where('code', $account)
              ->increment('amount', $total);
            $debit = DB::table('accounts')->where('code', $account)
              ->first()->amount;

            // Make the entry breakdowns.
            DB::table('journal_entries_breakdown')->insert([
              [
                'journal_entry_code' => $entry_code,
                'debit' => 0,
                'account_code' => $bank_account,
                'description' => 'Test Entry',
                'amount' => $total,
                'balance' => $credit
              ]
            ]);

            DB::table('journal_entries_breakdown')->insert([
              [
                'journal_entry_code' => $entry_code,
                'debit' => 1,
                'account_code' => $account,
                'description' => 'Test Entry',
                'amount' => $total,
                'balance' => $debit
              ]
            ]);
          } else {
            $bank_account = ((rand(0,2) % 2) != 1) ? '102.1' : '102.2';
            DB::table('accounts')->where('code', $bank_account)
              ->decrement('amount', $total);
            $debit = DB::table('accounts')->where('code', $bank_account)
              ->first()->amount;

            $account = ((rand(0,2) % 2) != 1) ? '444.2.1' : '444.2.2';
            DB::table('accounts')->where('code', $account)
              ->decrement('amount', $total);
            $credit = DB::table('accounts')->where('code', $account)
              ->first()->amount;

            // Make the entry breakdowns.
            DB::table('journal_entries_breakdown')->insert([
              [
                'journal_entry_code' => $entry_code,
                'debit' => 0,
                'account_code' => $bank_account,
                'description' => 'Test Entry',
                'amount' => $total,
                'balance' => $debit
              ]
            ]);

            DB::table('journal_entries_breakdown')->insert([
              [
                'journal_entry_code' => $entry_code,
                'debit' => 1,
                'account_code' => $account,
                'description' => 'Test Entry',
                'amount' => $total,
                'balance' => $credit
              ]
            ]);
          }
        }
        $current_date = date('Y-m-d H:i:s', strtotime($current_date.' +1 day'));
      }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Asset;
use App\JournalEntry;
use DB;
class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function moo() {
      DB::beginTransaction();
      //DB::table('journal_entries')->orderBy('id', 'desc')->limit(1)->lockForUpdate();
      $last_entry = DB::table('journal_entries')->orderBy('id', 'desc')->limit(1)->lockForUpdate()->get();
      print_r($last_entry);
      sleep(10);
      //DB::table('assets')->where('code', 1)->increment('value', 10);
      $entry_code = ($last_entry) ? $last_entry[0]->code : 0;

      DB::table('journal_entries')->insert([
        ['code' => $entry_code+1, 'state' => 1]
      ]);
      DB::commit();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      try {
        $this->moo();
      } catch (\Exception $e) {
        try {
          $this->moo();
        } catch (\Exception $e) {
          try {
            $this->moo();
          } catch (\Exception $e) {
            echo 'failed';
          }
        }
      }
      /*//for($i = 0; $i < 10000; $i++) {
        DB::beginTransaction();
        //DB::table('journal_entries')->orderBy('id', 'desc')->limit(1)->lockForUpdate();
        $last_entry = DB::table('journal_entries')->orderBy('id', 'desc')->limit(1)->lockForUpdate()->get();
        print_r($last_entry);
        sleep(10);
        //DB::table('assets')->where('code', 1)->increment('value', 10);
        $entry_code = ($last_entry) ? $last_entry[0]->code : 0;

        DB::table('journal_entries')->insert([
          ['code' => $entry_code+1, 'state' => 1]
        ]);
        DB::commit();
      //}
      /*
      DB::beginTransaction();
      DB::table('assets')->where('code', 1)->lockForUpdate();
      sleep(10);
      DB::table('assets')->where('code', 1)->increment('value', 10);
      //$asset->save();

      DB::commit();
      */
      // Get asset.
      /*
      $asset = Asset::where('code', 1)->lockForUpdate()->first();
      sleep(30);
      $asset->value += 10;
      $asset->save();
      */
    }
}

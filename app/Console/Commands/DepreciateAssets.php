<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Asset;
use App\AssetDepreciation;

class DepreciateAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:depreciate_assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Depreciates every asset by the specified monthly amount if it hasn\'t been depreciated already that month.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get active assets.
        $assets = Asset::where('state', 1)->get();

        // Get current month and year.
        $current_month = date('Y-m').'-01';
        $next_month = date('Y-m', strtotime('+1 month')).'-01';
        $date_range = array($current_month, $next_month);

        // Loop through assets and check if we should depreciate them.
        foreach($assets as $asset) {
          // Check if asset has been depreciated.
          $assets_depreciation = DB::table('journal_entries')
          ->join('assets_depreciation', function($join){
              $join->on('journal_entries.code', 'assets_depreciation.journal_entry_code');
              $join->on('journal_entries.branch_identifier', 'assets_depreciation.branch_identifier');
            })
            ->select('journal_entries.*', 'assets_depreciation.*')
            ->where('assets_depreciation.asset_code', $asset->code)
            ->whereBetween('journal_entries.entry_date', $date_range)
            ->orderBy('journal_entries.entry_date')
            ->get();

          $depreciated = false;
          foreach($assets_depreciation as $asset_depreciation) {
            if(date('Y-m', strtotime($asset_depreciation->entry_date)).'-01' == $current_month) {
              $depreciated = true;
            }
          }
          if(!$depreciated) {
            // Depreciate the asset if it hasn't been depreciated.
            $tries = 0;
            $complete = false;
            while($tries < 5 && !$complete) {
              try {
                DB::beginTransaction();
                // First lock any data we will be working with.
                $last_entry = DB::table('journal_entries')
                  ->where('branch_identifier', 'ai')
                  ->orderBy('id', 'desc')
                  ->lockForUpdate()
                  ->get();

                // Now create the journal entry.
                $entry_code = (count($last_entry) > 0) ? $last_entry[0]->code+1 : 1;

                DB::table('journal_entries')->insert([
                  ['code' => $entry_code, 'branch_identifier' => 'ai', 'state' => 1]
                ]);

                DB::table('journal_entries_breakdown')->insert([
                  [
                    'journal_entry_code' => $entry_code,
                    'branch_identifier' => 'ai',
                    'debit' => 0,
                    'account_code' => $asset->depreciation_code,
                    'description' => 'Depreciacion del mes '.date('Y-m').' de '.$asset->name,
                    'amount' => $asset->depreciation
                  ]
                ]);

                DB::table('journal_entries_breakdown')->insert([
                  [
                    'journal_entry_code' => $entry_code,
                    'branch_identifier' => 'ai',
                    'debit' => 1,
                    'account_code' => $asset->expense_code,
                    'description' => 'Depreciacion del mes '.date('Y-m').' de '.$asset->name,
                    'amount' => $asset->depreciation
                  ]
                ]);
                DB::commit();
                $complete = true;
              } catch(\Exception $e) {
                $tries++;
                if($tries == 5) {
                  // TODO: Create Notification to Administrator.
                }
              }
            }
          }
        }
    }
}

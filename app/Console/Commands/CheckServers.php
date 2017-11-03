<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use App\BranchSetting;
class CheckServers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check_servers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks that branch servers are online.';

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
      $branch_settings = BranchSetting::all();

      foreach($branch_settings as $branch) {
        $client = new Client();
        $res = $client->request('GET', $branch->server_address, []);
        if($res->getStatusCode() == '200') {
          $branch->last_server_contact = date('Y-m-d H:i:s');
          $branch->save();
        }
      }
    }
}

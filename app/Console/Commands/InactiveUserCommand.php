<?php

namespace App\Console\Commands;

use App\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InactiveUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:inactive-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email inactive users';

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
        $limit = Carbon::now()->subDay(1);
        $inactive_user = Client::where('last_login', '<', $limit)->get();
        foreach ($inactive_user as $userClient) {
            $user = $userClient->type;
            $user->alterUser();
        }
    }
}

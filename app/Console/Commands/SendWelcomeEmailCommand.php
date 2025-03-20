<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\SendWelcomeEmail;
use Illuminate\Console\Command;

class SendWelcomeEmailCommand extends Command
{
    protected $signature = 'email:send-welcome {userId}';

    protected $description = 'Send a welcome email to a specific user';

    public function handle()
    {
        $user = User::find($this->argument('userId'));

        if (!$user) {
            $this->error('User not found.');
            return 1;
        }

        \Log::info("Dispatching SendWelcomeEmail job for user: " . $user->email);
        SendWelcomeEmail::dispatch($user);

        $this->info('Welcome email dispatched for user: ' . $user->email);
        return 0;
    }
}

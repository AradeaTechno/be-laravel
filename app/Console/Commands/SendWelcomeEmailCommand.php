<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;

class SendWelcomeEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-welcome {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a welcome email to the specified user by ID';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Retrieve the user ID from the command argument
        $userId = $this->argument('userId');

        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            $this->error("User with ID $userId not found.");
            return Command::FAILURE;
        }

        // Dispatch the SendWelcomeEmailJob
        SendWelcomeEmail::dispatch($user);

        $this->info("Welcome email dispatched to user: {$user->email}");
        return Command::SUCCESS;
    }
}

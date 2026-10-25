<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:password {email? : The email of the admin user} {--password= : Optional new password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Safely update or reset an administrator account password';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email') ?? $this->ask('Enter the administrator email address', 'admin@example.com');

        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("No user found with email: {$email}");

            return self::FAILURE;
        }

        if (! $user->isAdmin()) {
            if (! $this->confirm("User '{$user->name}' is not currently an administrator. Promote to administrator?", true)) {
                $this->warn('Operation cancelled.');

                return self::FAILURE;
            }
            $user->is_admin = true;
        }

        $newPassword = $this->option('password') ?: $this->secret('Enter the new password (min 8 characters)');

        if (strlen((string) $newPassword) < 8) {
            $this->error('Password must be at least 8 characters in length.');

            return self::FAILURE;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info("Password for administrator '{$user->name}' ({$user->email}) was updated successfully.");

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a new user with a hashed password';

    public function handle()
    {
        $user_name = $this->ask('Enter username:');
        $password = $this->secret('Enter password:');
        $type = '1';
        $first_name = $this->ask('Enter first name:');
        $last_name = $this->ask('Enter last name:');
        $middle_name = $this->ask('Enter middle name:');

        $hashedPassword = Hash::make($password);

        User::create([
            'user_name' => $user_name,
            'password' => $hashedPassword,
            'type' => $type,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'middle_name' => $middle_name,
        ]);

        $this->info('User created successfully.');
    }
}

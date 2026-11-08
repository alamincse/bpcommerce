<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    	$pw = '12345678';

        User::updateOrCreate(
            ['email' => 'alamin@gmail.com'],
            [
                'name' => 'Al-Amin Sarker',
                'password' => Hash::make($pw),
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->command->info('Admin user ready: alamin@gmail.com / '. $pw);
    }
}

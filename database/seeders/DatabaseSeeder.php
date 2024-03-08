<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $admin = User::factory()->create([
            'first_name' => 'KC',
            'last_name' => 'Acuin',
            'username' => 'kcacuin',
            'email' => 'kc.acuin@odecci.com',
        ]);

        $user = User::factory()->create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'username' => 'user',
            'email' => 'user@odecci.com',
        ]);

        // Status::factory(5)->create();
        Ticket::factory(20)->for($admin)->create();
        Ticket::factory(20)->for($user)->create();
    }
}

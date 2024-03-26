<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Comment;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        // Create roles
        $adminRoleId = DB::table('roles')->where('name', 'Admin')->value('id');
        $userRoleId = DB::table('roles')->where('name', 'User')->value('id');

        User::factory()->create([
            'first_name' => 'KC',
            'last_name' => 'Acuin',
            'username' => 'kcacuin',
            'email' => 'kc.acuin@odecci.com',
            'role_id' => $adminRoleId,
        ]);
        
        User::factory()->create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'username' => 'user',
            'email' => 'user@odecci.com',
            'role_id' => $userRoleId,
        ]);
        

        Status::truncate();

        $statuses = [
            ['name' => 'Open'],
            ['name' => 'Pending'],
            ['name' => 'In-progress'],
            ['name' => 'In-review'],
            ['name' => 'Closed'],
        ];

        Status::insert($statuses);
        
        // User::factory(20)->create();
        // Status::factory(5)->create();
        // Ticket::factory(20)->for($admin)->create();
        // Ticket::factory(20)->for($user)->create();
    }
}

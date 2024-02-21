<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::truncate();

        $statuses = [
            ['name' => 'Open'],
            ['name' => 'Pending'],
            ['name' => 'In-progress'],
            ['name' => 'In-review'],
            ['name' => 'Closed'],
        ];

        Status::insert($statuses);
    }
}

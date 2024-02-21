<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Status>
 */
class StatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $order = 1;

        $statuses = [
            'Open',
            'Pending',
            'In-progress',
            'In-review',
            'Closed',
        ];

        return [
            'name' => $statuses[$order - 1],
        ];
    }
}

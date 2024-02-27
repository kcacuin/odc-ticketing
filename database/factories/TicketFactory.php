<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'number' => $this->faker->randomNumber(6),
            'date_received' => $this->faker->date(),
            'title' => $this->faker->sentence(),
            'issue' => '<p>' . implode('</p><p>', fake()->paragraphs(3)) . '</p>',
            'requested_by' => $this->faker->name(),
            'client' => $this->faker->company(),
            'product' => $this->faker->word(),
            'status_id' => $this->faker->numberBetween(1, 5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}

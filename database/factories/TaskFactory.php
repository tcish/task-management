<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words($this->faker->numberBetween(1, 5), true),
            'due_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['new', 'in-progress', 'completed']),
            'desc' => $this->faker->sentence($this->faker->numberBetween(10, 70)),
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}

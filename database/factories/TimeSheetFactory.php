<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeSheet>
 */
class TimeSheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeRand = rand(28800, 32400);
        $status = $timeRand > 29400 ? 'Late' : 'On Time';
        return [
            'check_in' => date('H:i:s', $timeRand),

        ];
    }
}

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
        $startTimeIn = strtotime('08:00:00');
        $endTimeIn = strtotime('09:00:00');
        $lateTime = strtotime('08:10:00');

        $overTime = strtotime('17:30:00');
        $endTimeOut = strtotime('18:30:00');

        $timeRandIn = mt_rand($startTimeIn, $endTimeIn);
        $timeRandOut = mt_rand($timeRandIn, $endTimeOut);
        $statusIn = $timeRandIn > $lateTime ? 'Late' : 'On Time';
        $statusOut = $timeRandOut < $overTime ? 'Left early' : 'OverTime';
        return [
            'check_in' => date('H:i:s', $timeRandIn),
            'check_out' => date('H:i:s', $timeRandOut),
            'date' => $this->faker->date('Y-m-d', $max = 'now'),
            'check_in_status' => $statusIn,
            'check_out_status' => $statusOut,
        ];
    }
}

<?php
declare(strict_types=1);

namespace Database\Factories\LMS;

use App\Models\LMS\Course;
use App\Models\LMS\Stage;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Stage> */
class StageFactory extends Factory
{
    protected $model = Stage::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'course_id' => Course::factory(),
        ];
    }
}

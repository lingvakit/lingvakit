<?php
declare(strict_types=1);

namespace Database\Factories\LMS;

use App\Models\LMS\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CourseFactory extends Factory
{
    protected $model = Course::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => '<p>' . fake()->paragraph() . '</p>',
            'difficulty_level' => 'intermediate',
            'type' => 'free',
            'duration' => 0,
            'price' => 0,
            'is_new' => false,
            'is_published' => true,
            'is_allowed' => true,
            'author_id' => User::factory(),
        ];
    }

    public function paid(int $price = 1000): static
    {
        return $this->state(fn(): array => [
            'type' => 'paid',
            'price' => $price
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn(): array => [
            'is_published' => false
        ]);
    }
}
